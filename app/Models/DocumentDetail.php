<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentDetail extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'field_name', 'field_type', 'is_mandatory', 'select_values', 'current_value'];

    protected $casts = [
        'select_values' => 'json',
        'is_mandatory' => 'boolean',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
