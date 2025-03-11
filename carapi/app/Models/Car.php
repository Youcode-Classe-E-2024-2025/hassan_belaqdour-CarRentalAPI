<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Car extends Model
{
        use HasFactory, Notifiable;

        protected $fillable = [
            'make',
            'model',
            'year',
            'price_per_day',
        ];


    public function rentals(){
        return $this -> hasmany(Rental::class);
    }
}
