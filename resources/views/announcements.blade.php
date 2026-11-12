<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-950">
        @include('partials.public-nav')

        <flux:main container class="py-12">
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Announcements') }}</h1>
                <p class="mt-2 text-zinc-500 dark:text-zinc-400">{{ __('News and updates from the church.') }}</p>
            </div>

            <div class="grid gap-6">
                @forelse ($announcements as $announcement)
                    <article class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900 sm:flex-row">
                        @if ($announcement->image)
                            <img
                                src="{{ asset('storage/'.$announcement->image) }}"
                                alt="{{ $announcement->title }}"
                                class="h-40 w-full rounded-lg object-cover sm:w-56"
                            >
                        @endif

                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                                {{ $announcement->published_at?->format('F j, Y') }}
                            </p>
                            <h2 class="mt-1 text-xl font-semibold text-zinc-900 dark:text-white">{{ $announcement->title }}</h2>
                            <p class="mt-2 whitespace-pre-line text-zinc-600 dark:text-zinc-300">{{ $announcement->body }}</p>
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl border border-dashed border-zinc-300 p-12 text-center text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                        {{ __('No announcements yet.') }}
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