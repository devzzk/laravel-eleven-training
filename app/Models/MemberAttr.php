<?php

namespace App\Models;

use App\Models\Enums\AttrType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAttr extends Model
{
    use HasFactory;

    protected $casts = [
        'attr_type' => AttrType::class,
    ];
}
