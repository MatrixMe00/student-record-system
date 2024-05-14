<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\DebtorsList;
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

        return view('payments.create',[
            "student" => Student::find($student_id)->first(),
            "type" => $type, "amount" => number_format($amount, 2)
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
                $amount = 10;
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
