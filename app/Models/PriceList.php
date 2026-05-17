<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceList extends Model
{
    use SoftDeletes;

    protected $table = 'price_list';

    protected $fillable = [
        'item_id',
        'price',
        'valid_from',
        'valid_to',
    ];

    protected function casts(): array
    {
        return [
            'price'      => 'decimal:2',
            'valid_from' => 'datetime',
            'valid_to'   => 'datetime',
        ];
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
