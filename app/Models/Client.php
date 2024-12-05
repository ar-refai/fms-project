<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'client_code',
        'client_name',
        'client_type',
        'client_source'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function expenses() {
        return $this->hasMany(Expense::class);
    }
}
