<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-950">
        @include('partials.public-nav')

        <flux:main container class="py-12">
            <div class="mx-auto max-w-2xl">
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Prayer Requests') }}</h1>
                    <p class="mt-2 text-zinc-500 dark:text-zinc-400">
                        {{ __('Share what is on your heart. Your request will be prayed over by our team.') }}
                    </p>
                </div>

                <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900 sm:p-8">
                    <livewire:prayer-request-form />
                </div>
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