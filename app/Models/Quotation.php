<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        "project_id",
        "item_title",
        "unit",
        "unit_rate",
        "quantity",
        "price",
    ];
    public function project() {
        return $this->belongsTo(Project::class);
    }
}
