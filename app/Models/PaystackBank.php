<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PaystackBank extends Model
{
    use HasFactory;
    protected $fillable = [
        "code", "type", "name", "slug",
        "country", "currency"
    ];

    /**
     * This is used to initialize all the banks from paystack
     * It basically lists the banks and then initializes them
     */
    public static function initialize_banks(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/bank?country=ghana",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".env("PAYSTACK_SECRET_KEY"),
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            abort(404,"cURL Error #:" . $err);
        } else {
            return static::create_banks($response);
        }

        return false;
    }

    /**
     * This adds the received banks into the database
     * @param $response The json format of the responses
     * @return bool
     */
    private static function create_banks($response) :bool{
        $response = json_decode($response);
        if($response->status){
            $banks = $response->data;

            // remove previous data and reupload
            static::reset_table();

            foreach($banks as $bank){
                $bank = (array) $bank;
                PaystackBank::create($bank);
            }

            return true;
        }else{
            throw new Exception("Banks could not be retrieved. Message: ".$response->message);
        }

        return false;
    }

    /**
     * Removes old data and adds new data to database
     */
    private static function reset_table(){
        // disable foreign key checks
        DB::statement("SET FOREIGN_KEY_CHECKS=0");

        PaystackBank::truncate();

        // enable temporal foreign key check
        DB::statement("SET FOREIGN_KEY_CHECKS=1");
    }
}
