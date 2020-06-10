<?php

namespace App\Http\Controllers;

use App;
use App\Services\StatsService;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class StatsController extends Controller
{
    public function index()
    {
        $statsService = App::make(StatsService::class);

        $stats = [
            'count_human_dna'  => $statsService->humans(),
            'count_mutant_dna' => $statsService->mutants(),
            'ratio'            => $statsService->ratio(),
        ];

        return Response::json($stats)->setStatusCode(SymfonyResponse::HTTP_OK);
    }
}
