<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPackage extends Model
{
    use HasFactory;

    protected $table = 'subscriptions_packages';
    protected $guarded = ['id'];

    protected $fillable = [
        'name_package',
        'price',
        'color',
        'description',
    ];

    public function subscriptionPackageUsers(): HasMany
    {
        return $this->hasMany(SubscriptionPackageUser::class);
    }

    public function subscriptionPackageBooks(): HasMany
    {
        return $this->hasMany(SubscriptionPackageBook::class);
    }
}
