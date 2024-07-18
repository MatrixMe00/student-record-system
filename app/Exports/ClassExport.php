<?php

namespace App\Exports;

use App\Models\Program;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClassExport implements FromCollection, WithColumnFormatting,
    WithMapping, ShouldAutoSize, WithHeadings, WithProperties
{

    private Program $program;

    public static array $headers = [];

    /**
     * Constructor
     */
    public function __construct(Program $program = null)
    {
        $this->program = $program;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if($this->program){
            $students = $this->program->students;
            return $students;
        }
    }

    public function map($student) :array{
        return [
            $student->fullname, $student->next_of_kin, $student->primary_phone, $student->secondary_phone
        ];
    }

    /**
     * @return array
     */
    public function headings(): array{
        return [
            "Fullname", "Next of Kin", "Phone Number", "Phone Number 2"
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => DataType::TYPE_STRING,
            'D' => DataType::TYPE_STRING,
        ];
    }

    public function properties(): array{
        $academic_year = get_academic_year(now());
        return [
            'creator'        => env('APP_NAME'),
            'lastModifiedBy' => Auth::user()->fullname,
            'title'          => $this->program->name." Class List | ".$this->program->school->school_name,
            'description'    => "The current students for $academic_year ".$this->program->name,
            'subject'        => $this->program->name.' Class List',
            'keywords'       => "class, list, class list,{$this->program->name},$academic_year",
            'category'       => 'Class lists',
            'manager'        => $this->program->school->school_head,
            'company'        => env("APP_NAME"),
        ];
    }
}
