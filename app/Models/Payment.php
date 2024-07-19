<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Used to get the total transaction value for a school
     */
    public static function school_total_transactions($school_id = null) :float{
        $school_id = $school_id == null && session("school_id") ? session("school_id") : $school_id;

        if($school_id){
            $amount = Payment::where("school_id", $school_id)->sum("amount");
            $deduction = Payment::where("school_id", $school_id)->sum("deduction");

            return round($amount - $deduction, 2);
        }

        return 0;
    }
}
