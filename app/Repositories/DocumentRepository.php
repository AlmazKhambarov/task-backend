<?php

namespace App\Repositories;

use App\Models\Document;
use App\Models\DocumentDetail;

class DocumentRepository
{
    public function getAll(string $status = null)
    {
        $query = Document::query();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->withCount('details as field_count')->get();
    }


    public function findById(int $id)
    {
        return Document::with('details')->find($id);
    }

    public function create(array $data)
    {
        $document = Document::create([
            'document_name' => $data['document_name'],
            'status' => $data['status'],
        ]);

        foreach ($data['fields'] as $field) {
            $document->details()->create([
                'field_name' => $field['field_name'],
                'field_type' => $field['field_type'],
                'is_mandatory' => $field['is_mandatory'],
                'select_values' => $field['select_values'] ?? null,
                'current_value' => $field['current_value'] ?? null,
            ]);
        }

        return $document->load('details');
    }

    public function update(int $id, array $data)
    {
        $document = Document::find($id);

        if (!$document) {
            return null;
        }

        foreach ($data['fields'] as $field) {
            DocumentDetail::where('id', $field['id'])
                ->where('document_id', $id)
                ->update(['current_value' => $field['current_value']]);
        }

        return $document->load('details');
    }
}
