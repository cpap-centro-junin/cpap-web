<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitaciones extends Model
{
    protected $table = 'invitaciones';

    protected $fillable = ['email', 'token', 'usado'];
}
