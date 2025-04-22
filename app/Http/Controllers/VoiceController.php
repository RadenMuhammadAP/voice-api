<?php

namespace App\Http\Controllers;

use App\Services\VoiceService;
use Illuminate\Http\Request;
use App\Helpers\NlpHelper;

class VoiceController extends Controller
{
    protected $chatGPTService;

    public function __construct(ChatGPTService $chatGPTService)
    {
        $this->chatGPTService = $chatGPTService;
    }
		
    public function store(Request $request)
    {
        $prompt = $request->input('text');
		if(NlpHelper::isValidQuestion($prompt)){
			$response = $this->chatGPTService->generateResponse($prompt);
			return response()->json([
				'question' => $prompt, 
				'answered: ' => $response['choices'][0]['message']['content'],
			]);			
		}else{
			return response()->json([
				'question' => $prompt,
				'answered: ' => ''	
			]);						
		}
    }
}