<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\TimeLogServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\TimeLog;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $timeLogServiceInterface;

    public function __construct(TimeLogServiceInterface $timeLogServiceInterface){
        $this->timeLogServiceInterface = $timeLogServiceInterface;
    }

    public function index(){
        $param = [
          'date' => date('Y-m-d')
        ];
        $getLogs = $this->timeLogServiceInterface->get($param);
        return view('admin.dashboard',['getTimeLog'=>$getLogs]);
    }

    public function auth(){
        if(!empty(auth()->user()) && auth()->user()['is_admin'] == 0){
            return redirect(url('user/dashboard'));
        }
        if(!empty(auth()->user()) && auth()->user()['is_admin'] == 1){
            return redirect(url('admin/dashboard'));
        }
        return redirect(url('login'));
    }
}
