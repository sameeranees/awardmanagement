<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Charts;
use Illuminate\Support\Facades\DB;
use App\Member;
class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$members=DB::table('members')->join('degrees', 'members.degree_id', '=', 'degrees.id')->select(/*array('degrees.degree_name', DB::raw('COUNT(members.id) as numbers'))*/'members.id','degrees.degree_name')->groupBy('members.id','degrees.degree_name')->get();
         $chart = Charts::database($members,'pie', 'chartjs')
            // Setup the chart settings
            ->title("Categories")
            // A dimension of 0 means it will take 100% of the space
            //->dimensions(0, 400) // Width x Height
            // This defines a preset of colors already done:)
            //->template("material")
            ->groupBy('degree_name');
            // You could always set them manually
            // ->colors(['#2196F3', '#F44336', '#FFC107'])
            // Setup the diferent datasets (this is a multi chart)
         $members2=DB::table('members')->select('id as Members','created_at')->get();
         $chart2=Charts::database($members2,'bar','chartjs')
         	->title("Applicants per year")
         	->groupByYear()
         	->template("material");
         	$chart2->element_label='Applicants';
        return view('dashboard',['chart'=>$chart,'chart2'=>$chart2]);
    }
}
