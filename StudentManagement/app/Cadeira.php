<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cadeira extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo', 'nome',
    ];
}
