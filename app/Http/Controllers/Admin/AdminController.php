<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 20;
        if ($request->input('per_page') !== null) {
            $perPage = (int) $request->input('per_page');
        }

        $query = Admin::query();
        if (!empty($request->input('s'))) {
            $s = $request->input('s');
            $query->where('name','like','%' . $s . '%', 'or');
            $query->where('email','like','%' . $s . '%', 'or');
        }

        $admins = $query->paginate($perPage);

        return response()->json($admins, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\Admin\Post $request)
    {
        $admin = new Admin;

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = password_hash($request->password, PASSWORD_DEFAULT);

        $admin->save();

        return response()->json($admin, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::find($id);
        return response()->json($admin, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\Admin\Put $request, $id)
    {
        $admin = Admin::find($id);

        if (!empty($request->name)) {
            $admin->name = $request->name;
        }


        if (!empty($request->email)) {
            $admin->email = $request->email;
        }

        if (!empty($request->password)) {
            $admin->password = password_hash($request->password, PASSWORD_DEFAULT);
        }

        $admin->save();

        return response()->json($admin, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Admin::destroy($id);

        $args = [];

        $query = $request->query();

        if (array_key_exists('page', $query)) {
            $args['page'] = $request->page;
        }

        if (array_key_exists('per_page', $query)) {
            $args['per_page'] = $request->per_page;
        }

        if (array_key_exists('s', $query)) {
            $args['s'] = $request->s;
        }

        return redirect()->route('admin.admin.index', $args, 301);
    }
}
