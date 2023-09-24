<?php

namespace App\Models;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    protected $table = 'subscription_user';

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
