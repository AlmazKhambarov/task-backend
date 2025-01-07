<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Document",
 *     required={"id", "document_name", "status", "created_at", "updated_at", "field_count"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="document_name", type="string"),
 *     @OA\Property(property="status", type="string", enum={"DRAFT", "INACTIVE", "ACTIVE"}),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="field_count", type="integer")
 * )
 */

/**
 * @OA\Schema(
 *     schema="DocumentDetail",
 *     required={"id", "document_id", "field_name", "field_type", "is_mandatory"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="document_id", type="integer"),
 *     @OA\Property(property="field_name", type="string"),
 *     @OA\Property(property="field_type", type="string", enum={"input", "select", "number", "textarea"}),
 *     @OA\Property(property="is_mandatory", type="boolean"),
 *     @OA\Property(property="select_values", type="array", @OA\Items(type="object")),
 *     @OA\Property(property="current_value", type="string")
 * )
 */

/**
 * @OA\Schema(
 *     schema="DocumentWithDetails",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Document"),
 *         @OA\Schema(
 *             @OA\Property(
 *                 property="fields",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/DocumentDetail")
 *             )
 *         )
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="DocumentCreate",
 *     required={"document_name", "status", "fields"},
 *     @OA\Property(property="document_name", type="string"),
 *     @OA\Property(property="status", type="string", enum={"DRAFT", "INACTIVE", "ACTIVE"}),
 *     @OA\Property(
 *         property="fields",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="field_name", type="string"),
 *             @OA\Property(property="field_type", type="string", enum={"input", "select", "number", "textarea"}),
 *             @OA\Property(property="is_mandatory", type="boolean"),
 *             @OA\Property(property="select_values", type="array", @OA\Items(type="object")),
 *             @OA\Property(property="current_value", type="string")
 *         )
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="DocumentUpdate",
 *     required={"fields"},
 *     @OA\Property(
 *         property="fields",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="current_value", type="string")
 *         )
 *     )
 * )
 */

class DocumentSchemas {}
