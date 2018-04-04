<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scores extends Model
{
    //
    protected $table = 'score';
    protected $fillable = [
        'user_id','grade','time_started','expected_end_time', 'end_time',
    ];
}
