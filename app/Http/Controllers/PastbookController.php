<?php

namespace App\Http\Controllers;

use App\Services\FacebookService;
use Laravel\Socialite\Facades\Socialite;

class PastbookController extends Controller
{
    /**
     * @var \App\Services\FacebookService
     */
    private $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    public function fetch()
    {
    }
}
