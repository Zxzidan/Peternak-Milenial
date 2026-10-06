@props([
    'title',
    'value',
    'unit' => '',
    'desc' => '',
    'badge' => '',
    'badgeType' => 'default',
    'actionUrl' => '',
    'actionLabel' => 'Detail',
])

@php
    $badgeClasses = match($badgeType) {
        'danger' => 'text-red-700 bg-red-50 dark:bg-red-950/50 dark:text-red-300',
        'warning' => 'text-amber-700 bg-amber-50 dark:bg-amber-950/50 dark:text-amber-300',
        'success' => 'text-primary-700 bg-primary-50 dark:bg-primary-950/50 dark:text-primary-300',
        default => 'text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-300',
    };
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 flex flex-col justify-between shadow-xs transition hover:border-gray-300 dark:hover:border-gray-600']) }}>
    <div>
        <div class="flex items-center justify-between gap-2 mb-2">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $title }}</span>
            @if(isset($icon))
                <span class="text-gray-400 dark:text-gray-500">
                    {{ $icon }}
                </span>
            @endif
        </div>
        <div class="flex items-baseline gap-1.5">
            <span class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white tabular-nums">{{ $value }}</span>
            @if($unit)
                <span class="text-xs font-normal text-gray-500 dark:text-gray-400">{{ $unit }}</span>
            @endif
        </div>
        @if($desc)
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $desc }}</p>
        @endif
    </div>

    @if($badge || ($actionUrl && $actionLabel))
        <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
            @if($badge)
                <span class="inline-flex items-center font-medium px-2 py-0.5 rounded text-[11px] {{ $badgeClasses }}">
                    {{ $badge }}
                </span>
            @else
                <span></span>
            @endif

            @if($actionUrl && $actionLabel)
                <a href="{{ $actionUrl }}" class="font-medium text-primary-700 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 inline-flex items-center gap-1">
                    {{ $actionLabel }}
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </a>
            @endif
        </div>
    @endif
</div>
