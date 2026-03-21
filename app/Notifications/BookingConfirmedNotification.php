<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Rental;

class BookingConfirmedNotification extends Notification
{
    use Queueable;

    protected $rental;

    /**
     * Create a new notification instance.
     */
    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Booking Confirmed - NJ Car Rentals')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your booking has been confirmed!')
            ->line('Vehicle: ' . $this->rental->vehicle->brand . ' ' . $this->rental->vehicle->model)
            ->line('Rental Period: ' . $this->rental->start_date->format('M d, Y') . ' to ' . $this->rental->end_date->format('M d, Y'))
            ->line('Duration: ' . $this->rental->days . ' day(s)')
            ->line('Total Price: ₱' . number_format($this->rental->total_price, 2))
            ->action('View Booking Details', route('customer.bookings'))
            ->line('Thank you for choosing NJ Car Rentals!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'rental_id' => $this->rental->id,
            'vehicle' => $this->rental->vehicle->brand . ' ' . $this->rental->vehicle->model,
            'start_date' => $this->rental->start_date->format('M d, Y'),
            'end_date' => $this->rental->end_date->format('M d, Y'),
            'total_price' => $this->rental->total_price,
            'message' => 'Your booking has been confirmed!',
        ];
    }
}
