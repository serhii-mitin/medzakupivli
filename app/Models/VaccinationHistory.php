<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medical_facility_id',
        'vaccine_id',
        'dose_id',
        'selected_time',
        'completed_time',
        'status',
    ];

    protected $casts = [
        'selected_time' => 'datetime',
        'completed_time' => 'datetime',
    ];

    protected function statusName(): Attribute
    {
        return Attribute::make(
            get: fn() => __('entities.vaccine.vaccination_history.statuses.' . $this->status),
        );
    }

    public function vaccineDose()
    {
        return $this->belongsTo(VaccineDose::class, 'dose_id', 'id');
    }
}
