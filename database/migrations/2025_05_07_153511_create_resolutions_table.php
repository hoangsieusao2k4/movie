<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resolutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade'); // Gắn với phim
            $table->foreignId('episode_id')->nullable()->constrained()->onDelete('cascade'); // Với series
            $table->string('quality'); // Ví dụ: 480p, 720p, 1080p
            $table->string('video_url'); // Link tương ứng độ phân giải
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resolutions');
    }
};
