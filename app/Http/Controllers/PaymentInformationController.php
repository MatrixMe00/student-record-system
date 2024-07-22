<?php

namespace App\Http\Controllers;

use App\Constants\LogType;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\PaymentInformation;
use App\Http\Requests\StorePaymentInformationRequest;
use App\Http\Requests\UpdatePaymentInformationRequest;
use App\Models\ActivityLog;
use App\Models\PaystackBank;
use App\Models\School;
use App\Models\SchoolSetting;
use App\Models\User;
use App\Traits\UserModelTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PaymentInformationController extends Controller
{
    use UserModelTrait;

    /**
     * @var array USER_PRICES Prices in percentage format to be used during splits
     */
    private const USER_PRICES = [
        "developer" => 18.33,
        "superadmin" => 25,
        "system" => 15,
        "admin" => 16.67
    ];

    /**
     * This determines the price percentage for a user
     * @param ?string $role The role of the user
     * @return float
     */
    private function user_price(?string $role = null) :float{
        $role = $role ?? Auth::user()->role->name;
        return self::USER_PRICES[$role] ?? 0;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = $this->index_options();
        return view("payment-accounts.index", $options);
    }

    /**
     * Options to pass to the index page
     */
    private function index_options(){
        $user = Auth::user();

        switch($user->role_id){
            case 1:
            case 2:
                $options = [
                    "accounts" => PaymentInformation::all()
                ];
                break;
            case 3:
                $options = [
                    "accounts" => PaymentInformation::where("school_id", session('school_id'))->get()
                ];
                break;
            default:
                abort(403);
        }

        $options["superadmin"] = $user->role_id <= 2;
        $options["tags"] = [
            ["text" => "Accounts", "icon" => "fas fa-file-invoice-dollar"],
            ["text" => "My Accounts", "icon" => "fas fa-file-invoice", "link" => route("payment-account.user")]
        ];

        return $options;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentInformationRequest $request)
    {
        $validated = $request->validated();
        $validated["school_id"] = session('school_id') ?? null;
        $validated = $this->create_accounts($validated);

        $p_info = PaymentInformation::create($validated);

        ActivityLog::dev_success_log(LogType::SUB_ACCOUNT_CREATE, "{type} payment account created", $p_info);

        return back()->with(["success" => true, "message" => "Account created successfully"]);
    }

    /**
     * Creates accounts on paystack
     * @param array $validated The input data
     * @return array
     */
    private function create_accounts(array $validated) :array{
        $user = Auth::user();
        $sub_account = $this->create_sub_account($validated, $user);

        if($sub_account?->status == true){
            $account_name = $sub_account->data->account_name;
            $sub_account = $sub_account->data->subaccount_code;

            if($user->role_id > 2 && $validated["type"] == "individual"){
                $split_account = $this->create_split_account($sub_account, request()->school_account, $user);

                if($split_account->status == true){
                    $validated["split_key"] = $split_account->data->split_code;
                    $validated["split_id"] = $split_account->data->id;
                }else{
                    throw ValidationException::withMessages([
                        "message" => $split_account->message
                    ]);
                }
            }

            $validated["account_id"] = $sub_account;
            $validated["account_name"] = $account_name;
        }else{
            $message = $sub_account?->message ?? "";
            ActivityLog::dev_error_log(LogType::SUB_ACCOUNT_CREATE, "{username} encountered a fail on creating sub account. $message", Auth::user());
            throw ValidationException::withMessages([
                "message" => $sub_account?->message ?? "Error was encountered, account could not be saved. Check your network"
            ]);
        }

        return $validated;
    }

    /**
     * Creates a business name
     */
    private function create_name($id, $type, $is_user){
        $end = $type == "subaccount" ? "Personal" : "Result";
        $first = str_pad($id, 4, "0", STR_PAD_LEFT);
        $begin = $is_user ? "USR_" : "SCH_";

        return "$begin$first $end";
    }

    /**
     * This creates a sub account
     * @param array $validated The validated data
     * @param User $user The current user
     */
    private function create_sub_account($validated, User $user){
        $url = "https://api.paystack.co/subaccount";
        $is_user = $validated["type"] == "individual";
        $business_name = $this->create_name($user->id, "subaccount", $is_user);

        $fields = [
            'business_name' => $business_name,
            'settlement_bank' => $validated["bank_code"],
            'account_number' => $validated["account_number"],
            'percentage_charge' => $validated["type"] == "individual" ? 0 : 5,
            'primary_contact_email' => request()->email ?? ''
        ];

        $result = self::paystack_api_curl($url, $fields, true);

        return $result;
    }

    /**
     * This is used to create a split key
     * The split key consists of all the superadmins in the system and this admin account
     */

    /**
     * This creates a split account
     * @param string $sub_account The sub account to be used
     * @param string $school_account The school account
     */
    private function create_split_account($sub_account, $school_account, User $user){
        $url = "https://api.paystack.co/split";
        $sub_accounts = $this->create_sub_accounts($sub_account, $school_account);
        $name = $this->create_name($user->id, "split", true);

        $fields = [
            'name' => $name,
            'type' => "flat",
            'currency' => "GHS",
            'subaccounts' => $sub_accounts,
            'bearer_type' => "account"
        ];

        $result = self::paystack_api_curl($url, $fields, true);
        return $result;
    }

    /**
     * Updates the split account details
     * @param string $personal_account The personal account id
     * @param string $school_account The school account id
     */
    private function update_split_account(string $personal_account, string $school_account, ?string $split_id){

    }

    /**
     * This is used to update an account details
     * @param array $validated The validated information
     * @return object
     */
    private function update_sub_account(array $validated) :object{
        $user = Auth::user();
        $account_id = request()->account_id;

        $url = "https://api.paystack.co/subaccount/$account_id";
        $is_user = $validated["type"] == "individual";
        $business_name = $this->create_name($user->id, "subaccount", $is_user);

        $fields = [
            'primary_contact_email' => request()->email ?? '',
            'business_name' => $business_name,
            'settlement_bank' => $validated["bank_code"],
            'account_number' => $validated["account_number"],
            'percentage_charge' => $validated["type"] == "individual" ? 0 : 5
        ];

        $result = self::paystack_api_curl($url, $fields);

        return $result;
    }

    /**
     * Make a paystack connection
     * @param string $url The url
     * @param array $fields The fields string
     * @param bool $post_request Tells if the connection is a post or put request
     * @return object
     */
    private static function paystack_api_curl(string $url, array $fields, bool $post_request = false) :object{
        $fields_string = http_build_query($fields);

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        if(!$post_request){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        }else{
            curl_setopt($ch,CURLOPT_POST, true);
        }
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ".env("PAYSTACK_SECRET_KEY"),
            "Cache-Control: no-cache",
        ));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);
        $result = json_decode($result);

        return $result;
    }

    /**
     * Deactivates a sub account
     * @param string $account_id The account id
     */
    private static function deactivate_sub_account(string $account_id){
        $url = "https://api.paystack.co/subaccount/$account_id";
        $fields = [
            "active" => false
        ];

        self::paystack_api_curl($url, $fields);
    }

    /**
     * This deactivates a split account, and is usually the case when the price of the school has been set
     * @param string $split_account_id The split account id to be removed
     */
    private static function remove_split_account(?string $split_account_id){
        if($split_account_id){
            $url = "https://api.paystack.co/split/$split_account_id";

            $fields = [
                "name" => "Deactivated Split",
                "active" => false
            ];

            $result = self::paystack_api_curl($url, $fields);
            dd($result, $split_account_id, $url);
        }
    }

    /**
     * Gets the master accounts in the system
     */
    private function get_master_accounts(){
        return PaymentInformation::where("master", true)->get();
    }

    /**
     * Creates a sub account array
     * @param string $sub_account The sub account to be merged with master
     * @param string $school_account The school account to be merged
     * @return array
     */
    private function create_sub_accounts(string $sub_account, string $school_account) :array{
        $system_price = floatval(session("base_price"));
        $school_price = floatval(session("school_result_price"));
        $master_accounts = $this->get_master_accounts();
        $sub_accounts[0] = $this->split_subaccount($sub_account, $this->user_price());

        foreach($master_accounts as $account){
            $role = $account->user->role->name;
            $sub_accounts[] = $this->split_subaccount($account->account_id, $this->user_price($role));
        }

        // add the school account details
        $sub_accounts[] = $this->split_subaccount($school_account, $school_price, false);

        return $sub_accounts;
    }

    /**
     * Creates a sub account array for split
     */
    private function split_subaccount($sub_account, $price, $use_base_price = true){
        return [
            "subaccount" => $sub_account, "share" => ($use_base_price ? $price * floatval(session('base_price')) : $price * 100)
        ];
    }

    /**
     * Used by schools to update or save their payment records
     * @param Request $request
     */
    public function update_payment(Request $request){
        $school_setting = new SchoolSettingController();
        $is_new_price = $request->value != session('school_result_price');

        // make update or save
        $school_setting->save_update($request);

        // make update to session
        AuthenticatedSessionController::payment_ready();

        // make changes to split token
        if($request->personal_account && $request->school_account){
            if($request->split_id && $is_new_price){
                self::remove_split_account($request->split_id);
                $split_details = $this->create_split_account($request->personal_account, $request->school_account, Auth::user());

                $personal_account = PaymentInformation::where("account_id", $request->personal_account)->first();
                $personal_account->update([
                    "split_key" => $split_details->data->split_code,
                    "split_id" => $split_details->data->id
                ]);
            }
        }

        return redirect()->back()->with(["success" => true, "message" => "Updates done to how much you charge"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentInformation $paymentInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $options = $this->edit_options();
        return view("payment-accounts.show", $options);
    }

    private function edit_options(){
        $user = Auth::user();
        $creatable = $user->role_id < 3 || ($user->role_id > 2 && session("payment_is_ready"));

        if($creatable){
            $response = [
                "personal_account" => PaymentInformation::where("user_id", $user->id)->where("type", "individual")->first(),
                "school_account" => PaymentInformation::where("user_id", $user->id)->where("type", "school")->first(),
                "tags" => [
                    ["text" => "Accounts", "icon" => "fas fa-file-invoice-dollar", "link" => route("payment-account.all")],
                    ["text" => "My Accounts", "icon" => "fas fa-file-invoice"]
                ],
                "admin" => $user->role_id == 3,
                "user" => $this->user_model($user),
                "school" => $user->role_id == 3 ? School::find(session('school_id')) : null,
                "banks" => PaystackBank::all(["code", "name"])->toArray()
            ];

            // if a school has multiple admins, enforce that only one can be created
            $response["registered_admin"] = $this->admin_personal_exists($response["personal_account"]);

            if($user->role_id > 2){
                $response["result_price"] = SchoolSetting::where("settings_name", "system_price")->get();
            }
        }

        $response["can_create"] = $creatable;

        return $response;
    }

    /**
     * Checks if a specified school has an already existing personal/admin account
     */
    private function admin_personal_exists($user_account){
        $is_current_admin = -1;
        if(session("school_id") > 0 && $user_account){
            $admin_account = PaymentInformation::where("school_id", session('school_id'))->where("type", "individual");

            if($admin_account->exists()){
                $admin_account = $admin_account->get()[0];

                $is_current_admin = $admin_account->user_id == Auth::user()->id;
            }
        }

        return $is_current_admin;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentInformationRequest $request, PaymentInformation $paymentInformation)
    {
        $original = $paymentInformation;
        $validated = $request->validated();
        $response = $this->update_sub_account($validated);

        if($response->status){
            $paymentInformation->update($validated);
            ActivityLog::success_log(LogType::SUB_ACCOUNT_UPDATE, "Account details have been updated", ["original" => $original, "current" => $paymentInformation]);
            return back()->with(["success" => true, "message" => "Account details have been updated successfully"]);
        }else{
            ActivityLog::dev_error_log(LogType::SUB_ACCOUNT_UPDATE, "Account update failed: {$response->message}");
            throw ValidationException::withMessages([
                "message" => $response->message
            ]);
        }
    }

    /**
     * This is used during deleting of a school account
     */
    public static function remove_accounts(School $school){
        $accounts = $school->payment_information;

        if($accounts->count() > 0){
            foreach($accounts as $account){
                // deactivate the split key if it exists
                self::remove_split_account($account->split_id);

                // deactivate the account
                self::deactivate_sub_account($account->account_id);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentInformation $paymentInformation)
    {
        //
    }
}
