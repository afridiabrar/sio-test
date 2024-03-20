<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function projects(){
        return $this->hasOne(Project::class,'id','project_id');
    }
}
