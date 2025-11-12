<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; //Eloquent model base class. Provides ORM functionalities. orm is Object Relational Mapping


class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'symbol', 'code']; // <-- important to allow mass assignment
    //Mass assignment means assigning multiple attributes to a model in one go — usually from an array (like form input).
    // The $fillable property is an array that specifies which attributes should be mass-assignable. This is a security feature to prevent mass assignment vulnerabilities.
}
