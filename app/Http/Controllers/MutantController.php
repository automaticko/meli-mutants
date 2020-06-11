<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\Mutant\StoreRequest;
use App\Models\Dna;
use App\Services\DNAService;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class MutantController extends Controller
{
    public function store(StoreRequest $request)
    {
        $sequence = $request->get('dna', []);

        $dnaService = App::make(DNAService::class, ['sequence' => $sequence]);

        $dna = Dna::create([
            'sequence'  => $sequence,
            'is_mutant' => $dnaService->hasMutantGenes(),
        ]);

        $httpStatusCode = $dna->isMutant() ? SymfonyResponse::HTTP_OK : SymfonyResponse::HTTP_FORBIDDEN;

        return Response::noContent($httpStatusCode);
    }
}
