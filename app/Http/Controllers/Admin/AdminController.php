<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Admin\Post;
use App\Http\Requests\Admin\Admin\Put;
use App\Http\Resources\Admin\AdminIndexResource;
use App\Http\Resources\Admin\AdminResource;
use App\Repositories\Contracts\AdminRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminController extends Controller
{
    protected $admins;

    public function __construct(AdminRepository $admins)
    {
        $this->admins = $admins;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        return AdminIndexResource::collection(
            $this->admins->paginate(
                $request->input('per_page') ?? 20
            )
        );
    }

    public function store(Post $request): void
    {
        $this->admins->create($request->all());
    }

    public function show(int $id)
    {
        return new AdminResource($this->admins->find($id));
    }

    public function update(Put $request, int $id)
    {
        $this->admins->update($id, $request->all());
    }

    public function destroy(int $id)
    {
        $this->admins->delete($id);
    }
}
