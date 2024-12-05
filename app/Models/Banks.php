<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    use HasFactory;
    protected $fillable =  [
        'transaction_id',
        'date',
        'starting_balance',
        'type',
        'amount',
        'description',
        'ending_balance',
    ];
}