<?php

namespace App\Http\Controllers\API\v1_0;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Model\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function getList(Request $request) {
        $projects = Project::query()->get();

        return new ProjectCollection($projects);
    }

    public function add(Request $request) {
        $data = $request->validate([
            'project_code' => ['required', 'string', 'max:255', 'unique:projects'],
            'project_name' => ['required', 'string', 'max:255', 'unique:projects'],
            'is_active' => ['required', 'boolean'],
        ]);

        $project = new Project;
        $project->project_code = $data['project_code'];
        $project->project_name = $data['project_name'];
        $project->is_active = $data['is_active'];

        if ($project->save()) {
            return new ProjectResource($project);
        }
    }

    public function edit(Request $request) {
        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:project'],
            'project_code' => ['required', 'string', 'max:255', 'unique:projects'],
            'project_name' => ['required', 'string', 'max:255', 'unique:projects'],
            'is_active' => ['required', 'boolean'],
        ]);

        $project = Project::query()->find($data['id']);
        $project->project_code = $data['project_code'];
        $project->project_name = $data['project_name'];
        $project->is_active = $data['is_active'];

        if ($project->save()) {
            return new ProjectResource($project);
        }
    }

    public function delete(Request $request) {

    }
}
