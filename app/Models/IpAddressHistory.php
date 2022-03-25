<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpAddressHistory extends Model
{
    use HasFactory;

    protected $fillable = ['history', 'ip_address_id', 'user_id'];

    protected $hidden = [
        'updated_at',
        'id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
