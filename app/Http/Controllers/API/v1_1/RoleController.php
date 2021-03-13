<?php

namespace App\Http\Controllers\API\v1_1;

use App\Http\Controllers\API\v1_0\RoleController as BaseRoleController;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Model\Role;
use Illuminate\Http\Request;

class RoleController extends BaseRoleController
{
    public function getList(Request $request) {
        return new RoleCollection(Role::all());
    }

    public function add(Request $request) {
        $project = new Role();
        return new RoleResource($project);
    }

    public function edit(Request $request) {
        return new RoleResource(null);
    }

    public function delete(Request $request) {
        return new RoleResource(null);
    }
}
