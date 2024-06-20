<?php

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

if(! function_exists("get_academic_year")){
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
}

if(! function_exists("grade_value")){
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
}

if(! function_exists("grade_description")){
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
}

if(! function_exists("create_id")){
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
}


if(! function_exists("generateIndexNumber")){
    /**
     * This function is used to provide an index number for a candidate
     * @param int $school_id This is the school id of the user logged in
     * @return string returns a formated index number
     */
    function generateIndexNumber(?int $school_id):string{
        // stop execution if so school
        if(is_null($school_id)){
            return "";
        }

        $student_count = Student::all()->count();

        do{
            $school_id = str_pad($school_id, 3, "0", STR_PAD_LEFT);
            $current_year = date("y");
            $student_number = str_pad((($student_count % 9999) + 1),4,"0",STR_PAD_LEFT);

            $index_number = "$school_id$current_year$student_number";
            $found = User::where("username", $index_number)->exists();
            ++$student_count;
        }while($found);

        return $index_number;
    }
}

if(! function_exists("positionFormat")){
    /**
     * This function converts integers into positions
     * @param int $number This is the number to be converted
     * @return string returns the converted number as a string
     */
    function positionFormat(int $number):string{
        $suffix = "";

        switch($number % 10){
            case 1: $suffix = $number > 20 || $number < 10 ? "st" : "th"; break;
            case 2: $suffix = $number > 20 || $number < 10 ? "nd" : "th"; break;
            case 3: $suffix = $number > 20 || $number < 10 ? "rd" : "th"; break;
            default: $suffix = "th";
        }

        return "$number$suffix";
    }
}

if(! function_exists("format_academic_year")){
    /**
     * This formats a string of years into acceptable string format
     * @param string $academic_year The academic year to be formatted
     * @param bool $db_spacing If it should be formatted with spaces as seen in db
     * @return string
     */
    function format_academic_year(string $academic_year, bool $db_spacing = true) :string{
        $academic_year = str_replace(" ", "", $academic_year);
        list($p_year, $n_year) = array_values(explode("/", $academic_year));

        return $db_spacing ? "$p_year / $n_year" : "$p_year/$n_year";
    }
}

if(! function_exists("encode_array")){
    /**
     * This formats an array into an encoded data
     * @return string|null
     */
    function encode_array(?array $data) :?string{
        return is_null($data) ? null : base64_encode(serialize($data));
    }
}

if(!function_exists("decode_array")){
    /**
     * This formats an encoded array from string to array
     * @return array|null
     */
    function decode_array(?string $data) :?array{
        return is_null($data) ? null : unserialize(base64_decode($data));
    }
}

if(! function_exists("round_number")){
    /**
     * This function is used to add a suffix to numbers
     * @param $value This receives the value to be changed
     * @param $round_start The number to start rounding from
     *
     * @return string It returns a string representation of the value
     */
    function round_number($value, $round_start = 999){
        // start rounding from 1K
        if($value < $round_start){
            return $value;
        }

        $value = (int) $value;

        $divisor = array(
            array("div" => 1000000000,"val" => "B"),
            array("div" => 1000000,"val" => "M"),
            array("div" => 1000,"val" => "K"),
            array("div" => 10,"val" => "")
        );

        $final = "";

        for($i=0; $i < count($divisor);$i++){
            $divide = $value / $divisor[$i]["div"];

            if($value >= 1000)
                $divide = round($divide,1);
            else
                $divide = intval($divide) * $divisor[$i]["div"];

            if($divide >= 1){
                $final = $divide.$divisor[$i]["val"];
                break;
            }
        }

        return $final."+";
    }
}

if(! function_exists("custom_public_path")){
    /**
     * Get the fully qualified path to the public directory.
     *
     * @param  string  $path
     * @return string
     */
    function custom_public_path($path = '', $public = "public") :string
    {
        $base_path = $public == "public" ? base_path($public) : dirname(base_path())."/$public";
        return $base_path . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}

if(! function_exists("collection_group")){
    /**
     * This function is used to group collections into certain keys with data
     * @param mixed $collection The collection to be formated
     * @param string $group_by The column to group by
     * @param string|array $keys This specifies the key(s) which would make use of the key variable. Defaults at title
     */
    function collection_group($collection, string $group_by, string|array $keys = "title"){
        // custom function
        if(!function_exists("collection_group_keys")){
            /**
             * Formats a collection group key into acceptable format
             * @param string|array $keys The keys to be parsed
             * @param string $value The value to be paired to the key(s)
             * @return array
             */
            function collection_group_keys($keys, $value) :array{
                if(is_array($keys)){
                    foreach($keys as $key){
                        if(is_array($key)){
                            foreach($key as $ke => $k){
                                $keys_n[$ke] = $value.$k;
                            }
                        }else{
                            $keys_n[$key] = $value;
                        }
                    }
                }else{
                    $keys_n = [$keys => $value];
                }

                return $keys_n;
            }
        }

        $collection_n = $collection->groupBy($group_by)->map(function($items, $key) use ($keys){
            return array_merge(collection_group_keys($keys, $key), ["data" => $items]);
        });

        return $collection_n;
    }
}

if(! function_exists("get_file_size")){
    /**
     * Get file size
     * @param string $filepath The path to the file
     */
    function get_file_size(string $filepath){
        return Storage::size($filepath);
    }
}

if(! function_exists("year_link")){
    /**
     * Formats the academic year into a link format
     * @param string $academic_year The academic year
     * @param bool $encode Encode or decode link format
     * @return string
     */
    function year_link(string $academic_year, bool $encode = true) :string{
        $search = $encode ? "/" : "-";
        $replace = $encode ? "-" : "/";

        return str_replace($search, $replace, $academic_year);
    }
}

if(! function_exists("dual_old")){
    /**
     * Typical for pages with two different forms. Use to differentiate the old values
     * in case they are sharing the same keys
     * @param string $submit_value The submit value of form
     * @param string $old_value_key The key of old value from request
     * @param ?string
     */
    function dual_old(string $submit_value, string $old_value_key) :?string{
        $submit = old('submit') == $submit_value;

        return $submit ? old($old_value_key) : null;
    }
}

if(!function_exists("dual_error")){
    /**
     * Typical for pages with two different forms. Use for errors
     * @param string $submit_value The submit value
     * @param string $key The error key
     * @return mixed
     */
    function dual_error(string $submit_value, string $key, $errors){
        if(empty($errors)){
            return null;
        }

        $submit = old('submit') == $submit_value;

        return $submit ? $errors->get($key) : null;
    }
}

if(! function_exists("payment_type")){
    /**
     * Used for the payment display most especially
     * @param string $type The bank type provided
     * @param boolean $uppercase_strict Should strictly return uppercase
     * @return string
     */
    function payment_type($type, $uppercase_strict = false):string{
        $has_space = false;

        if(str_contains($type, "_")){
            $type = str_replace("_", " ", $type);
            $has_space = true;
        }

        $type = $has_space ? ucwords(strtolower($type)) : strtoupper($type);

        return $uppercase_strict ? strtoupper($type) : $type;
    }
}
