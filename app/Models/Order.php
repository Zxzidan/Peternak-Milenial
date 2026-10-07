<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'buyer_id',
        'total_amount',
        'status',
        'shipping_address',
        'buyer_phone',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Human-friendly Indonesian status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses Penjual',
            'shipped' => 'Dalam Pengiriman',
            'completed' => 'Pesanan Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst((string) $this->status),
        };
    }

    /**
     * Refined, subtle status badge classes (avoiding AI slop / oversaturated badges).
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200/70',
            'confirmed', 'processing' => 'bg-sky-50 text-sky-700 border-sky-200/70',
            'shipped' => 'bg-indigo-50 text-indigo-700 border-indigo-200/70',
            'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200/70',
            'cancelled' => 'bg-slate-100 text-slate-600 border-slate-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    }

    /**
     * Narrative explanation for the order detail view.
     */
    public function getStatusDescriptionAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pesanan menunggu penyelesaian konfirmasi pembayaran.',
            'confirmed' => 'Pesanan telah diterima dan dikonfirmasi oleh peternak.',
            'processing' => 'Pesanan sedang dikemas dan disiapkan dengan standar kesegaran ternak.',
            'shipped' => 'Pesanan dalam perjalanan pengiriman kurir logistik dingin menuju alamat Anda.',
            'completed' => 'Pesanan telah diterima dengan baik. Transaksi telah selesai.',
            'cancelled' => 'Pesanan ini telah dibatalkan.',
            default => 'Status pesanan sedang diperbarui.',
        };
    }

    /**
     * Stepper stage index (1-5) for visual tracking timeline.
     */
    public function getStatusStepIndexAttribute(): int
    {
        return match ($this->status) {
            'pending' => 1,
            'confirmed' => 2,
            'processing' => 3,
            'shipped' => 4,
            'completed' => 5,
            'cancelled' => 0,
            default => 1,
        };
    }

    /**
     * Extract payment method if stored in notes.
     */
    public function getParsedPaymentMethodAttribute(): string
    {
        if ($this->notes && preg_match('/Metode:\s*([^•\n]+)/', $this->notes, $matches)) {
            return trim($matches[1]);
        }

        return 'Transfer Bank / QRIS';
    }

    /**
     * Extract clean user notes without technical metadata prefix.
     */
    public function getCleanNotesAttribute(): ?string
    {
        if (! $this->notes) {
            return null;
        }

        if (preg_match('/Catatan:\s*(.*)/', $this->notes, $matches)) {
            $extracted = trim($matches[1]);

            return $extracted !== '' ? $extracted : null;
        }

        if (! str_contains($this->notes, 'Metode:')) {
            return trim($this->notes);
        }

        return null;
    }
}
