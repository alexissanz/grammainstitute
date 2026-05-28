<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_page', function (Blueprint $table) {
            $table->id();

            // Opening quote
            $table->json('quote_text')->nullable();
            $table->string('quote_author', 160)->nullable();

            // Who is Alvaro Cunha
            $table->json('founder_title')->nullable();
            $table->json('founder_text')->nullable();

            // The Gramma Institute of Linguistics
            $table->json('institute_title')->nullable();
            $table->json('institute_text')->nullable();

            // Mission
            $table->json('mission_title')->nullable();
            $table->json('mission_text')->nullable();

            // Areas of Expertise (list)
            $table->json('expertise_title')->nullable();
            $table->json('expertise_items')->nullable();   // [{ pt_BR: "...", en: "...", ... }, ...]

            // Closing statement
            $table->json('closing_title')->nullable();
            $table->json('closing_text')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_page');
    }
};
