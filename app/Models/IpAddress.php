<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    use HasFactory;

    protected $fillable = ['ip_add', 'label'];


    public function histories()
    {
        return $this->hasMany(IpAddressHistory::class, 'ip_address_id');
    }
}
