<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendProductCreatedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Product $product
    )
    {
    }

    public function handle()
    {
        $user = User::query()->where(User::USER_EMAIL, config('products.email'))->first();
        $user->notify(new ProductCreatedNotification($this->product));
    }
}
