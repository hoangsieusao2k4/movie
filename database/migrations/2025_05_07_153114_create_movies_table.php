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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tên phim
            $table->string('slug')->unique(); // Slug để tạo URL
            $table->text('description')->nullable(); // Mô tả
            $table->year('year'); // Năm phát hành
            $table->string('thumbnail')->nullable(); // Ảnh đại diện phim
            $table->string('trailer_url')->nullable(); // Link trailer YouTube/vimeo
            $table->string('video_url')->nullable(); // Link video phim lẻ
            $table->enum('type', ['movie', 'series'])->default('movie'); // Phim lẻ hoặc series
            $table->boolean('is_premium')->default(false); // Chỉ dành cho người dùng premium
            $table->enum('status', ['public', 'private', 'draft'])->default('public'); // Trạng thái hiển thị
            $table->foreignId('country_id')->constrained()->onDelete('restrict');
            $table->foreignId('director_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
