<x-filament-panels::page>
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-white/10 dark:bg-white/5">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total events') }}</p>
            <p class="mt-2 text-3xl font-semibold text-gray-950 dark:text-white">{{ number_format($totalEvents) }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-white/10 dark:bg-white/5">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Upcoming') }}</p>
            <p class="mt-2 text-3xl font-semibold text-gray-950 dark:text-white">{{ number_format($upcomingEvents->count()) }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-white/10 dark:bg-white/5">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Past') }}</p>
            <p class="mt-2 text-3xl font-semibold text-gray-950 dark:text-white">{{ number_format($pastEvents->count()) }}</p>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/10 dark:bg-white/5">
            <h3 class="border-b border-gray-200 px-6 py-4 text-sm font-semibold text-gray-950 dark:border-white/10 dark:text-white">{{ __('Upcoming events') }}</h3>
            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($upcomingEvents as $event)
                        <tr class="text-left align-top">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-950 dark:text-white">{{ $event->title }}</p>
                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">{{ $event->starts_at->format('l, F j, Y \a\t g:i A') }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex rounded-full bg-success-50 px-2.5 py-1 text-xs font-medium text-success-700 dark:bg-success-400/10 dark:text-success-400">
                                    {{ __('Upcoming') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">{{ __('No upcoming events.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/10 dark:bg-white/5">
            <h3 class="border-b border-gray-200 px-6 py-4 text-sm font-semibold text-gray-950 dark:border-white/10 dark:text-white">{{ __('Past events') }}</h3>
            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($pastEvents as $event)
                        <tr class="text-left align-top">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-950 dark:text-white">{{ $event->title }}</p>
                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">{{ $event->starts_at->format('l, F j, Y \a\t g:i A') }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700 dark:bg-white/10 dark:text-gray-300">
                                    {{ __('Past') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">{{ __('No past events.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>