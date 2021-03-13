<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getList(Request $request)
    {
        $version = $request->input('version');
        $class = __NAMESPACE__ . "\\$version\\RoleController";
        return (new $class())->getList($request);
    }

    public function add(Request $request)
    {
        $version = $request->input('version');
        $class = __NAMESPACE__ . "\\$version\\RoleController";
        return (new $class())->add($request);
    }

    public function edit(Request $request)
    {
        $version = $request->input('version');
        $class = __NAMESPACE__ . "\\$version\\RoleController";
        return (new $class())->edit($request);
    }

    public function delete(Request $request)
    {
        $version = $request->input('version');
        $class = __NAMESPACE__ . "\\$version\\RoleController";
        return (new $class())->getList($request);
    }
}
