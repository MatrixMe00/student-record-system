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
