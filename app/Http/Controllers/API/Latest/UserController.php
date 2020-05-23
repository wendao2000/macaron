<?php

namespace App\Http\Controllers\API\Latest;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getList(Request $request) {
        $users = User::query()->with('roles')->get();

        return UserResource::collection($users);
    }

    public function add(Request $request) {

    }

    public function edit(Request $request) {
        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:users'],
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $request->input('id') . ',id'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email,' . $request->input('id') . ',id'],
//            'roles' => ['present', 'array'],
            'roles.*.id' => ['integer', 'exists:roles'],
        ]);

        $user = User::query()->find($data['id']);
        $user->name = $data['name'];
        $user->email = $data['email'];

        $user->roles()->sync($data['roles']);

        if ($user->save()) {
            return new UserResource($user);
        }
    }

    public function delete(Request $request) {

    }
}
