<?php

namespace App\Http\Controllers\Api\V1\Graphql;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GraphqlController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'query' => ['required', 'string', 'min:2'],
            'variables' => ['nullable', 'array'],
        ]);

        return response()->json([
            'data' => null,
            'errors' => [],
            'meta' => [
                'status' => 'graphql-placeholder',
                'query_preview' => substr($validated['query'], 0, 80),
            ],
        ]);
    }
}
