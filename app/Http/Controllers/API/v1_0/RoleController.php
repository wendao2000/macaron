<?php

namespace App\Http\Controllers\API\v1_0;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Model\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getList(Request $request) {
        $roles = Role::query()->get();

        return new RoleCollection($roles);
    }

    public function add(Request $request) {
        $data = $request->validate([
            'role_code' => ['required', 'string', 'max:255', 'unique:roles'],
            'role_name' => ['required', 'string', 'max:255', 'unique:roles'],
        ]);

        $role = new Role;
        $role->role_code = $data['role_code'];
        $role->role_name = $data['role_name'];

        try {
            $role->save();
        }
        catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage(),
            ], 500);
        }

        return new RoleResource($role);
    }

    public function edit(Request $request) {
        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:roles'],
            'role_code' => ['required', 'string', 'max:255', 'unique:roles'],
            'role_name' => ['required', 'string', 'max:255', 'unique:roles'],
        ]);

        $role = Role::query()->find($data['id']);
        $role->role_code = $data['role_code'];
        $role->role_name = $data['role_name'];

        try {
            $role->save();
        }
        catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage(),
            ], 500);
        }

        return new RoleResource($role);
    }

    public function delete(Request $request) {
        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:roles'],
        ]);

        $role = Role::query()->find($data['id']);

        try {
            $role->delete();
        }
        catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'ok' => true,
            'message' => 'Successfully deleted data.',
        ]);
    }
}
