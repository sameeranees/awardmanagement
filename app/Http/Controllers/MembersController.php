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
use App\Exports\UsersExport;
use Excel;
use Illuminate\Support\Facades\Input;

class MembersController extends Controller
{
    private $model, $section, $components;
    /**
     * Constructor
     */
    public function __construct( Member $member, CHtml $components ) {
        $this->model = $member;
        $this->components = $components;

        $this->section = new \stdClass();
        $this->section->title = 'Members';
        $this->section->heading = 'Members List';
        $this->section->slug = 'members';
        $this->section->folder = 'members';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $section = $this->section;
        
        $section->breadcrumbs = $this->components->breadcrumb(['Members Listing' => route($section->slug.'.index')]);

        return view($section->folder.'.index', compact('section'));
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
            $checked = $member->status ? ' checked=""' : "";
            $data[] = [
                $member->first_name,
                $member->surname,
                $member->degree->degree_name, 
                $member->major->majors_name ?: 'N/A',
                '<input type="checkbox" data-id="'. $member->id .'" class="switch status-chkbx" '. $checked .' data-group-cls="btn-group-sm" data-model="Member" >',//,$member->status,
                $this->components->groupButton(
                    [
                        [
                            'title'      => 'View',
                            'url'        => route($section->slug.'.show', $member->id),
                            'icon'       => 'fa fa-eye',
                            'attributes' => [
                                'class'  => 'btn-success'
                            ]
                        ],[
                            'title'      => 'Edit',
                            'url'        => route($section->slug.'.edit', $member->id),
                            'icon'       => 'fa fa-pencil',
                            'attributes' => [
                                'class'  => 'btn-info'
                            ]
                        ],[
                            'title'      => 'Trash',
                            'url'        => route($section->slug.'.destroy', $member->id),
                            'icon'       => 'fa fa-trash',
                            'attributes' => [
                                'class'      => ' grid-action-archive btn-danger',
                                'data-id'    => $member->id,
                                'data-name'  => $member->first_name
                            ]
                        ],
                    ]
                )
            ];
        }

        return DataGrid::getResponse( $data, $members['total'] );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $member = [];
        $section = $this->section;
        $section->title = 'Create Member';
        $section->heading = 'Create Member';
        $section->method = 'POST';
        $section->breadcrumbs = $this->components->breadcrumb(['Members Listing' => route($section->slug.'.index'), $section->title => route($section->slug.'.create')]);
        $section->route = $section->slug.'.store';

        $degrees = Degree::pluck('degree_name','id');
        $majors = Major::pluck('majors_name','id');
        $memberhis = new \stdClass();
        for($i = 1; $i <= 5; $i++) {
            $memberhis->{"relative_name$i"} = null;
            $memberhis->{"relation_relative$i"} = null;
            $memberhis->{"relative_year$i"} = null;
            $memberhis->{"relative_degree$i"} = null;
            $memberhis->{"relative_contact$i"} = null;
        }
        for($i = 1; $i <= 2; $i++) {
            $memberhis->{"reference_name$i"} = null;
            $memberhis->{"reference_surname$i"} = null;
            $memberhis->{"reference_address$i"} = null;
            $memberhis->{"reference_phone$i"} = null;
        }
        $formSelect=0;
        return view($section->folder.'.form', compact('formSelect','memberhis','member', 'section', 'degrees', 'majors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberRequest $request)
    {
        $section = $this->section;
        
        //dd($request->relatives);
        $member = $this->model::create($request->all());
        //$memberhis = new MembersFamilyHistory();
        //$memberhis->member()->associate($request->relatives);
        //$member_id=$member->id;
        //array_push($request->relatives,array('member_id'=>$member_id));
        //dd($request->relatives);
        $relatives=array($request->relatives);
        $member->family_historys()->createMany($relatives);
        //$memberhis->create();
        //MembersFamilyHistory::
        //zattach($request->all());

        $request->session()->flash('alert-success', 'Record has been added successfully.');
        
        return redirect()->route($section->slug.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
        $section = $this->section;
        $section->title = 'Member';
        $section->heading = 'Member';
        $section->method = 'PUT';
        $section->breadcrumbs = $this->components->breadcrumb(['Members Listing' => route($section->slug.'.index'), $section->title => route($section->slug.'.show', $member)]);
        $section->route = [$section->slug.'.update', $member];
        $degrees = Degree::pluck('degree_name','id');
        $majors = Major::pluck('majors_name','id');
        $memberhis=DB::table('members_family_history')->where([['member_id', '=', $member->id]])->first();
        //dd($memberhis);
        $formSelect=5;
        return view($section->folder.'.form', compact('formSelect','memberhis','member', 'section', 'degrees', 'majors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
        $section = $this->section;
        $section->title = 'Edit Member';
        $section->heading = 'Edit Member';
        $section->method = 'PUT';
        $section->breadcrumbs = $this->components->breadcrumb(['Members Listing' => route($section->slug.'.index'), $section->title => route($section->slug.'.edit', $member)]);
        $section->route = [$section->slug.'.update', $member];
        $degrees = Degree::pluck('degree_name','id');
        $majors = Major::pluck('majors_name','id');
        $memberhis=DB::table('members_family_history')->where([['member_id', '=', $member->id]])->first();
        $formSelect=5;
        return view($section->folder.'.form', compact('formSelect','memberhis','member', 'section', 'degrees', 'majors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemberRequest $request, Member $member)
    {
        //
        $section = $this->section;

        // if member status not checked, append status in $request
        if( !$request->status )
            $request->request->add(['status' => null]);

        $member->update($request->all());

        return redirect()->route($section->slug.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
        $section = $this->section;
        $member->delete();

        if (request()->ajax()) {
                return response(['message' => 'Records deleted successfully.'] );
        }

        return redirect()->route($section->slug);
    }

    public function export() 
    {
        $export= Member::all();
        Excel::create('Export Data',function($excel) use($export){
            $excel->sheet('Sheet1',function($sheet) use($export){
                $sheet->fromArray($export);
            });
        })->export('xlsx');
    }
    public function getImport(){
        return view('excel.importMembers');
    }
    public function postImport(){
        Excel::load(Input::file('members'),function($reader){
            $reader->each(function($sheet){
                Member::firstorCreate($sheet->toArray());
            });
        });
        return back();
    }
}
