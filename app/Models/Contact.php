<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'message'
    ];

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
