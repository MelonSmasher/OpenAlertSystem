<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use SoftDeletes;
    protected $table = 'emails';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'address', 'verified'];
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
}
