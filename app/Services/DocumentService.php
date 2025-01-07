<?php

namespace App\Services;

use App\Repositories\DocumentRepository;
use App\Traits\ApiResponseTrait;

class DocumentService
{
    use ApiResponseTrait;

    public function __construct(
        private DocumentRepository $documentRepository,
    ) {}

    public function getAll(string $status = null)
    {
        if ($status && !in_array($status, ['ACTIVE', 'INACTIVE', 'DRAFT'])) {
            return $this->errorResponse('Invalid status provided', 422);
        }

        $documents = $this->documentRepository->getAll($status);

        return $this->successResponse($documents);
    }

    public function getById(int $id)
    {
        $document = $this->documentRepository->findById($id);

        if (!$document) {
            return $this->errorResponse('Document not found', 404);
        }

        return $this->successResponse($document);
    }

    public function create(array $data)
    {
        $document = $this->documentRepository->create($data);
        return $this->successResponse($document, 201);
    }

    public function update(int $id, array $data)
    {
        $updatedDocument = $this->documentRepository->update($id, $data);

        if (!$updatedDocument) {
            return $this->errorResponse('Document not found', 404);
        }

        return $this->successResponse($updatedDocument);
    }
}
