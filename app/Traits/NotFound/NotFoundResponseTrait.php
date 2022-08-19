<?php

namespace App\Traits\NotFound;

trait NotFoundResponseTrait
{
    public function notFoundResponse()
    {
        return response()->json([
            'message' => 'Nenhum resultado encontrado.'
        ], 404);
    }
}
