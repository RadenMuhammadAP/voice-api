<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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
		$query = DB::table('data_filtering');

		$words = explode(' ',$prompt);
		$phrases = [];
		$count = count($words);
		for ($i = 0; $i < $count; $i++) {
			$phrases[] = $words[$i];
			for ($j = 0; $j < $count; $j++) {
				if($i != $j){
					$phrases[] = $words[$i]." ".$words[$j];					
				}
			}			
		}
		$phrases[] = $prompt;
		foreach ($phrases as $word) {
			$results = DB::table('data_filtering')->where('key', '=', $word)->first();
			if(!empty($results)){			
				return $results->value;			
			}
		}
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
			return $response->json()['choices'][0]['message']['content'];
		} else {
			// Handle error
			return response()->json([
				'error' => 'Something went wrong',
				'details' => $response->json()
			], $response->status());
		}			
    }
}
