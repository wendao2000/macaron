<?php

namespace App\Http\Controllers\API\Latest;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Model\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getList(Request $request) {
        $roles = Role::query()->get();

        return RoleResource::collection($roles);
    }

    public function add(Request $request) {
        $data = $request->validate([
            'role_code' => ['required', 'string', 'max:255', 'unique:roles'],
            'role_name' => ['required', 'string', 'max:255', 'unique:roles'],
        ]);

        $role = new Role;
        $role->role_code = $data['role_code'];
        $role->role_name = $data['role_name'];

        if ($role->save()) {
            return new RoleResource($role);
        }
    }

    public function edit(Request $request) {

    }

    public function delete(Request $request) {

    }
}
