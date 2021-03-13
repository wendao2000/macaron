<?php

namespace App\Http\Controllers\API\v1_1;

use App\Http\Controllers\API\v1_0\ProjectController as BaseProjectController;
use App\Http\Resources\ProjectCollection;
use App\Model\Project;
use Illuminate\Http\Request;

class ProjectController extends BaseProjectController
{
    public function getList(Request $request) {
        return new ProjectCollection(Project::all());
    }
}
