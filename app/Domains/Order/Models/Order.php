<?php

declare(strict_types=1);

namespace App\Domains\Order\Models;

use App\Domains\Order\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'buckflow';

    protected $table = 'orders';

    protected $fillable = [
        'tracking_code',
        'customer_name',
        'customer_phone',
        'reseller_id',
        'created_by_user_id',
        'florist_user_id',
        'status',
        'payment_status',
        'total_amount',
        'total_cogs',
        'payment_method',
        'greeting_card_message',
        'event_type',
        'event_date',
        'crm_follow_up_status',
        'crm_last_contacted_at',
        'deadline_at',
        'production_started_at',
        'ready_at',
        'completed_at',
        'notes',
        'courier_name',
        'courier_tracking_url',
        'qc_photo_path',
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class,
        'total_amount' => 'float',
        'total_cogs' => 'float',
        'deadline_at' => 'datetime',
        'production_started_at' => 'datetime',
        'ready_at' => 'datetime',
        'completed_at' => 'datetime',
        'event_date' => 'date',
        'crm_last_contacted_at' => 'datetime',
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function florist(): BelongsTo
    {
        return $this->belongsTo(BuckflowUser::class, 'florist_user_id');
    }

    // ==========================================
    // SCOPES
    // ==========================================

    public function scopeFilter(Builder $query, ?string $status = null, ?string $search = null): Builder
    {
        return $query
            ->when($status, fn (Builder $q) => $q->where('status', $status))
            ->when($search, function (Builder $q) use ($search) {
                $q->where(function (Builder $sub) use ($search) {
                    $sub->where('tracking_code', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%");
                });
            });
    }

    // ==========================================
    // BACKWARD COMPATIBILITY / ALIAS ACCESSORS
    // ==========================================

    public function getOrderCodeAttribute(): string
    {
        return (string) $this->tracking_code;
    }

    public function getPreviewPhotoAttribute(): ?string
    {
        return $this->qc_photo_path;
    }

    public function getGreetingCardNoteAttribute(): ?string
    {
        return $this->greeting_card_message;
    }

    public function getDeliveryDateAttribute(): ?\DateTimeInterface
    {
        return $this->deadline_at;
    }

    public function getTotalPriceAttribute(): float
    {
        return (float) $this->total_amount;
    }

    public function getRecipientNameAttribute(): string
    {
        return (string) $this->customer_name;
    }

    public function getDeliveryAddressAttribute(): string
    {
        return (string) ($this->notes ?? 'Ambil di Studio / Dikirim Kurir');
    }

    public function getDeliveryMethodLabelAttribute(): string
    {
        return $this->isPickup() ? 'Ambil di Studio' : 'Kirim Kurir';
    }

    public function isPickup(): bool
    {
        if ($this->courier_name) {
            return false;
        }

        $noteLower = strtolower((string) $this->notes);
        return str_contains($noteLower, 'ambil') || str_contains($noteLower, 'pickup');
    }

    public function isDelivery(): bool
    {
        return !$this->isPickup();
    }

    // ==========================================
    // PRESENTATIONAL ACCESSORS
    // ==========================================

    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->total_amount, 0, ',', '.');
    }

    public function getFormattedTotalAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->total_amount, 0, ',', '.');
    }

    public function getQcPhotoUrlAttribute(): ?string
    {
        if (empty($this->qc_photo_path)) {
            return null;
        }

        if (str_starts_with($this->qc_photo_path, 'http://') || str_starts_with($this->qc_photo_path, 'https://')) {
            return $this->qc_photo_path;
        }

        if (file_exists(public_path($this->qc_photo_path))) {
            return asset($this->qc_photo_path);
        }

        $buckflowUrl = rtrim((string) config('services.buckflow.url', env('BUCKFLOW_APP_URL', 'http://127.0.0.1:8000')), '/');
        return "{$buckflowUrl}/storage/{$this->qc_photo_path}";
    }

    public function getPreviewPhotoUrlAttribute(): ?string
    {
        return $this->getQcPhotoUrlAttribute();
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status ? $this->status->label() : 'Diproses';
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->status ? $this->status->badgeClasses() : 'bg-surface text-cream border-border-subtle';
    }

    public function getStatusStepAttribute(): int
    {
        return $this->status ? $this->status->stepIndex() : 1;
    }

    public function getTrackingStepsAttribute(): array
    {
        return OrderStatusEnum::trackingSteps();
    }

    public function getCustomerApprovalStatusAttribute(): string
    {
        if (str_contains((string) $this->notes, '[Approval Customer: Disetujui')) {
            return 'APPROVED';
        }

        if (str_contains((string) $this->notes, '[Catatan Revisi Customer')) {
            return 'REVISION_REQUESTED';
        }

        return 'PENDING';
    }

    // ==========================================
    // PRIVACY MASKING ACCESSORS
    // ==========================================

    public function getMaskedCustomerNameAttribute(): string
    {
        return $this->maskString($this->customer_name);
    }

    public function getMaskedRecipientNameAttribute(): string
    {
        return $this->maskString($this->customer_name);
    }

    public function getMaskedCustomerPhoneAttribute(): string
    {
        if (empty($this->customer_phone)) {
            return '-';
        }
        $len = strlen($this->customer_phone);
        if ($len <= 6) {
            return str_repeat('*', $len);
        }
        $prefix = substr($this->customer_phone, 0, 4);
        $suffix = substr($this->customer_phone, -3);
        return $prefix . '****' . $suffix;
    }

    public function getMaskedDeliveryAddressAttribute(): string
    {
        if ($this->isPickup()) {
            return 'Ambil di Studio Maja Flower (Self Pick-up)';
        }

        if (empty($this->notes)) {
            return 'Pengiriman Kurir Studio Maja';
        }

        return 'Pengiriman Wilayah Jabodetabek (Detail disamarkan demi privasi)';
    }

    protected function maskString(?string $str): string
    {
        if (empty($str)) {
            return '-';
        }
        $words = explode(' ', trim($str));
        $masked = [];
        foreach ($words as $word) {
            $len = mb_strlen($word);
            if ($len <= 2) {
                $masked[] = $word;
            } else {
                $visible = min(2, $len - 1);
                $masked[] = mb_substr($word, 0, $visible) . str_repeat('*', max(2, $len - $visible));
            }
        }
        return implode(' ', $masked);
    }

    // ==========================================
    // SYNTHESIZED TIMELINES
    // ==========================================

    /**
     * @return Collection<int, object{status_title: string, notes: string|null, created_at: \DateTimeInterface}>
     */
    public function getTimelinesAttribute(): Collection
    {
        $events = collect();

        if ($this->created_at) {
            $events->push((object) [
                'status_title' => 'Pesanan Diterima Kasir & Terdaftar',
                'notes' => 'Nomor resi terbit. Menunggu konfirmasi pembayaran.',
                'created_at' => $this->created_at,
            ]);
        }

        if ($this->production_started_at) {
            $floristName = $this->florist?->name ?? 'Florist Studio Maja';
            $events->push((object) [
                'status_title' => 'Mulai Dirangkai di Meja Florist',
                'notes' => "Rangkaian sedang dikerjakan dengan cermat oleh: {$floristName}.",
                'created_at' => $this->production_started_at,
            ]);
        }

        if ($this->ready_at) {
            $courierText = $this->courier_name ? " (Kurir: {$this->courier_name})" : '';
            $events->push((object) [
                'status_title' => 'Buket Selesai Dirangkai & Lolos QC',
                'notes' => "Rangkaian telah selesai dan siap diantar/diambil{$courierText}.",
                'created_at' => $this->ready_at,
            ]);
        }

        if ($this->completed_at) {
            $events->push((object) [
                'status_title' => 'Pesanan Selesai / Diterima',
                'notes' => 'Buket telah berhasil diserahkan ke tangan penerima.',
                'created_at' => $this->completed_at,
            ]);
        }

        return $events->reverse()->values();
    }
}
