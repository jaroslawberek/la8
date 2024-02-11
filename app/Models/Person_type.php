<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person_type extends Model
{
    use HasFactory;

    //relations

public function person()
                        {
                            return $this->hasMany(person::class, 'person_type_id', 'id');
                        }
                    
}