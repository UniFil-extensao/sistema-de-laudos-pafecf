<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaudosRelacaoEcfs extends Model
{
    use HasFactory;

    protected $table = 'laudos_relacao_ecfs';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
