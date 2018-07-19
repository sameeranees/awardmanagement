<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Classes\DataGrid;
use App\Classes\CHtml;
use App\Http\Requests\UserRequest;
class UsersController extends Controller
{
    private $model, $section, $components;
    /**
     * Constructor
     */
    public function __construct( User $user, CHtml $components ) {
        $this->model = $user;
        $this->components = $components;

        $this->section = new \stdClass();
        $this->section->title = 'Users';
        $this->section->heading = 'Users List';
        $this->section->slug = 'users';
        $this->section->folder = 'users';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section = $this->section;
        
        $section->breadcrumbs = $this->components->breadcrumb(['Users Listing' => route($section->slug.'.index')]);

        return view($section->folder.'.index', compact('section'));
    }

    /**
     * Get model list via ajax request.
     *
     * @return \Illuminate\Http\Response
     */
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

        $users = $this->model::search( $filters );
        if ( !$users ) {
            return DataGrid::getResponse( [], 0, 0 );
        }

        $data = [];

        foreach ( $users['result'] as $i => $user) {
            $checked = $user->status ? ' checked=""' : "";
            $data[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->phone ?: 'N/A',
                '<input type="checkbox" data-id="'. $user->id .'" class="switch status-chkbx" '. $checked .' data-group-cls="btn-group-sm" data-model="User" >',//,$user->status,
                $this->components->groupButton(
                    [
                        [
                            'title'      => 'View',
                            'url'        => '#',
                            'icon'       => 'fa fa-eye',
                            'attributes' => [
                                'class'  => 'btn-success'
                            ]
                        ],[
                            'title'      => 'Edit',
                            'url'        => route($section->slug.'.edit', $user->id),
                            'icon'       => 'fa fa-pencil',
                            'attributes' => [
                                'class'  => 'btn-info'
                            ]
                        ],[
                            'title'      => 'Trash',
                            'url'        => route($section->slug.'.destroy', $user->id),
                            'icon'       => 'fa fa-trash',
                            'attributes' => [
                                'class'      => ' grid-action-archive btn-danger',
                                'data-id'    => $user->id,
                                'data-name'  => $user->name
                            ]
                        ],
                    ]
                )
            ];
        }

        return DataGrid::getResponse( $data, $users['total'] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = [];
        $section = $this->section;
        $section->title = 'Create User';
        $section->heading = 'Create User';
        $section->method = 'POST';
        $section->breadcrumbs = $this->components->breadcrumb(['Users Listing' => route($section->slug.'.index'), $section->title => route($section->slug.'.create')]);
        $section->route = $section->slug.'.store';
        return view($section->folder.'.form', compact('user', 'section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $section = $this->section;
        
        // append user type in $request
        $request->request->add(['type' => $this->model::SYSTEM_USER]);
        
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $section = $this->section;
        $section->title = 'Edit User';
        $section->heading = 'Edit User';
        $section->method = 'PUT';
        $section->breadcrumbs = $this->components->breadcrumb(['Users Listing' => route($section->slug.'.index'), $section->title => route($section->slug.'.edit', $user)]);
        $section->route = [$section->slug.'.update', $user];

        return view($section->folder.'.form', compact('user', 'section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $section = $this->section;

        // if user status not checked, append status in $request
        if( !$request->status )
            $request->request->add(['status' => null]);

        $user->update($request->all());

        return redirect()->route($section->slug.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        if (request()->ajax()) {
                return response(['message' => 'Records deleted successfully.'] );
        }

        return redirect()->route($section->slug);
    }
}
