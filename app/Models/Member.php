<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'openid' => 'json',
        'other_data' => 'json',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function info()
    {
        return $this->hasOne(MemberInfo::class);
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        $attrs = self::getOtherAttr();

        if (in_array($key, $attrs)) {
            $data = $this->other_data;
            $data[$key] = $value;

            return parent::setAttribute('other_data', $data);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return $this->getAttributeValue('other_data')[$key] ?? parent::getAttribute($key);
    }

    public static function getOtherAttr()
    {
        return MemberAttr::pluck('attr_id')->toArray();
    }
}
