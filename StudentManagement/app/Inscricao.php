<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idAluno', 'nomeAluno', 'nomeCadeira'
    ];
}
