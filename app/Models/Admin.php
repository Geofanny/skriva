<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $incrementing = false;

    protected $fillable = ['nama','email','password','no_hp'];

}
