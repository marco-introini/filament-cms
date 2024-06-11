<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->restrictOnDelete();
            $table->string('title');
            $table->text('content');
            $table->json('meta_description')
                ->nullable();
            $table->string('featured_image')
                ->nullable();
            $table->boolean('is_featured')
                ->default(false);
            $table->boolean('is_published')
                ->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
