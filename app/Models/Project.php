<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['project_id', 'project_name', 'client_id','project_validation_date', 'contracted_revenue', 'status','has_quotation'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function quotation()
    {
        return $this->hasMany(Quotation::class);
    }
}
