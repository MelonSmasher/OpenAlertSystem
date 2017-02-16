<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MobileCarrier extends Model
{
    use SoftDeletes;
    protected $table = 'mobile_carriers';
    protected $dates = ['deleted_at'];
    protected $fillable = ['country_id', 'code', 'label'];


    /**
     * @return HasMany
     */
    public function mobilePhones()
    {
        return $this->hasMany(MobilePhone::class);
    }

    /**
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
