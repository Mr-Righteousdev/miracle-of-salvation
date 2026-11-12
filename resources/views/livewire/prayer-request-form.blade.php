<div>
    @if (session('prayer_request_submitted'))
        <div class="alert alert-success text-center">
            <h3>{{ __('Prayer request submitted') }}</h3>
            <p>{{ __('Thank you. Our team will pray over your request.') }}</p>
        </div>
    @else
        <form wire:submit="submit">
            <div class="field-row">
                <div class="field">
                    <label for="prayer-name">{{ __('Your name (optional)') }}</label>
                    <input id="prayer-name" type="text" wire:model="name" autocomplete="name" maxlength="255">
                </div>
                <div class="field">
                    <label for="prayer-email">{{ __('Email (optional)') }}</label>
                    <input id="prayer-email" type="email" wire:model="email" autocomplete="email" maxlength="255">
                </div>
            </div>

            <div class="field">
                <label for="prayer-message">{{ __('Your prayer request') }}</label>
                <textarea id="prayer-message" wire:model="message" rows="6" required maxlength="5000"></textarea>
                @error('message')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Submit prayer request') }}</button>
        </form>
    @endif
</div>