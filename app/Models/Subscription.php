<?php

namespace App\Models;

use App\Models\SubscriptionUser;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'renewed_at',
        'expired_at',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionUser()
    {
        return $this->hasOne(SubscriptionUser::class, 'subscription_id', 'id');
    }
}
