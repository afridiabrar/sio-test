<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;

    protected $appends = ['between_hours'];
    protected $guarded = [];

    public function getBetweenHoursAttribute()
    {
        if(!empty($this->start_time) && (!empty($this->end_time))){
            $getBetweenHours = Carbon::parse($this->start_time)->floatDiffInHours($this->end_time);
            return round($getBetweenHours,2);
        }
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function project(){
        return $this->hasOne(Project::class,'id','project_id');
    }
}
