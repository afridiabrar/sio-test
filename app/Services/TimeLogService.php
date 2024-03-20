<?php


namespace App\Services;

use App\Contracts\TimeLogServiceInterface;
use App\Models\TimeLog;
use Illuminate\Support\Facades\Validator;

class  TimeLogService implements TimeLogServiceInterface
{
    public function getOrderBy($param,$orderBy):object{
        return TimeLog::where($param)
            ->orderBy('created_at',$orderBy)
            ->get();
    }

    public function get($param):object{
        return TimeLog::where($param)->get();
    }
    public function updateTimeLog($logId, array $data):string{
        $validator = Validator::make($data, [
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'task_description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            session()->flash('error', implode("\n", $validator->errors()->all()));
            return redirect()->back()->withInput();
        }

        $log = TimeLog::findOrFail($logId);

        // Additional validation for overlapping logs here
        $overLappingLogs = TimeLog::where('id', '!=', $log->id)
            ->where(function ($query) use ($data) {
                $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                    ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']]);
            })->exists();
        if ($overLappingLogs) {
            return back()->with('error', 'The specified time range overlaps with another log.');
        }
        $log->update([
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time']
        ]);
        return redirect()->back()->with('success', 'Log updated successfully.');
    }
    public function deleteTimeLog($logId):void{
        $log = TimeLog::findOrFail($logId);
        $log->delete();
    }

}
