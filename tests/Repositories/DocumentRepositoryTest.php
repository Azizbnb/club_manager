<?php

namespace Tests\Repositories;

use App\Models\Document;
use App\Repositories\DocumentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class DocumentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected DocumentRepository $documentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->documentRepo = app(DocumentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_document()
    {
        $document = Document::factory()->make()->toArray();

        $createdDocument = $this->documentRepo->create($document);

        $createdDocument = $createdDocument->toArray();
        $this->assertArrayHasKey('id', $createdDocument);
        $this->assertNotNull($createdDocument['id'], 'Created Document must have id specified');
        $this->assertNotNull(Document::find($createdDocument['id']), 'Document with given id must be in DB');
        $this->assertModelData($document, $createdDocument);
    }

    /**
     * @test read
     */
    public function test_read_document()
    {
        $document = Document::factory()->create();

        $dbDocument = $this->documentRepo->find($document->id);

        $dbDocument = $dbDocument->toArray();
        $this->assertModelData($document->toArray(), $dbDocument);
    }

    /**
     * @test update
     */
    public function test_update_document()
    {
        $document = Document::factory()->create();
        $fakeDocument = Document::factory()->make()->toArray();

        $updatedDocument = $this->documentRepo->update($fakeDocument, $document->id);

        $this->assertModelData($fakeDocument, $updatedDocument->toArray());
        $dbDocument = $this->documentRepo->find($document->id);
        $this->assertModelData($fakeDocument, $dbDocument->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_document()
    {
        $document = Document::factory()->create();

        $resp = $this->documentRepo->delete($document->id);

        $this->assertTrue($resp);
        $this->assertNull(Document::find($document->id), 'Document should not exist in DB');
    }
}
