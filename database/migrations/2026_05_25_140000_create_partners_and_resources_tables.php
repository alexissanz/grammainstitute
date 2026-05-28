<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 160);
            $table->string('foto')->nullable();          // storage path
            $table->string('link')->nullable();          // optional outbound link
            $table->unsignedInteger('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->index('ordem');
        });

        Schema::create('resource_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 80)->unique();
            $table->json('title')->nullable();           // { en: "...", pt_BR: "...", ... }
            $table->json('description')->nullable();
            $table->string('icon', 60)->nullable();      // fontawesome class fragment, e.g. "fa-book"
            $table->unsignedInteger('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->index('ordem');
        });

        Schema::create('resource_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('resource_categories')->cascadeOnDelete();
            $table->json('title')->nullable();
            $table->json('description')->nullable();     // short note shown beside the link
            $table->string('url');
            $table->unsignedInteger('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->index(['category_id', 'ordem']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resource_links');
        Schema::dropIfExists('resource_categories');
        Schema::dropIfExists('partners');
    }
};
