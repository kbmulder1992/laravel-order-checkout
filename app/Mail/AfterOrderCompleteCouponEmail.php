<?php

namespace App\Mail;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AfterOrderCompleteCouponEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    const COUPON_EMAIL_SUBJECT = 'New Coupon Received (Value: %f)';

    private Coupon $coupon;
    private User $customer;

    public function __construct(Coupon $coupon, User $customer)
    {
        $this->coupon = $coupon;
        $this->customer = $customer;
    }

    public function build(): self
    {
        return $this
            ->subject(sprintf(self::COUPON_EMAIL_SUBJECT, $this->coupon->amount))
            ->html(sprintf('Hi %s, here\'s a new coupon code for %f off your next order: %s', $this->customer->name, $this->coupon->amount, $this->coupon->code));
    }
}
