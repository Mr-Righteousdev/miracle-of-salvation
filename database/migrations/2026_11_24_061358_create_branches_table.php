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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('location');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('pastor')->nullable();
            $table->string('phone')->nullable();
            $table->string('service_times')->nullable();
            $table->string('map_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['published_at', 'sort_order']);
        });

        $branches = [
            ['Miracle of Salvation Kampala', 'kampala', 'Kampala, Uganda', 'Our Kampala branch, serving believers and the surrounding community.'],
            ['Miracle of Salvation Rwamwanja', 'rwamwanja', 'Rwamwanja, Uganda', 'Sharing the Gospel and building faith in the Rwamwanja community.'],
            ['Miracle of Salvation Kagadi', 'kagadi', 'Kagadi, Uganda', 'A place of worship, prayer, fellowship and Christian growth.'],
            ['Miracle of Salvation Kirianjagi', 'kirianjagi', 'Kirianjagi, Uganda', 'Extending the message of salvation through worship and community ministry.'],
            ['Miracle of Salvation Kinshasa', 'kinshasa', 'Kinshasa, Democratic Republic of the Congo', 'Carrying the Gospel and strengthening Christian fellowship in Kinshasa.'],
            ['Miracle of Salvation USA – Twin Falls', 'twin-falls', 'Twin Falls, Idaho, USA', 'Our United States branch, advancing the Kingdom of God through Christian ministry.'],
        ];

        DB::table('branches')->insert(array_map(fn (array $branch, int $order): array => [
            'name' => $branch[0],
            'slug' => $branch[1],
            'location' => $branch[2],
            'description' => $branch[3],
            'sort_order' => $order,
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ], $branches, array_keys($branches)));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
