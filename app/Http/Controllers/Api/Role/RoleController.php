<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Traits\NotFound\NotFoundResponseTrait;
use App\Http\Resources\Api\V1\Roles\RoleResource;
use App\Http\Resources\Api\V1\Roles\RolesResource;
use App\Http\Resources\Api\V1\Permissions\PermissionsResource;
use App\Http\Resources\Api\V1\Permissions\PermissionsSelectResource;
use App\Http\Requests\Api\Roles\StoreRoleRequest;
use App\Http\Requests\Api\Roles\UpdateRoleRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\Role;
use App\Models\Auth\Permission;

class RoleController extends BaseController
{
    use NotFoundResponseTrait;

    private $roles;
    private $permissions;

    function __construct(Role $roles, Permission $permissions)
    {
        $this->middleware('permission:view_roles', ['only' => ['index']]);
        $this->middleware('permission:add_roles', ['only' => ['store']]);
        $this->middleware('permission:edit_roles', ['only' => ['update']]);
        $this->middleware('permission:delete_roles', ['only' => ['destroy']]);

        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    public function index(Request $request)
    {
        $query = $this->roles->orderBy('details', 'ASC')
            ->where('guard_name', 'api');

        if ($request->filled('name')) {
            $query = $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $results = $query->paginate(10);

        return ($results->count() == 0) ?
            $this->notFoundResponse() :
            RolesResource::collection($results);
    }

    public function permissions()
    {
        $permissions = $this->permissions->whereIn('guard_name', ['api'])
            ->select(['name', 'details'])
            ->get();

        return PermissionsSelectResource::collection($permissions);
    }

    public function show($id)
    {
        $result = $this->roles->with('permissions')->findOrFail($id);

        return new RoleResource($result);
    }

    public function store(StoreRoleRequest $request)
    {
        try {

            DB::beginTransaction();

            $result = $this->roles->create($request->safe()->merge([
                'guard_name' => 'api'
            ])->except('permissions'));

            $result->syncPermissions($request->get('permissions', []));

            DB::commit();

            return response()->json([
                'message' => 'Grupo criado com sucesso!'
            ], 200);

        } catch (\Exception $e){

            DB::rollBack();
            // dd($e->getMessage());
            return response()->json([
                'message' => 'Falha ao criar Grupo'
            ], 400);
        }
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $result = $this->roles->byUser(auth()->user())->findOrFail($id);

        try {

            DB::beginTransaction();

            $result->fill($request->safe()->only('details'))->save();

            $result->syncPermissions($request->get('permissions', []));

            DB::commit();

            return response()->json([
                'message' => 'Grupo atualizado com sucesso!'
            ], 200);

        } catch (\Exception $e){

            DB::rollBack();

            return response()->json([
                'message' => 'Falha ao atualizar Grupo'
            ], 400);

        }
    }

    public function destroy($id)
    {
        $result = $this->roles->findOrFail($id);

        try {

            $result->delete();

            return response()->json([
                'success' => true,
                'message' => 'Grupo excluida com sucesso!'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Falha ao excluir Grupo'
            ], 500);
        }
    }
}
