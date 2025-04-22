<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VoiceService
{
    protected $apiUrl = 'https://api.openai.com/v1/completions';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function generateResponse($prompt)
    {

	$response = Http::withHeaders([
		'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
		'HTTP-Referer' => 'https://yourapp.com',
		'X-Title' => 'Your App',
	])->post(env('OPENAI_BASE_URL') . '/chat/completions', [
		'model' => 'mistralai/mistral-7b-instruct', // bisa pakai gpt-4, claude, dsb
		'messages' => [
			['role' => 'user', 'content' => $prompt],
		],
	]);		
	
		if ($response->successful()) {
			return $response->json();
		} else {
			// Handle error
			return response()->json([
				'error' => 'Something went wrong',
				'details' => $response->json()
			], $response->status());
		}
    }
}
