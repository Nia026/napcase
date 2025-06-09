<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MetodePembayaran extends Model
{
    use HasFactory;
    protected $table = 'metode_pembayarans';
    protected $fillable = ['name', 'value'];
}
