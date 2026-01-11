<?php

namespace App\Repositories;

use App\Models\Secret;

class SecretRepository implements SecretRepositoryInterface
{
    public function create(array $data): Secret
    {
        return Secret::create($data);
    }

    public function findByPublicId(string $publicId): ?Secret
    {
        return Secret::where('public_id', $publicId)->first();
    }

    public function delete(Secret $secret): void
    {
        $secret->delete();
    }
}

