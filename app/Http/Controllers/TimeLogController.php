<?php

namespace App\Http\Controllers;

use App\Contracts\TimeLogServiceInterface;
use App\Models\Project;
use App\Models\TimeLog;
use App\Models\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TimeLogController extends Controller
{
    protected $timeLogServiceInterface;

    public function __construct(TimeLogServiceInterface $timeLogServiceInterface){
        $this->timeLogServiceInterface = $timeLogServiceInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function tracking($project_id){
        $param = [
            'user_id' => auth()->id(),
            'project_id' => $project_id
        ];
        $orderBy = 'DESC';
        $getLogs = $this->timeLogServiceInterface->getOrderBy($param,$orderBy);
        return view('user.index',['getTimeLog'=>$getLogs,'project_id'=>$project_id]);
    }

    public function statistics($project_id)
    {
        $projectData = Project::find($project_id);
        $hoursPerDay = DB::table('time_logs')
            ->where(['user_id' => auth()->id(),'project_id'=>$project_id]) // neglect the date for getting all dates
//            ->where(['user_id' => auth()->id(), 'date' => '2024-03-16']) // neglect the date for getting all dates
            ->select(
                'date',
                DB::raw('SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time))/60 as total_hours',)
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        $WeeklyHours = TimeLog::select(
            DB::raw('MONTH(date) as week'),
            DB::raw('SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_hours')
        )
            ->where(['user_id' => auth()->id(),'project_id'=>$project_id])
            ->groupBy('week')
            ->get();
        $monthlyHours = TimeLog::select(
            DB::raw('YEAR(date) as year'),
            DB::raw('MONTH(date) as month'),
            DB::raw('SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_hours')
        )
            ->where(['user_id' => auth()->id(),'project_id'=>$project_id])
            ->groupBy('year', 'month')
            ->get();

        return view('user.statistics', ['dailyHours' => $hoursPerDay,
            'weeklyHours' => $WeeklyHours,
            'monthlyHours' => $monthlyHours,
            'projectData'=>$projectData]);
    }

    public function index()
    {
        $getProjects = UserProject::with(['users'])->get();
        return view('dashboard', ['getProjects' => $getProjects]);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required'
        ]);
        if($validator->fails()){
            session()->flash('error', implode("\n", $validator->errors()->all()));
            return redirect()->back()->withInput();
        }

        if ($request->input('action') == 'start') {
            $checkActiveLog = TimeLog::where('user_id', auth()->id())
                ->whereNull('end_time')
                ->latest()->first();
            if ($checkActiveLog) {
                return back()->with('error', 'An Active work session is already in progress');
            }
            TimeLog::create([
                'user_id' => auth()->id(),
                'project_id'=> $request->project_id,
                'date' => date('Y-m-d'),
                'start_time' => now()
            ]);
            return back()->with('success', 'Work started successfully.');
        }
        if ($request->input('action') == 'end') {
            $log = TimeLog::where('user_id', auth()->id())
                ->whereNull('end_time')
                ->latest()
                ->first();
            if ($log) {
                $log->update(['end_time' => now()]);
                return back()->with('success', 'Work Stopped Successfully');
            } else {
                return back()->with('error', 'No Active session Found');
            }
        }
        return back()->with('error', 'Invalid Action');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
