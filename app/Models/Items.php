<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use SoftDeletes;
    protected $primaryKey ='item_id';
    protected $fillable =['item_name', 'description', 'is_active'];

    protected function casts(): array{
        return['is_active' => 'boolean',];
    }

    public function dailySales(){
        return $this->hasMany(DailySale::class,'item_id');
    }
    public function price_lists(){
        return $this->hasMany(PriceList::class, 'item_id');
    }
}
