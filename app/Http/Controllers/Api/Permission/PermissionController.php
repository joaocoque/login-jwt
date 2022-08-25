<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Auth\Role;
use App\Models\Auth\Permission;
use App\Traits\NotFound\NotFoundResponseTrait;
use App\Http\Resources\Api\V1\Roles\RoleResource;
use App\Http\Resources\Api\V1\Roles\RolesResource;
use App\Http\Resources\Api\V1\Permissions\PermissionsResource;
use App\Http\Resources\Api\V1\Permissions\PermissionsSelectResource;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\Permissions\StorePermissionRequest;
use App\Http\Requests\Api\Permissions\UpdatePermissionRequest;

class PermissionController extends BaseController
{
    private $permissions;
    private $roles;

    function __construct(Permission $permissions, Role $roles)
    {
        $this->middleware('permission:view_permissions', ['only' => ['index']]);
        $this->middleware('permission:add_permissions', ['only' => ['store']]);
        $this->middleware('permission:edit_permissions', ['only' => ['update']]);
        $this->middleware('permission:delete_permissions', ['only' => ['destroy']]);

        $this->permissions = $permissions;
        $this->roles = $roles;
    }

    public function index(Request $request)
    {
        $query = $this->permissions->orderBy('details', 'DESC')
            ->where('guard_name', 'api');

        if ($request->filled('name')) {
            $query = $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $results = $query->paginate(10);

        return ($results->count() == 0) ?
            $this->notFoundResponse() :
            PermissionsResource::collection($results);
    }

    public function roles()
    {
        $roles = $this->roles->byUser(auth('api')->user())
            ->whereIn('guard_name', ['api'])
            ->select(['id', 'name'])
            ->get();

        return response()->json([
            'roles' => $roles
        ], 200);
    }

    public function show($id)
    {
        $result = $this->permissions->with('permissions')->findOrFail($id);

        return new RoleResource($result);
    }

    public function store(StorePermissionRequest $request)
    {
        try {

            DB::beginTransaction();

            $result = $this->permissions->create($request->safe()->merge([
                'guard_name' => 'api'
            ])->except('roles'));

            $roles = $request->get('roles', []);

            $userRoles = $this->roles->byUser(auth('api')->user())
                ->where('guard_name', 'api')
                ->get();


            foreach ($userRoles as $role) {
                if (in_array($role->name, $roles)) {
                    if (!$role->hasPermissionTo($result->name)) {
                        $result->assignRole($role);
                    }
                } else {
                    $result->removeRole($role);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Permissão criada com sucesso!'
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Falha ao criar Permissão'
            ], 400);

        }
    }

    public function update(UpdatePermissionRequest $request, $id)
    {
        $result = $this->permissions->findOrFail($id);

        try {
            $result->fill($request->only('details'));

            $result->save();

            $userRoles = $this->roles->byUser(auth('api')->user())
                ->where('guard_name', 'api')
                ->get();

            $roles = $request->get('roles', []);

            foreach ($userRoles as $role) {
                if (in_array($role->name, $roles)) {
                    if (!$role->hasPermissionTo($result->name)) {
                        $result->assignRole($role);
                    }
                } else {
                    $result->removeRole($role);
                }
            }

            return response()->json([
                'message' => 'Permissão atualizada com sucesso!'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Falha ao atualizar Permissão'
            ], 400);

        }
    }

    public function destroy($id)
    {
        $result = $this->permissions->findOrFail($id);

        try {

            $result->delete();

            return response()->json([
                'success' => true,
                'message' => 'Permissão excluida com sucesso!'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Falha ao excluir Permissão'
            ], 500);
        }
    }

}
