<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_id',
        'date',
        'basis',    // thep project id
        'project_id', // Project ID (Basis)
        'designation', // the clint's id
        'client_id', // Client ID (Designation)
        'instalment_type',
        'total_amount',
        'collection_type',
    ];


    /**
     * Relationship to the Project model.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relationship to the Client model via the Project.
     */
    public function client()
    {
        return $this->project->client();
    }
}
