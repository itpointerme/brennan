<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientCategory extends Model
{
    protected $table = 'client_category';

    protected $fillable = ['name', 'user_id'];
}
