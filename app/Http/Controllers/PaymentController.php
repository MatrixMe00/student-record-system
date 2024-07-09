<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\DebtorsList;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentBill;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type = "")
    {
        if(!in_array($type, ["debt","results", "bece", "bill"], true)){
            abort(404, "Invalid form type");
        }

        $student_id = Auth::user()->id;
        $amount = $this->get_amount($type, $student_id);
        $school = School::find(session("school_id"));
        $accounts = $school->payment_information;

        if($accounts){
            if($type == "results"){
                $account = $accounts->where("type", "individual")->first();
                $paystack_add = "split_code: '$account->split_key'";
            }else{
                // add 5% to amount
                $original = $amount;
                $amount += ($amount * 0.05);
                $account = $accounts->where("type", "school")->first();
                $paystack_add = "subaccount: '$account->account_id'";
            }
        }

        return view('payments.create',[
            "student" => Student::find($student_id)->first(),
            "type" => $type, "amount" => number_format($amount, 2), "original" => $original ?? 0,
            "paystack_add" => $paystack_add
        ]);
    }

    /**
     * Gets the payable amount
     */
    private function get_amount(string $type, int $student_id) :float{
        switch(strtolower($type)){
            case "debt":
                $amount = DebtorsList::where("student_id", $student_id)
                                     ->where("status", true);
                if($amount->exists()){
                    $amount = $amount->first()->amount;
                }else{
                    $amount = 0;
                }
                break;
            case "results":
                $amount = floatval(session("base_price")) + floatval(session("school_result_price"));
                break;
            case "bill":
                $bill = StudentBill::where("student_id", $student_id)
                                     ->where("status", true);
                if($bill->exists()){
                    $amount = $bill->sum("amount");
                }else{
                    $amount = 0;
                }
                break;
            default:
                $amount = 0;
        }

        return round($amount, 2);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
