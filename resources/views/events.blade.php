<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-950">
        @include('partials.public-nav')

        <flux:main container class="py-12">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Events') }}</h1>
                <p class="mt-2 text-zinc-500 dark:text-zinc-400">{{ __('Church services, gatherings and special events.') }}</p>
            </div>

            {{-- Calendar --}}
            <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex items-center justify-between border-b border-zinc-200 px-6 py-4 dark:border-zinc-700">
                    <a href="{{ route('events', ['month' => $prevMonth]) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 text-zinc-600 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800" aria-label="{{ __('Previous month') }}">
                        <flux:icon name="chevron-left" variant="mini" />
                    </a>
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        {{ $month->format('F Y') }}
                    </h2>
                    <a href="{{ route('events', ['month' => $nextMonth]) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 text-zinc-600 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800" aria-label="{{ __('Next month') }}">
                        <flux:icon name="chevron-right" variant="mini" />
                    </a>
                </div>

                <div class="grid grid-cols-7 border-b border-zinc-200 text-center text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                    @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div class="py-3">{{ $day }}</div>
                    @endforeach
                </div>

                @foreach ($weeks as $week)
                    <div class="grid grid-cols-7 border-b border-zinc-100 last:border-b-0 dark:border-zinc-800">
                        @foreach ($week as $day)
                            <div class="min-h-24 border-r border-zinc-100 p-2 last:border-r-0 dark:border-zinc-800 {{ $day['inMonth'] ? '' : 'bg-zinc-50 dark:bg-zinc-800/40' }}">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full text-sm {{ $day['today'] ? 'bg-zinc-900 font-semibold text-white dark:bg-white dark:text-zinc-900' : ($day['inMonth'] ? 'text-zinc-700 dark:text-zinc-200' : 'text-zinc-400 dark:text-zinc-600') }}">
                                    {{ $day['date']->format('j') }}
                                </span>
                                <div class="mt-1 space-y-1">
                                    @foreach ($day['events'] as $event)
                                        <p class="truncate text-[11px] leading-tight text-zinc-700 dark:text-zinc-300">
                                            <span class="font-medium">{{ $event->starts_at->format('g:i A') }}</span>
                                            {{ $event->title }}
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            {{-- Upcoming events --}}
            <div class="mt-12">
                <h2 class="mb-4 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Upcoming events') }}</h2>

                @forelse ($upcomingEvents as $event)
                    <article class="mb-6 flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900 sm:flex-row">
                        @if ($event->image)
                            <img
                                src="{{ asset('storage/'.$event->image) }}"
                                alt="{{ $event->title }}"
                                class="h-40 w-full rounded-lg object-cover sm:w-56"
                            >
                        @endif

                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">{{ $event->title }}</h3>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $event->starts_at->format('l, F j, Y \a\t g:i A') }}
                                @if ($event->location)
                                    &middot; {{ $event->location }}
                                @endif
                            </p>
                            <p class="mt-2 whitespace-pre-line text-zinc-600 dark:text-zinc-300">{{ $event->description }}</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ $event->googleCalendarUrl() }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                                    <flux:icon name="calendar" variant="mini" />
                                    {{ __('Add to Google Calendar') }}
                                </a>
                                <a href="{{ $event->reminderUrl() }}" class="inline-flex items-center gap-2 rounded-lg border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 dark:border-zinc-600 dark:text-zinc-200 dark:hover:bg-zinc-800">
                                    <flux:icon name="bell" variant="mini" />
                                    {{ __('Set Reminder') }}
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl border border-dashed border-zinc-300 p-12 text-center text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                        {{ __('No upcoming events.') }}
                    </div>
                @endforelse
            </div>
        </flux:main>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>