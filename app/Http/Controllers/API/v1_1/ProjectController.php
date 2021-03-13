<?php

namespace App\Http\Controllers\API\v1_1;

use App\Http\Controllers\API\v1_0\ProjectController as BaseProjectController;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Model\Project;
use Illuminate\Http\Request;

class ProjectController extends BaseProjectController
{
    public function getList(Request $request) {
        return new ProjectCollection(Project::all());
    }

    public function add(Request $request) {
        $project = new Project();
        return new ProjectResource($project);
    }

    public function edit(Request $request) {
        return new ProjectResource(null);
    }

    public function delete(Request $request) {
        return new ProjectResource(null);
    }
}
