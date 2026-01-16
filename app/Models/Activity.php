<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
    'user_id',
    'title',
    'description',
    'start_at',
    'end_at',
    'priority',
    'is_done'
];


    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
