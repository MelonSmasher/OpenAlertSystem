<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MobilePhone extends Model
{
    use SoftDeletes;
    protected $table = 'mobile_phones';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'number', 'country_code', 'mobile_carrier_id', 'verified'];
    protected $touches = ['user'];


    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->user();
    }

    /**
     * @return BelongsTo
     */
    public function mobileCarrier()
    {
        return $this->belongsTo(MobileCarrier::class);
    }

    /**
     * @return BelongsTo
     */
    public function carrier()
    {
        return $this->mobileCarrier();
    }
}
