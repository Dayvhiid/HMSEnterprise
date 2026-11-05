<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invo extends Model
{
    use HasFactory;
    protected $casts = [
        'price' => 'array',
        'name' => 'array',
        'qty' => 'array'
    ];

    protected $fillable = [
        'pid',
        'discount',
        'amount',
    ];

    /**
     * The invoice's line items as [name, price, qty, subtotal].
     * Reads the raw columns so it works for JSON rows and for old comma-separated rows alike.
     *
     * @return array<int, array{name: string, price: float, qty: int, subtotal: float}>
     */
    public function lines(): array
    {
        $column = function (string $key): array {
            $raw = $this->getRawOriginal($key) ?? $this->getAttributes()[$key] ?? null;
            if (is_array($raw)) {
                return array_values($raw);
            }
            $decoded = json_decode((string) $raw, true);
            if (is_array($decoded)) {
                return array_values($decoded);
            }

            return array_values(array_filter(array_map('trim', explode(',', (string) $raw)), fn ($v) => $v !== ''));
        };

        $names = $column('name');
        $prices = $column('price');
        $qtys = $column('qty');

        $lines = [];
        foreach ($names as $i => $name) {
            $price = (float) ($prices[$i] ?? 0);
            $qty = (int) ($qtys[$i] ?? 0);
            $lines[] = ['name' => (string) $name, 'price' => $price, 'qty' => $qty, 'subtotal' => $price * $qty];
        }

        return $lines;
    }

    /** Receipt number shown on printouts, e.g. RCT-000042. */
    public function receiptNumber(): string
    {
        return 'RCT-'.str_pad((string) $this->id, 6, '0', STR_PAD_LEFT);
    }

    /** Discount is stored as a percentage of the subtotal (see InvoiceController::save). */
    public function discountPercent(): float
    {
        return min(max((float) ($this->discount ?? 0), 0), 100);
    }

    /**
     * Gross (before discount), discount in naira, and net (what the patient pays).
     *
     * @return array{gross: float, discount: float, net: float}
     */
    public function totals(): array
    {
        $gross = array_sum(array_column($this->lines(), 'subtotal'));
        $discount = round($gross * $this->discountPercent() / 100, 2);

        return ['gross' => $gross, 'discount' => $discount, 'net' => $gross - $discount];
    }
}
