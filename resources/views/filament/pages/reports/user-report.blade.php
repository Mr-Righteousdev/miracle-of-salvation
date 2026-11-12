<x-filament-panels::page>
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-white/10 dark:bg-white/5">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total admin users') }}</p>
            <p class="mt-2 text-3xl font-semibold text-gray-950 dark:text-white">{{ number_format($totalUsers) }}</p>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/10 dark:bg-white/5">
            <h3 class="border-b border-gray-200 px-6 py-4 text-sm font-semibold text-gray-950 dark:border-white/10 dark:text-white">{{ __('Roles') }}</h3>
            <div class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse ($roles as $role)
                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm font-medium text-gray-950 dark:text-white">{{ $role->name }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $role->users_count }} {{ trans_choice('user|users', $role->users_count) }}</span>
                    </div>
                @empty
                    <p class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">{{ __('No roles defined.') }}</p>
                @endforelse
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white lg:col-span-2 dark:border-white/10 dark:bg-white/5">
            <h3 class="border-b border-gray-200 px-6 py-4 text-sm font-semibold text-gray-950 dark:border-white/10 dark:text-white">{{ __('Admin users') }}</h3>
            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($users as $user)
                        <tr class="text-left align-top">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-950 dark:text-white">{{ $user->name }}</p>
                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($user->roles as $role)
                                        <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700 dark:bg-white/10 dark:text-gray-300">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                {{ $user->created_at->format('M j, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">{{ __('No admin users yet.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>