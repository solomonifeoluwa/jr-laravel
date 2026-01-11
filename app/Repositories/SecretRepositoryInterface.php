<?php

namespace App\Repositories;

use App\Models\Secret;

interface SecretRepositoryInterface
{
    public function create(array $data): Secret;
    public function findByPublicId(string $publicId): ?Secret;
    public function delete(Secret $secret): void;
}
