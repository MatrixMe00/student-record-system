<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\School;
use Illuminate\Http\Request;

class RemarkOptionsController extends Controller
{
    private function rules(){
        return [
            "school_id" => ["sometimes", "requird", "integer", "exists:".School::class],
            "admin_id" => ["required", "integer", "exists:".Admin::class],
            "remark" => ["required", "string"]
        ];
    }
}
