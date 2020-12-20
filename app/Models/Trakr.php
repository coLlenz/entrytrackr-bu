<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trakr extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName',
        'email',
        'lastName',
        'trakr_id',
        'phoneNumber',
        'trakr_type_id',
        'user_id',
        'who',
        'assistance',
        'form',
        'answers',
        'status',
        'checked_out'
    ];

    public function setUsernameAttribute($value)
    {
        $firstName = $this->attributes['firstName'];
        $lastName = strtolower($this->attributes['lastName']);

        $username = $firstName[0] . $lastName;

        $i = 0;
        while(Trakr::whereTrakrId($username)->exists())
        {
            $i++;
            $username = $firstName[0] . $lastName . $i;
        }

        return $username;
    }
    

    public function trakrType()
    {
        return $this->belongsTo('App\Models\TrakrType');
    }
    
    public function get_list(){
        $trakr = DB::table('trakrs')
        ->where('user_id' , auth()->user()->id)->get();
        return $trakr;
    }
}
