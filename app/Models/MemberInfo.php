<?php

namespace App\Models;

use App\Models\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberInfo extends Model
{
    use HasFactory;

    protected $casts = [
        'gender' => Gender::class,
        'birthday' => 'date',
        'phone_number' => 'encrypted',
    ];

    protected $guarded = false;

}
