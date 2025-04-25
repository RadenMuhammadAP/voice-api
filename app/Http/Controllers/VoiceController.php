<?php

namespace App\Http\Controllers;

use App\Services\VoiceService;
use Illuminate\Http\Request;
use App\Helpers\NlpHelper;

class VoiceController extends Controller
{
    protected $voiceService;

    public function __construct(VoiceService $voiceService)
    {
        $this->voiceService = $voiceService;
    }
		
    public function store(Request $request)
    {
        $prompt = $request->input('text');
		$response = $this->voiceService->generateResponse($prompt);
		return response()->json([
			'response' => $prompt,
			'answered' => $response,
		]);			
    }
}