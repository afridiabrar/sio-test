<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ProjectServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectServiceInterface $projectService)
    {
        $this->projectService = $projectService;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            session()->flash('error', implode("\n", $validator->errors()->all()));
            return redirect()->back()->withInput();
        }

        $this->projectService->createProject($request->all());
        return redirect(url('admin/projects'))->with('success', 'Project has been created');
    }

    public function index() {
        $getProjects = $this->projectService->getAllProjects();
        return view('admin.project.index', ['getProjects' => $getProjects]);
    }

    public function create()
    {
        return view('admin.project.create');
    }

    public function assign($project_id)
    {
        $getUsers = User::where('is_admin', 0)->get();
        $getProject = Project::where('id', $project_id)->first();
        $getUserProject = UserProject::where('project_id', $project_id)->get();
        return view('Admin.project.assign-project', ['getUsers' => $getUsers,
            'project' => $getProject, 'getUserProject' => $getUserProject]);
    }

}
