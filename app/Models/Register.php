<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $fillable = ['phone_number' , 'first_name' , 'last_name' , 'username' , 'chat_id'];
}
