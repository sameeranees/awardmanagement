<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Classes\DataGrid;
use App\Classes\CHtml;
use App\Http\Requests\MemberRequest;
use App\Degree;
use App\Major;

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
        return view($section->folder.'.form', compact('member', 'section', 'degrees', 'majors'));
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
        
    
        $this->model::create($request->all());

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
        return view($section->folder.'.form', compact('member', 'section', 'degrees', 'majors'));
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
        return view($section->folder.'.form', compact('member', 'section', 'degrees', 'majors'));
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
        $member->delete();

        if (request()->ajax()) {
                return response(['message' => 'Records deleted successfully.'] );
        }

        return redirect()->route($section->slug);
    }
}
