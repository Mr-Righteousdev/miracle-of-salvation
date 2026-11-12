<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-950">
        @include('partials.public-nav')

        <flux:main container class="py-12">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Live Stream') }}</h1>
                <p class="mt-2 text-zinc-500 dark:text-zinc-400">{{ __('Watch our services online and join the conversation.') }}</p>
            </div>

            @if ($stream)
                <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="aspect-video w-full bg-black">
                        <iframe
                            src="{{ $stream->embedUrl() }}"
                            title="{{ $stream->title }}"
                            class="h-full w-full"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>
                    </div>

                    <div class="border-b border-zinc-200 p-6 dark:border-zinc-700">
                        <div class="flex flex-wrap items-center gap-3">
                            @if ($stream->status->value === 'live')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-600 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white">
                                    <span class="h-2 w-2 rounded-full bg-white"></span>
                                    {{ __('Live now') }}
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                                    {{ __('Past service') }}
                                </span>
                            @endif
                            @if ($stream->starts_at)
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $stream->starts_at->format('l, F j, Y \a\t g:i A') }}
                                </span>
                            @endif
                        </div>
                        <h2 class="mt-3 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $stream->title }}</h2>
                    </div>

                    <div class="p-6">
                        <livewire:stream-interactions :stream="$stream" />
                    </div>
                </div>
            @else
                <div class="rounded-xl border border-dashed border-zinc-300 p-16 text-center dark:border-zinc-700">
                    <flux:icon name="video-camera" variant="outline" class="mx-auto size-12 text-zinc-400" />
                    <h2 class="mt-4 text-xl font-semibold text-zinc-900 dark:text-white">{{ __('No stream yet') }}</h2>
                    <p class="mt-2 text-zinc-500 dark:text-zinc-400">{{ __('Check back soon — our next service will appear here.') }}</p>
                </div>
            @endif
        </flux:main>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>