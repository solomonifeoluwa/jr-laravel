<?php

namespace App\Services;

use App\Repositories\SecretRepositoryInterface;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;

class SecretService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private SecretRepositoryInterface $repository
    ) {}

    public function create(string $text, ?int $ttlMinutes): array
    {
        $encrypted = encrypt($text);

        $secret = $this->repository->create([
            'public_id' => (string) Str::uuid(),
            'encrypted_payload' => $encrypted,
            'expires_at' => $ttlMinutes
                ? now()->addMinutes($ttlMinutes)
                : null,
        ]);

        return [
            'id' => $secret->public_id,
            'url' => url("/api/v1/secrets/{$secret->public_id}")
        ];
    }

    public function reveal(string $publicId): string
    {
        $secret = $this->repository->findByPublicId($publicId);

        if (!$secret) {
            throw new NotFoundHttpException('Secret not found');
        }

        if ($secret->expires_at && $secret->expires_at->isPast()) {
            $this->repository->delete($secret);
            throw new GoneHttpException('Secret has expired');
        }

        $decrypted = decrypt($secret->encrypted_payload);

        // Burn on read
        $this->repository->delete($secret);

        return $decrypted;
    }
}
