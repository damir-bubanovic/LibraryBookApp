<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Author extends Model
{
    protected $guarded = [];

    /**
     * If you have a column to be automatically casted as Carbon instances
     * @var array
     */
    protected $dates = ['birth'];

    /**
     * Mutator for correct timestamp format
     * @param [type] $birth [description]
     */
    public function setBirthAttribute($birth)
    {	
    	$this->attributes['birth'] = Carbon::parse($birth);
    }

}





