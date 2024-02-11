<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    //relations
public function city()
                        {
                            return $this->belongsTo(city::class, 'city_id', 'id');
                        }
                    public function person_type()
                        {
                            return $this->belongsTo(person_type::class, 'person_type_id', 'id');
                        }
                    

}