<?php

namespace App\Http\Controllers;

use App\Models\PaymentInformation;
use App\Http\Requests\StorePaymentInformationRequest;
use App\Http\Requests\UpdatePaymentInformationRequest;
use App\Models\PaystackBank;
use App\Models\School;
use App\Models\User;
use App\Traits\UserModelTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PaymentInformationController extends Controller
{
    use UserModelTrait;

    private const USER_PRICES = [
        "developer" => 20,
        "superadmin" => 25,
        "admin" => 20
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
                    "accounts" => PaymentInformation::where("school_id", session('school_id'))
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
            $sub_account = $sub_account->data->subaccount_code;

            if($user->role_id > 2 && $validated["type"] == "individual"){
                $split_account = $this->create_split_account($sub_account, $user);

                if($split_account->status == true){
                    $validated["split_key"] = $split_account->data->split_code;
                }else{
                    throw ValidationException::withMessages([
                        "message" => $split_account->message
                    ]);
                }
            }

            $validated["account_id"] = $sub_account;
        }else{
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
        $end = $type == "subaccount" ? "Result" : "Personal";
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
            'percentage_charge' => $validated["type"] == "individual" ? 0 : 5
        ];

        $fields_string = http_build_query($fields);

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ".env("PAYSTACK_SECRET_KEY"),
            "Cache-Control: no-cache",
        ));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);
        return json_decode($result);
    }

    /**
     * This is used to create a split key
     * The split key consists of all the superadmins in the system and this admin account
     */

    /**
     * This creates a split account
     * @param string $sub_account The sub account to be used
     */
    private function create_split_account($sub_account, User $user){
        $url = "https://api.paystack.co/split";
        $sub_accounts = $this->create_sub_accounts($sub_account);
        $name = $this->create_name($user->id, "split", true);

        $fields = [
            'name' => $name,
            'type' => "percentage",
            'currency' => "GHS",
            'subaccounts' => $sub_accounts
        ];

        $fields_string = http_build_query($fields);

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ".env("PAYSTACK_SECRET_KEY"),
            "Cache-Control: no-cache",
        ));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);
        return json_decode($result);
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
     * @return array
     */
    private function create_sub_accounts(string $sub_account) :array{
        $master_accounts = $this->get_master_accounts();
        $sub_accounts[0] = $this->split_subaccount($sub_account, $this->user_price());

        foreach($master_accounts as $account){
            $role = $account->user->role->name;
            $sub_accounts[] = $this->split_subaccount($account->account_id, $this->user_price($role));
        }

        return $sub_accounts;
    }

    /**
     * Creates a sub account array for split
     */
    private function split_subaccount($sub_account, $price){
        return [
            "subaccount" => $sub_account, "amount" => $price
        ];
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
        $user = Auth::user();
        return view("payment-accounts.show", [
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
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentInformationRequest $request, PaymentInformation $paymentInformation)
    {
        $validated = $request->validated();
        $validated = $this->create_accounts($validated);
        $paymentInformation->update($validated);

        return back()->with(["success" => true, "message" => "Account details have been updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentInformation $paymentInformation)
    {
        //
    }
}
