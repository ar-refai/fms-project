<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'accounting_id',
        'expense_type',
        'designation', // Client name (Designation)
        'basis', // Project name (Basis)
        'description',
        'unit',
        'unit_rate',
        'quantity',
        'total_amount',
        'recipient',
        'client_id', // optional foriegn key
        'project_id', // Optional foreign key
    ];

    /**
     * Relationship to the Project model.
     */
    public function client()
{
    return $this->belongsTo(Client::class ,'client_id')->withDefault();
}

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id')->withDefault();
    }

}
