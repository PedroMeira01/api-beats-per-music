<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'number',
        'add_on' ,
        'zip_code',
        'neighborhood',
        'city',
        'state',
        'addressable_id',
        'addressable_type'
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
