<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionPackageUser extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_package_id',
        'expired_date'
    ];

    public function subscriptionPackages(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPackage::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
