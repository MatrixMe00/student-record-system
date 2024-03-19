<?php

/**
 * This function is used to generate the academic year for a selected period
 * @param string $date This takes the date of which academic calendar is presented
 * @return string the academic year
 */
function get_academic_year($date){
    //providing a value according to a calculated algorithm
    $this_year = date("Y", strtotime($date));

    //get the academic year
    $prev_year = null;
    $next_year = null;
    $this_date = date("Y-m-d", strtotime($date));

    if($this_date < date("$this_year-09-01")){
        $prev_year = intval($this_year) - 1;
        $next_year = intval($this_year);
    }else{
        $prev_year = intval($this_year);
        $next_year = intval($this_year) + 1;
    }

    return "$prev_year / $next_year";
}

/**
 * Gets the grade value for a subject
 * @param int $value The value to get its grade value
 * @return int The grade value
 */
function grade_value($value) :int{
    $breakpoints = [
        ["max" => 24, "grade" => 9],
        ["max" => 34, "grade" => 8],
        ["max" => 39, "grade" => 7],
        ["max" => 44, "grade" => 6],
        ["max" => 49, "grade" => 5],
        ["max" => 59, "grade" => 4],
        ["max" => 69, "grade" => 3],
        ["max" => 79, "grade" => 2],
        ["max" => 100, "grade" => 1]
    ];

    foreach($breakpoints as $breakpoint){
        if($value <=  $breakpoint["max"]){
            return $breakpoint["grade"];
        }
    }
}

/**
 * Gets the grade description for a subject result
 * @param int $grade_value The value to describe
 * @return string The grade description
 */
function grade_description(int $grade_value) :string{
    $grade_value = $grade_value < 1 ? 9 : $grade_value;
    $grade_value = $grade_value > 9 ? grade_value($grade_value) : $grade_value;

    $descriptions = [
        "Excellent", "Very Good", "Good", "Credit",
        "Credit", "Credit", "Pass", "Pass", "Fail"
    ];

    return $descriptions[$grade_value - 1];
}

/**
 * Creates a 10 character token
 * @return string The token
 */
function create_id() :string{
    $token = "";

    //generate three random values
    for($i = 1; $i <= 3; $i++){
        $token .= chr(rand(65,90));
    }

    //add teacher id
    $token .= str_pad(strval(auth()->user()->id), 3, "0", STR_PAD_LEFT);

    $token = str_shuffle($token);

    //random characters
    $token .= chr(rand(65,90)). str_pad(session('school_id'),2,"0",STR_PAD_LEFT);
    $token = substr(str_shuffle($token.uniqid()), 0, 8);
    $token .= date("y");

    return strtolower($token);
}
