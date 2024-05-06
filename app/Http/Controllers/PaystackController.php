<?php

namespace App\Http\Controllers;

use App\Models\DebtorsList;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaystackController extends Controller
{
    public function callback(Request $request){
        // dd($request);
        $reference = $request->reference;
        $secret_key = env('PAYSTACK_SECRET_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer $secret_key",
            "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response);

        if($response->data->status == "success"){
            return redirect()->route('paystack.success')->with(["data" => $response->data]);
        }

        return redirect()->back()->with(["success" => false, "message" => "Payment was not successful"]);
    }

    public function success(){
        $data = session("data");
        $custom_fields = $data->metadata->custom_fields;
        $school_id = session('school_id') ?? str_replace("sch_", "", $custom_fields[2]->value);
        $student_id = Auth::user()->id ?? str_replace("stud_", "", $custom_fields[3]->value);

        // create payment
        if(Payment::where("reference", $data->reference)->exists() === false){
            $payment = new Payment([
                "id" => $data->id,
                "reference" => $data->reference,
                "school_id" => $school_id,
                "student_id" => $student_id,
                "contact_phone" => $data->authorization->mobile_money_number ?? $custom_fields[0]->value,
                "contact_name" => $custom_fields[1]->value,
                "contact_email" => $data->customer->email,
                "payment_type" => $custom_fields[4]->value,
                "amount" => ($data->amount / 100),
                "deduction" => ($data->fees / 100),
                "payment_status" => $data->status,
                "payment_method" => $data->channel
            ]);

            $payment->save();
        }

        switch(strtolower($custom_fields[4]->value)){
            case "results":
                session(['payment_result' => true]);
                return redirect()->route("result.all")->with(["success" => true, "message" => "Payment completed"]);
            case "debt":
                // update the debtors list so that student is marked as not owing
                $student = DebtorsList::where("student_id", $student_id)->first();
                $student->status = false;
                $student->update();

                session(['payment_debt' => false]);

                return redirect()->route("bece.all")->with(["success" => true, "message" => "Payment completed"]);
        }
    }
}
