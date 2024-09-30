<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "tbl_transaction";
    public $timestamps = true;
    protected $guarded = [];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'kode_barang', 'kode_barang');
    }
}
