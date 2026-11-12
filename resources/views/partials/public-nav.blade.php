<flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <x-app-logo href="{{ route('home') }}" wire:navigate />

    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
            {{ __('Home') }}
        </flux:navbar.item>
        <flux:navbar.item icon="megaphone" :href="route('announcements')" :current="request()->routeIs('announcements')" wire:navigate>
            {{ __('Announcements') }}
        </flux:navbar.item>
        <flux:navbar.item icon="calendar-days" :href="route('events')" :current="request()->routeIs('events')" wire:navigate>
            {{ __('Events') }}
        </flux:navbar.item>
        <flux:navbar.item icon="video-camera" :href="route('live')" :current="request()->routeIs('live')" wire:navigate>
            {{ __('Live Stream') }}
        </flux:navbar.item>
        <flux:navbar.item icon="hand-raised" :href="route('prayer-requests')" :current="request()->routeIs('prayer-requests')" wire:navigate>
            {{ __('Prayer Requests') }}
        </flux:navbar.item>
    </flux:navbar>
</flux:header>