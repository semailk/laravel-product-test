<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Product $product
    )
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Продукт был успешно создан! ' . $this->product->article)
            ->action('Просмотреть продукт', url('/products/' . $this->product->id) . ' ' . $this->product->name)
            ->line('Благодарим вас за использование нашего приложения!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
