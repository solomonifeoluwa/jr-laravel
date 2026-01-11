<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SecretService;

class SecretController extends Controller
{
    /**
     * @group Secure Secrets
     *
     * Create a self-destructing secret.
     *
     * This endpoint stores an encrypted secret and returns a unique ID.
     *
     * @bodyParam text string required The secret text.
     * @bodyParam ttl integer Optional expiration time in seconds.
     *
     * @response 201 {
     *   "status": true,
     *   "message": "Secret created",
     *   "data": {
     *     "id": "abc123xyz"
     *   }
     * }
     */
    public function store(Request $request, SecretService $service)
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'ttl' => 'nullable|integer|min:1'
        ]);

        return response()->json(
            $service->create($validated['text'], $validated['ttl'] ?? null),
            201
        );
    }

    /**
     * @group Secure Secrets
     *
     * Retrieve and destroy a secret.
     *
     * This endpoint decrypts the secret and permanently deletes it.
     *
     * @urlParam id string required The unique secret ID.
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Secret retrieved",
     *   "data": {
     *     "text": "my-secret"
     *   }
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "message": "Secret not found or expired"
     * }
     */
    public function show(string $id, SecretService $service)
    {
        return response()->json([
            'secret' => $service->reveal($id)
        ]);
    }
}
