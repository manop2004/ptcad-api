<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    protected $table = 'tb_user_contact';

    protected $fillable = [
        'user_id', 'name', 'lastname', 'tel', 'email',
    ];
}