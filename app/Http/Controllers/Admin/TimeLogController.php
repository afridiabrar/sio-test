<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\UserProjectServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\TimeLog;
use Illuminate\Http\Request;
use App\Contracts\TimeLogServiceInterface;

class TimeLogController extends Controller
{
    protected $userProjectService;
    protected $timeLogServiceInterface;

    public function __construct(UserProjectServiceInterface $userProjectService,
                                TimeLogServiceInterface     $timeLogServiceInterface
    )
    {
        $this->userProjectService = $userProjectService;
        $this->timeLogServiceInterface = $timeLogServiceInterface;
    }

    public function store(Request $request)
    {
        $result = $this->userProjectService->createUserProject($request->all());
        if (isset($result['error'])) {
            return back()->with('error', $result['error']);
        }
        return redirect()->back()->with('success', $result['success']);
    }

    public function logs($uId, $pId)
    {
        $param = [
            'user_id' => $uId,
            'project_id' => $pId
        ];
        $getLogs = $this->timeLogServiceInterface->get($param);
        return view('Admin.time-logs.assign-logs', ['getTimeLog' => $getLogs]);
    }

    public function edit(string $id)
    {
        // Attempts to find the time log by its ID.
        $checkLog = TimeLog::where(['id' => $id])->first();
        // If the log exists, returns the 'edit' view under the 'Admin/time-logs' directory with the log data.
        // Otherwise, redirects back with an error message.
        if ($checkLog) {
            return view('Admin.time-logs.edit', ['timeLog' => $checkLog]);
        }
        return back()->with('error', 'Error Occurred');
    }

    public function update(Request $request, string $id)
    {
        try {
            return $this->timeLogServiceInterface->updateTimeLog($id, $request->all());
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', $e->validator);
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        $this->timeLogServiceInterface->deleteTimeLog($id);
        return back()->with('success', 'Time Log Deleted');
    }
}
