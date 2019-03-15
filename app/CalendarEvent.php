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
        'name', 'date', 'user_id',
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
}
