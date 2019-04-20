<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'start', 'end', 'user_id',
    ];

    /**
     * Calendar has one user
     *
     * @return App\User
     */
    public function user()
    {
       return $this->belongsTo(User::class); 
    }
    
    /**
     * User Events Scope
     *
     * @param $query
     * @return Query
     */
    public function scopeUserEvents($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }
}
