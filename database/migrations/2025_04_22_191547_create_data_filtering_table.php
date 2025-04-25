<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_filtering', function (Blueprint $table) {
            $table->id();
			$table->string('key')->nullable();
			$table->text('value')->nullable();
            $table->timestamps();
        });
		$now_date = Carbon::now();
		DB::table('data_filtering')->insert(
			['key' => 'introduce yourself',
			 'value' => 'I am Raden',		 
			 'created_at' => $now_date,
			 'updated_at' => $now_date
			] 
		);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_filtering');
    }
};
