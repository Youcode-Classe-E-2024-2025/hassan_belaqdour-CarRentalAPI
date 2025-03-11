<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'rental_id',
        'amount',
        'payment_date',
        'status',
    ];

    public function rental(){
        return $this -> belongsTo(Rental::class);
    }

}
