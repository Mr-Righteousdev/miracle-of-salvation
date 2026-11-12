<?php

namespace App\Livewire;

use App\Models\Stream;
use App\Models\StreamComment;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class StreamInteractions extends Component
{
    public Stream $stream;

    public bool $liked = false;

    #[Validate(['nullable', 'string', 'max:120'])]
    public string $name = '';

    #[Validate(['required', 'string', 'max:2000'])]
    public string $message = '';

    public function mount(Stream $stream): void
    {
        $this->stream = $stream;
        $this->liked = $stream->likes()->where('liker_token', $this->likerToken())->exists();
    }

    public function toggleLike(): void
    {
        $existing = $this->stream->likes()->where('liker_token', $this->likerToken())->first();

        if ($existing) {
            $existing->delete();
            $this->liked = false;

            return;
        }

        $this->stream->likes()->create(['liker_token' => $this->likerToken()]);
        $this->liked = true;
    }

    public function addComment(): void
    {
        if (! $this->stream->comments_enabled) {
            return;
        }

        $this->validate();

        $this->stream->comments()->create([
            'name' => filled($this->name) ? $this->name : null,
            'message' => $this->message,
            'is_approved' => false,
        ]);

        $this->reset('name', 'message');

        session()->flash('comment_submitted', true);
    }

    /**
     * @return Collection<int, StreamComment>
     */
    public function approvedComments(): Collection
    {
        return $this->stream->comments()->approved()->latest()->get();
    }

    public function likesCount(): int
    {
        return $this->stream->likes()->count();
    }

    private function likerToken(): string
    {
        return (string) session()->getId();
    }

    public function render(): View
    {
        return view('livewire.stream-interactions');
    }
}
