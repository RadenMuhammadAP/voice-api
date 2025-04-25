<?php

namespace App\Helpers;

class NlpHelper
{
	static function isValidQuestion($sentence) {
		$sentence = trim($sentence);
		/*
		// Harus diakhiri tanda tanya
		if (!preg_match('/\?\s*$/', $sentence)) {
			return false;
		}
		*/

		// Daftar kata tanya awal (bahasa Indo dan Inggris)
		$questionStarters = [
			'apa', 'siapa', 'kapan', 'kenapa', 'mengapa', 'bagaimana', 'dimana', 'di mana',
			'what', 'who', 'when', 'where', 'why', 'how', 'do', 'does', 'did', 'is', 'are', 'can', 'will', 'would', 'should'
		];

		// Ambil kata pertama
		$firstWord = strtolower(strtok($sentence, " "));

		if (in_array($firstWord, $questionStarters)) {
			return true;
		}

		return false;
	}
}
