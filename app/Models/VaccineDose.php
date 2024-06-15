<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VaccineDose extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'vaccine_id',
        'serial_number',
        'volume',
        'expiration_date',
        'used_date',
        'status',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'used_date' => 'date',
    ];

    protected function statusName(): Attribute
    {
        return Attribute::make(
            get: fn() => __('entities.vaccine.dose.statuses.' . $this->status),
        );
    }
}
