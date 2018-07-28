<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Degree;
use App\Major;
use App\Classes\DataGrid;
use App\Classes\CHtml;
use App\Http\Requests\DegreeRequest;
class DegreesController extends Controller
{
    private $model, $section, $components;
    /**
     * Constructor
     */
    public function __construct( Degree $degree, CHtml $components ) {
        $this->model = $degree;
        $this->components = $components;

        $this->section = new \stdClass();
        $this->section->title = 'Degrees';
        $this->section->heading = 'Degrees List';
        $this->section->slug = 'degrees';
        $this->section->folder = 'degrees';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $section = $this->section;
        
        $section->breadcrumbs = $this->components->breadcrumb(['Degrees Listing' => route($section->slug.'.index')]);

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

        $degrees = $this->model::search( $filters );
        if ( !$degrees ) {
            return DataGrid::getResponse( [], 0, 0 );
        }

        $data = [];

        foreach ( $degrees['result'] as $i => $degree) {
            //$checked = $degree->status ? ' checked=""' : "";
            $data[] = [
                $degree->id,
                $degree->degree_name ?: 'N/A',
                //,$degree->status,
                $this->components->groupButton(
                    [
                        [
                            'title'      => 'View',
                            'url'        => route($section->slug.'.show', $degree->id),
                            'icon'       => 'fa fa-eye',
                            'attributes' => [
                                'class'  => 'btn-success'
                            ]
                        ],[
                            'title'      => 'Edit',
                            'url'        => route($section->slug.'.edit', $degree->id),
                            'icon'       => 'fa fa-pencil',
                            'attributes' => [
                                'class'  => 'btn-info'
                            ]
                        ],[
                            'title'      => 'Trash',
                            'url'        => route($section->slug.'.destroy', $degree->id),
                            'icon'       => 'fa fa-trash',
                            'attributes' => [
                                'class'      => ' grid-action-archive btn-danger',
                                'data-id'    => $degree->id,
                                'data-name'  => $degree->degree_name
                            ]
                        ],
                    ]
                )
            ];
        }

        return DataGrid::getResponse( $data, $degrees['total'] );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $degree = [];
        $section = $this->section;
        $section->title = 'Create Degree';
        $section->heading = 'Create Degree';
        $section->method = 'POST';
        $section->breadcrumbs = $this->components->breadcrumb(['Degrees Listing' => route($section->slug.'.index'), $section->title => route($section->slug.'.create')]);
        $section->route = $section->slug.'.store';
        return view($section->folder.'.form', compact('degree', 'section'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DegreeRequest $request)
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
    public function show(Degree $degree)
    {
        //
        $section = $this->section;
        $section->title = 'Degree';
        $section->heading = 'Degree';
        $section->method = 'PUT';
        $section->breadcrumbs = $this->components->breadcrumb(['Degrees Listing' => route($section->slug.'.index'), $section->title => route($section->slug.'.show', $degree)]);
        $section->route = [$section->slug.'.update', $degree];

        return view($section->folder.'.form', compact('degree', 'section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Degree $degree)
    {
        $section = $this->section;
        $section->title = 'Edit Degree';
        $section->heading = 'Edit Degree';
        $section->method = 'PUT';
        $section->breadcrumbs = $this->components->breadcrumb(['Degrees Listing' => route($section->slug.'.index'), $section->title => route($section->slug.'.edit', $degree)]);
        $section->route = [$section->slug.'.update', $degree];

        return view($section->folder.'.form', compact('degree', 'section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DegreeRequest $request, Degree $degree)
    {
         $section = $this->section;

        // if degree status not checked, append status in $request
        if( !$request->status )
            $request->request->add(['status' => null]);

        $degree->update($request->all());

        return redirect()->route($section->slug.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Degree $degree)
    {
        //
        $degree->delete();

        if (request()->ajax()) {
                return response(['message' => 'Records deleted successfully.'] );
        }

        return redirect()->route($section->slug);
    }
}
