<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funds extends Model
{
    use HasFactory;
    protected $fillable = [
        'stakeholder',
        'date',
        'accounting_id',
        'description',
        'transaction_type',
        'amount'
    ];
    //
}
