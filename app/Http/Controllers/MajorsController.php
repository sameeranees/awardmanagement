<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Degree;
use App\Major;
use App\Classes\DataGrid;
use App\Classes\CHtml;
use App\Http\Requests\MajorRequest;

class MajorsController extends Controller
{
    private $model, $section, $components;
    /**
     * Constructor
     */
    public function __construct( Major $major, CHtml $components ) {
        $this->model = $major;
        $this->components = $components;

        $this->section = new \stdClass();
        $this->section->title = 'Majors';
        $this->section->heading = 'Majors List';
        $this->section->slug = 'majors';
        $this->section->folder = 'majors';
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
        
        $section->breadcrumbs = $this->components->breadcrumb(['Majors Listing' => route($section->slug.'.index')]);

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

        $majors = $this->model::search( $filters );
        if ( !$majors ) {
            return DataGrid::getResponse( [], 0, 0 );
        }

        $data = [];

        foreach ( $majors['result'] as $i => $major) {
            //$checked = $major->status ? ' checked=""' : "";
            $data[] = [
                $major->id,
                $major->degree->degree_name,
                $major->majors_name ?: 'N/A',
                //,$major->status,
                $this->components->groupButton(
                    [
                        [
                            'title'      => 'View',
                            'url'        => route($section->slug.'.show', $major->id),
                            'icon'       => 'fa fa-eye',
                            'attributes' => [
                                'class'  => 'btn-success'
                            ]
                        ],[
                            'title'      => 'Edit',
                            'url'        => route($section->slug.'.edit', $major->id),
                            'icon'       => 'fa fa-pencil',
                            'attributes' => [
                                'class'  => 'btn-info'
                            ]
                        ],[
                            'title'      => 'Trash',
                            'url'        => route($section->slug.'.destroy', $major->id),
                            'icon'       => 'fa fa-trash',
                            'attributes' => [
                                'class'      => ' grid-action-archive btn-danger',
                                'data-id'    => $major->id,
                                'data-name'  => $major->majors_name
                            ]
                        ],
                    ]
                )
            ];
        }

        return DataGrid::getResponse( $data, $majors['total'] );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $major = [];
        $section = $this->section;
        $section->title = 'Create Major';
        $section->heading = 'Create Major';
        $section->method = 'POST';
        $section->breadcrumbs = $this->components->breadcrumb(['Majors Listing' => route($section->slug.'.index'), $section->title => route($section->slug.'.create')]);
        $section->route = $section->slug.'.store';

        $degrees = Degree::pluck('degree_name','id');
        return view($section->folder.'.form', compact('major', 'section', 'degrees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MajorRequest $request)
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
    public function show(Major $major)
    {
        //
        $section = $this->section;
        $section->title = 'Major';
        $section->heading = 'Major';
        $section->method = 'PUT';
        $section->breadcrumbs = $this->components->breadcrumb(['Majors Listing' => route($section->slug.'.index'), $section->title => route($section->slug.'.show', $major)]);
        $section->route = [$section->slug.'.update', $major];
        $degrees = Degree::pluck('degree_name','id');
        return view($section->folder.'.form', compact('major', 'section', 'degrees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Major $major)
    {
        $section = $this->section;
        $section->title = 'Edit Major';
        $section->heading = 'Edit Major';
        $section->method = 'PUT';
        $section->breadcrumbs = $this->components->breadcrumb(['Majors Listing' => route($section->slug.'.index'), $section->title => route($section->slug.'.edit', $major)]);
        $section->route = [$section->slug.'.update', $major];
        $degrees = Degree::pluck('degree_name','id');
        return view($section->folder.'.form', compact('major', 'section', 'degrees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MajorRequest $request, $id)
    {
        $section = $this->section;

        // if major status not checked, append status in $request
        if( !$request->status )
            $request->request->add(['status' => null]);

        $major->update($request->all());

        return redirect()->route($section->slug.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Major $major)
    {
        $major->delete();

        if (request()->ajax()) {
                return response(['message' => 'Records deleted successfully.'] );
        }

        return redirect()->route($section->slug);
    }
}
