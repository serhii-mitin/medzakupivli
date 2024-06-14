<?php

namespace App\Models;

use App\Utils\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalFacility extends Model
{
    use HasFactory,
        SoftDeletes,
        Filterable;

    protected $fillable = [
        'name',
        'description',
    ];
}
