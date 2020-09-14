<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Todo extends Model
{
    protected $guarded = [];

    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
    public function user()
    {
       return $this->belongsTo(User::class,'user_id','id');
    }

    public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->shortRelativeDiffForHumans();
    }

    public function getUpdatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['updated_at'])->shortRelativeDiffForHumans();
    }

    public function setUpdatedAtAttribute()
    {
        return  $this->attributes['updated_at'] = now();
    }
}
