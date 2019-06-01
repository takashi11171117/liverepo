<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\AdminIndexResource;
use App\Http\Resources\Admin\AdminResource;
use App\Scoping\Scopes\AdminSearchScope;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class AdminController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = 20;
        if ($request->input('per_page') !== null) {
            $perPage = (int) $request->input('per_page');
        }

        $admins = Admin::withScopes($this->scopes())
                         ->paginate($perPage);

        return AdminIndexResource::collection($admins);
    }

    /**
     * @param \App\Http\Requests\Admin\Post $request
     * @return AdminResource
     */
    public function store(\App\Http\Requests\Admin\Post $request)
    {
        $admin = new Admin;

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = password_hash($request->password, PASSWORD_DEFAULT);

        $admin->save();

        return new AdminResource($admin);
    }

    /**
     * @param $id
     * @return AdminResource
     */
    public function show($id)
    {
        $admin = Admin::find($id);

        return new AdminResource($admin);
    }

    /**
     * @param \App\Http\Requests\Admin\Put $request
     * @param $id
     * @return AdminResource
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

        return new AdminResource($admin);
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

    protected function scopes()
    {
        return [
            's' => new AdminSearchScope()
        ];
    }
}
