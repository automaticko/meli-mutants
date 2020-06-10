<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\Mutant\StoreRequest;
use App\Services\DNAService;
use App\Services\StatsService;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class MutantController extends Controller
{
    public function store(StoreRequest $request)
    {
        $sequence = $request->get('dna', []);

        $dnaService   = App::make(DNAService::class, ['sequence' => $sequence]);
        $statsService = App::make(StatsService::class);

        $hasMutantGenes = $dnaService->hasMutantGenes();
        $httpStatusCode = $hasMutantGenes ? SymfonyResponse::HTTP_OK : SymfonyResponse::HTTP_FORBIDDEN;
        $hasMutantGenes ? $statsService->addMutant() : $statsService->addHuman();

        return Response::noContent($httpStatusCode);
    }
}
