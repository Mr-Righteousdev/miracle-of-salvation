<?php

namespace App\Filament\Resources\Streams\Pages;

use App\Filament\Resources\Streams\StreamResource;
use App\Models\Stream;
use Filament\Resources\Pages\CreateRecord;

class CreateStream extends CreateRecord
{
    protected static string $resource = StreamResource::class;

    /**
     * Extract the YouTube video ID before the record is stored.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['video_id'] = Stream::extractVideoId($data['youtube_url']);

        return $data;
    }
}
