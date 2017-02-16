<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use SoftDeletes;
    protected $table = 'countries';
    protected $dates = ['deleted_at'];
    protected $fillable = ['label', 'code', 'abbreviation'];

    /**
     * @return HasMany
     */
    public function mobileCarriers()
    {
        return $this->hasMany(MobileCarrier::class);
    }

}
