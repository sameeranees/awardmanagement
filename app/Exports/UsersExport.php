<?php

namespace App\Exports;

use App\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;
class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $export= Member::all();
        Excel::create('Export Data',function($excel) use($export){
        	$excel->sheet('Sheet1',function($sheet) use($export){
        		$sheet->fromArray($export);
        	});
        })->export('xlsx');
    }
}
