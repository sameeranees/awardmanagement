<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Member;
use App\Classes\DataGrid;
use App\Classes\CHtml;
use App\Http\Requests\MemberRequest;
use App\Degree;
use App\Major;
use App\MembersFamilyHistory;
use App\Year;

class YearController extends Controller
{
    private $model, $section, $components;
    /**
     * Constructor
     */
    public function __construct( Year $year, CHtml $components ) {
        $this->model = $year;
        $this->components = $components;

        $this->section = new \stdClass();
        $this->section->title = 'Year';
        $this->section->heading = 'Year';
        $this->section->slug = 'year';
        $this->section->folder = 'year';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $year = [];
        $section = $this->section;
        $section->title = 'Year';
        $section->heading = 'Year';
        $section->method = 'POST';
        //$section->breadcrumbs = $this->components->breadcrumb(['Year' => route($section->slug.'.index')]);
        $section->route = $section->slug.'.store';
        return view($section->folder.'.index', compact('year', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $section = $this->section;
        
        // append user type in $request
        //$request->request->add(['type' => $this->model::SYSTEM_USER]);
        //dd($request->year);
        DB::table('year')
            ->where('id', 1)
            ->update(['year'=>$request->year]);

        $request->session()->flash('alert-success', 'Record has been added successfully.');
        
        return redirect()->route($section->slug.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
