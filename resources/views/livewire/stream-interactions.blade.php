<div class="interactions">
    <div class="likes-bar">
        <button type="button" wire:click="toggleLike" class="btn btn-like {{ $liked ? 'is-liked' : '' }}">
            <span class="heart" aria-hidden="true">{{ $liked ? '&hearts;' : '&hearts;' }}</span>
            {{ $liked ? __('Liked') : __('Like this stream') }}
        </button>
        <span class="likes-count">{{ trans_choice(':count like|:count likes', $this->likesCount()) }}</span>
    </div>

    @if (! $stream->comments_enabled && ! $stream->comments_visible)
        <p class="empty-state">{{ __('Comments are turned off for this stream.') }}</p>
    @else
        <div class="comments">
            <h3>{{ __('Comments') }}</h3>

            @if ($stream->comments_visible)
                @forelse ($this->approvedComments() as $comment)
                    <div class="comment">
                        <div class="comment-meta">
                            <span class="comment-name">{{ $comment->name ?? __('Anonymous') }}</span>
                            <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="comment-message">{{ $comment->message }}</p>
                    </div>
                @empty
                    <p class="empty-state">{{ __('Be the first to leave a comment.') }}</p>
                @endforelse
            @endif
        </div>

        @if ($stream->comments_enabled)
            <div class="comment-form card">
                <h4>{{ __('Leave a comment') }}</h4>
                <p class="hint">{{ __('No account needed. Comments are shown after review.') }}</p>

                <form wire:submit="addComment" style="margin-top: 14px;">
                    <div class="field">
                        <label for="comment-name">{{ __('Name (optional)') }}</label>
                        <input id="comment-name" type="text" wire:model="name" autocomplete="name" maxlength="120">
                    </div>
                    <div class="field">
                        <label for="comment-message">{{ __('Message') }}</label>
                        <textarea id="comment-message" wire:model="message" rows="4" required maxlength="2000"></textarea>
                        @error('message')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Submit comment') }}</button>
                </form>

                @if (session('comment_submitted'))
                    <p class="alert alert-success">{{ __('Thank you! Your comment has been submitted for review.') }}</p>
                @endif
            </div>
        @endif
    @endif
</div>