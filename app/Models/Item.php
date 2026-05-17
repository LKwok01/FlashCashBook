<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'item_id';

    protected $fillable = ['item_name', 'description', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'item_id';
    }

    public function priceLists()
    {
        return $this->hasMany(PriceList::class, 'item_id');
    }

    public function activePrice()
    {
        return $this->hasOne(PriceList::class, 'item_id')
            ->where('valid_from', '<=', now())
            ->where(function ($q) {
                $q->whereNull('valid_to')->orWhere('valid_to', '>=', now());
            })
            ->latest('valid_from');
    }
}
