<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Member;
use App\Classes\DataGrid;
use App\Classes\CHtml;
use App\Http\Requests\MemberRequest;
use App\Degree;
use App\Major;

class SeatsController extends Controller
{
	private $model, $section, $components;
    /**
     * Constructor
     */
    public function __construct( Member $member, CHtml $components ) {
        $this->model = $member;
        $this->components = $components;

        $this->section = new \stdClass();
        $this->section->title = 'Seating Arrangement';
        $this->section->heading = 'Seats';
        $this->section->slug = 'seats';
        $this->section->folder = 'seats';
    }
    //
    public function index()
    {
        //
        $section = $this->section;
        
        $section->breadcrumbs = $this->components->breadcrumb(['Seats' => route($section->slug.'.index')]);

        return view($section->folder.'.index', compact('section'));
    }

    public function create()
    {
        //
        $member = [];
        $section = $this->section;
        $section->title = 'Generate Seats';
        $section->heading = 'Generate Seats';
        $section->method = 'POST';
        $section->breadcrumbs = $this->components->breadcrumb(['Seats' => route($section->slug.'.index'), $section->title => route($section->slug.'.create')]);
        $section->route = $section->slug.'.store';
    	return view($section->folder.'.form', compact('member', 'section'));
    }

    public function print(Request $request){
        $section = $this->section;
        $members= DB::table('members')->join('degrees', 'members.degree_id', '=', 'degrees.id')->select('members.seat_no','members.first_name','members.surname','degrees.degree_name')->orderBy('seat_no','asc')->get();
        $section->method = 'POST';
        $members=$members->sortBy('seat_no', SORT_NATURAL);
        $section->breadcrumbs = $this->components->breadcrumb(['Seats' => route($section->slug.'.print')]);
        return view($section->folder.'.print', compact('members', 'section'));  
    }
    public function store(Request $request)
    {
        $section = $this->section;
    	$number=1;
    	$degrees = Degree::pluck('id');
    	foreach($degrees as $degree){
    		$members=DB::table('members')->where([['degree_id', '=', $degree],['gender','=','Male']])->get();
    		foreach ($members as $member) {
    			DB::table('members')->where('id', $member->id)
            	->update(['seat_no' => 'B-'.$number]);
            	$number=$number+1;
    		}
    	}
    	$number=1;
    	foreach($degrees as $degree){
    		$members=DB::table('members')->where([['degree_id', '=', $degree],['gender','=','Female']])->get();
    		foreach ($members as $member) {
    			DB::table('members')->where('id', $member->id)
            	->update(['seat_no' => 'G-'.$number]);
            	$number=$number+1;
    		}
		}
		$request->session()->flash('alert-success', 'Seats have been generated successfully');
        
        return redirect()->route($section->slug.'.index');
    }

    public function list(Request $request) {
        $section = $this->section;
        $input_all = $request->all();
        $filters = [];
        foreach ($input_all as $field => $data) {
            if ($field == 'order') {
                $columnIndex = $data[0]['column'];
                $filters['order_dir'] = $data[0]['dir'];
                $filters['order_by'] = $input_all['columns'][ $columnIndex ]['name'];

            }
            else {
                $filters[ $field ] = $data;
            }
        }

        $members = $this->model::search( $filters );
        if ( !$members ) {
            return DataGrid::getResponse( [], 0, 0 );
        }

        $data = [];

        foreach ( $members['result'] as $i => $member) {
            $data[] = [
                $member->id,
            	$member->seat_no,
                $member->first_name,
                $member->surname,
                $member->degree->degree_name, 
                $member->major->majors_name ?: 'N/A',
                //,$member->status,
            ];
        }

        return DataGrid::getResponse( $data, $members['total'] );
    }

    public function show(Member $member)
    {
    }

    public function edit(Member $member)
    {

    }

    public function update(MemberRequest $request, Member $member)
    {
    }

    public function destroy(Member $member)
    {
    }
}
