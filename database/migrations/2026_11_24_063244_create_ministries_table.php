<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ministries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->string('leader')->nullable();
            $table->string('meeting_time')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['published_at', 'sort_order']);
        });

        $ministries = [
            ['Youth Ministry', 'youth'],
            ["Children's Ministry", 'children'],
            ['Fathers and Mothers Ministry', 'fathers-mothers'],
        ];

        DB::table('ministries')->insert(array_map(fn (array $ministry, int $order): array => [
            'name' => $ministry[0],
            'slug' => $ministry[1],
            'sort_order' => $order,
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ], $ministries, array_keys($ministries)));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ministries');
    }
};
