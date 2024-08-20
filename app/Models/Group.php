<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function getTokenAttribute($value)
    {
        return md5(sprintf('%s,%s,%s', $this->api_key, $this->api_secret, $this->app_code));
    }
}
