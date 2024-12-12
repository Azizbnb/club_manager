<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDocumentAPIRequest;
use App\Http\Requests\API\UpdateDocumentAPIRequest;
use App\Models\Document;
use App\Repositories\DocumentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\DocumentResource;

/**
 * Class DocumentController
 */

class DocumentAPIController extends AppBaseController
{
    /** @var  DocumentRepository */
    private $documentRepository;

    public function __construct(DocumentRepository $documentRepo)
    {
        $this->documentRepository = $documentRepo;
    }

    /**
     * @OA\Get(
     *      path="/documents",
     *      summary="getDocumentList",
     *      tags={"Document"},
     *      description="Get all Documents",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Document")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $documents = $this->documentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(DocumentResource::collection($documents), 'Documents retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/documents",
     *      summary="createDocument",
     *      tags={"Document"},
     *      description="Create Document",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Document")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Document"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDocumentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $document = $this->documentRepository->create($input);

        return $this->sendResponse(new DocumentResource($document), 'Document saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/documents/{id}",
     *      summary="getDocumentItem",
     *      tags={"Document"},
     *      description="Get Document",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Document",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Document"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Document $document */
        $document = $this->documentRepository->find($id);

        if (empty($document)) {
            return $this->sendError('Document not found');
        }

        return $this->sendResponse(new DocumentResource($document), 'Document retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/documents/{id}",
     *      summary="updateDocument",
     *      tags={"Document"},
     *      description="Update Document",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Document",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Document")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Document"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDocumentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Document $document */
        $document = $this->documentRepository->find($id);

        if (empty($document)) {
            return $this->sendError('Document not found');
        }

        $document = $this->documentRepository->update($input, $id);

        return $this->sendResponse(new DocumentResource($document), 'Document updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/documents/{id}",
     *      summary="deleteDocument",
     *      tags={"Document"},
     *      description="Delete Document",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Document",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Document $document */
        $document = $this->documentRepository->find($id);

        if (empty($document)) {
            return $this->sendError('Document not found');
        }

        $document->delete();

        return $this->sendSuccess('Document deleted successfully');
    }
}
