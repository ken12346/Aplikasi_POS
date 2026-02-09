<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
    {
        use hasfactory;

        protected $table = 'penjualan';
        
        protected $fillable = [
            'user_id',
            'total_pembayaran',
            'metode_pembayaran',
            'status'
        ];

        public function user ()
    {
        return $this->belongsTo(user::class, 'user_id');
    }

     public function itempenjualan()
     {
        return $this->hasMany(itempenjualan::class, 'penjualan_id');
     }
}
