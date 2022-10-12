<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaudosEcfs extends Model
{
    use HasFactory;

    protected $table = 'laudos_ecfs';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
