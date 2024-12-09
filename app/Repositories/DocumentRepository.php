<?php

namespace App\Repositories;

use App\Models\Document;
use App\Repositories\BaseRepository;

class DocumentRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'type',
        'file_path',
        'status',
        'user_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Document::class;
    }
}
