<x-filament-panels::page>
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-white/10 dark:bg-white/5">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total requests') }}</p>
            <p class="mt-2 text-3xl font-semibold text-gray-950 dark:text-white">{{ number_format($total) }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-white/10 dark:bg-white/5">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Prayed for') }}</p>
            <p class="mt-2 text-3xl font-semibold text-success-600 dark:text-success-400">{{ number_format($prayedFor) }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-white/10 dark:bg-white/5">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Pending') }}</p>
            <p class="mt-2 text-3xl font-semibold text-warning-600 dark:text-warning-400">{{ number_format($pending) }}</p>
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/10 dark:bg-white/5">
        <h3 class="border-b border-gray-200 px-6 py-4 text-sm font-semibold text-gray-950 dark:border-white/10 dark:text-white">{{ __('Submissions over the last 12 months') }}</h3>
        @php
            $maxMonthly = max(1, $monthly->max());
        @endphp
        <div class="space-y-3 p-6">
            @foreach ($monthly as $month => $count)
                <div class="flex items-center gap-3">
                    <span class="w-20 shrink-0 text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($month.'-01')->format('M y') }}</span>
                    <div class="h-5 flex-1 overflow-hidden rounded bg-gray-100 dark:bg-white/5">
                        <div
                            class="h-full rounded {{ $count > 0 ? 'bg-primary-500 dark:bg-primary-400' : '' }}"
                            style="width: {{ ($count / $maxMonthly) * 100 }}%"
                        ></div>
                    </div>
                    <span class="w-8 shrink-0 text-right text-xs font-medium text-gray-700 dark:text-gray-300">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/10 dark:bg-white/5">
        <h3 class="border-b border-gray-200 px-6 py-4 text-sm font-semibold text-gray-950 dark:border-white/10 dark:text-white">{{ __('Recent prayer requests') }}</h3>
        <table class="w-full text-sm">
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse ($recent as $request)
                    <tr class="text-left align-top">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-950 dark:text-white">{{ $request->name ?? __('Anonymous') }}</p>
                            <p class="mt-0.5 line-clamp-2 text-xs text-gray-500 dark:text-gray-400">{{ $request->message }}</p>
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                            {{ $request->created_at->format('M j, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">{{ __('No prayer requests yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-filament-panels::page>