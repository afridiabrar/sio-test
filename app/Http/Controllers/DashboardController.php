<?php

namespace App\Http\Controllers;

use App\Models\UserProject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $getProjects = UserProject::with(['users'])->get();
        return view('dashboard',['getProjects'=>$getProjects]);
    }
}
