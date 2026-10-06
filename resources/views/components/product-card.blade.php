@props([
    'title',
    'price',
    'code' => 'SP',
    'desc' => '',
    'badge' => 'Terverifikasi',
    'region' => 'Jawa Timur',
])

@php
    $badgeColorClass = match($badge) {
        'Organik', 'RPH Halal' => 'text-green-700 bg-green-50 dark:bg-green-950/60 dark:text-green-300',
        'Terverifikasi', 'Bersertifikat' => 'text-cyan-700 bg-cyan-50 dark:bg-cyan-950/60 dark:text-cyan-300',
        'Siap Saji' => 'text-amber-700 bg-amber-50 dark:bg-amber-950/60 dark:text-amber-300',
        default => 'text-primary-700 bg-primary-50 dark:bg-primary-950/60 dark:text-primary-300',
    };
@endphp

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-700 p-3.5 flex flex-col justify-between hover:border-gray-300 dark:hover:border-gray-600 transition']) }}>
    <div>
        <!-- Top Meta -->
        <div class="flex items-center justify-between gap-1 mb-2">
            <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">
                {{ $region }}
            </span>
            @if($badge)
                <span class="text-[10px] font-medium {{ $badgeColorClass }} px-1.5 py-0.5 rounded">
                    {{ $badge }}
                </span>
            @endif
        </div>

        <!-- Product Title -->
        <h4 class="text-xs font-bold text-gray-900 dark:text-white line-clamp-1">
            {{ $title }}
        </h4>

        @if($desc)
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 line-clamp-2 leading-relaxed">
                {{ $desc }}
            </p>
        @endif
    </div>

    <!-- Bottom: Price and Order Action -->
    <div class="mt-3 pt-2.5 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
        <div>
            <span class="text-[10px] text-gray-400 block leading-none">Harga</span>
            <span class="text-xs font-bold text-gray-900 dark:text-white tabular-nums mt-0.5 block">{{ $price }}</span>
        </div>
        <button
            type="button"
            onclick="alert('Pesanan {{ addslashes($title) }} diproses.')"
            class="text-xs font-medium text-white bg-primary-700 hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700 px-2.5 py-1 rounded-md transition"
        >
            Pesan
        </button>
    </div>
</div>
