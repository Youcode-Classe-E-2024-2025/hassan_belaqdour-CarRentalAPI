<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental extends Model
{

    use HasFactory;


    protected $fillable = [
        'user_id',
        'car_id',
        'rental_date',
        'return_date',
        'status',
    ];



    public function user(){
        return $this -> belongsTo(user::class);
    }

    public function car(){
        return $this ->belongsTo(car::class);
    }

    public function payments(){
        return $this -> hasMany(Payment::class);
    }

}
