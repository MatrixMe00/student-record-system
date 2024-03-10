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
