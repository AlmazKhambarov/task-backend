<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="Document Management API",
 *     version="1.0.0",
 *     description="API for managing documents and their fields"
 * )
 */
class DocumentController extends Controller
{
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/documents",
     *     operationId="getDocuments",
     *     tags={"Documents"},
     *     summary="Get a list of documents",
     *     description="Returns a list of documents filtered by status",
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter documents by status",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"ACTIVE", "INACTIVE", "DRAFT"},
     *             default="ACTIVE"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="document_name", type="string"),
     *                 @OA\Property(property="status", type="string", enum={"DRAFT", "INACTIVE", "ACTIVE"}),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="field_count", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->query('status', 'ACTIVE');

        return $this->documentService->getAll($status);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/document/{id}",
     *     operationId="getDocumentById",
     *     tags={"Documents"},
     *     summary="Get a specific document",
     *     description="Returns a specific document by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Document ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="document_name", type="string"),
     *             @OA\Property(property="status", type="string", enum={"DRAFT", "INACTIVE", "ACTIVE"}),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(
     *                 property="fields",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="field_name", type="string"),
     *                     @OA\Property(property="field_type", type="string", enum={"input", "select", "number", "textarea"}),
     *                     @OA\Property(property="current_value", type="string", nullable=true),
     *                     @OA\Property(property="select_values", type="array", @OA\Items(type="object"), nullable=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        return $this->documentService->getById($id);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/documents",
     *     operationId="storeDocument",
     *     tags={"Documents"},
     *     summary="Create a new document",
     *     description="Creates a new document with the given details",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="document_name", type="string"),
     *             @OA\Property(property="status", type="string", enum={"DRAFT", "INACTIVE", "ACTIVE"}),
     *             @OA\Property(
     *                 property="fields",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="field_name", type="string"),
     *                     @OA\Property(property="field_type", type="string", enum={"input", "select", "number", "textarea"}),
     *                     @OA\Property(property="is_mandatory", type="boolean"),
     *                     @OA\Property(property="select_values", type="array", @OA\Items(type="object"), nullable=true),
     *                     @OA\Property(property="current_value", type="string", nullable=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="document_name", type="string"),
     *             @OA\Property(property="status", type="string", enum={"DRAFT", "INACTIVE", "ACTIVE"}),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(
     *                 property="details",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="field_name", type="string"),
     *                     @OA\Property(property="field_type", type="string", enum={"input", "select", "number", "textarea"}),
     *                     @OA\Property(property="is_mandatory", type="boolean"),
     *                     @OA\Property(property="select_values", type="array", @OA\Items(type="object"), nullable=true),
     *                     @OA\Property(property="current_value", type="string", nullable=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'document_name' => 'required|string',
            'status' => 'required|in:DRAFT,INACTIVE,ACTIVE',
            'fields' => 'required|array',
            'fields.*.field_name' => 'required|string',
            'fields.*.field_type' => 'required|in:input,select,number,textarea',
            'fields.*.is_mandatory' => 'required|boolean',
            'fields.*.select_values' => 'nullable|array',
            'fields.*.current_value' => 'nullable|string',
        ]);

        return $this->documentService->create($validatedData);
    }


    /**
     * @OA\Patch(
     *     path="/api/v1/document/{id}",
     *     operationId="updateDocument",
     *     tags={"Documents"},
     *     summary="Update a document's field values",
     *     description="Updates the field values of a specific document",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Document ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="fields",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="current_value", type="string", nullable=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="document_name", type="string"),
     *             @OA\Property(property="status", type="string", enum={"DRAFT", "INACTIVE", "ACTIVE"}),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(
     *                 property="details",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="field_name", type="string"),
     *                     @OA\Property(property="field_type", type="string", enum={"input", "select", "number", "textarea"}),
     *                     @OA\Property(property="is_mandatory", type="boolean"),
     *                     @OA\Property(property="select_values", type="array", @OA\Items(type="object"), nullable=true),
     *                     @OA\Property(property="current_value", type="string", nullable=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'fields' => 'required|array',
            'fields.*.id' => 'required|exists:document_details,id',
            'fields.*.current_value' => 'nullable|string',
        ]);

        return $this->documentService->update($id, $validatedData);
    }
}
