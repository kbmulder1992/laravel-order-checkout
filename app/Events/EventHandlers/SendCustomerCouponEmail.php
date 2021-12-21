<?php

namespace App\Events\EventHandlers;

use App\Events\OrderCreatedEvent;
use App\Mail\AfterOrderCompleteCouponEmail;
use App\Models\Coupon;
use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class SendCustomerCouponEmail
{
    const COUPON_NAME = 'Free 5 Euro Coupon';
    const COUPON_AMOUNT = 5.00;

    const EMAIL_DELAY_AFTER_EVENT_CREATED_IN_MINUTES = 15;

    public function handle(OrderCreatedEvent $event): void
    {
        $coupon = Coupon::create([
            'name' => self::COUPON_NAME,
            'amount' => self::COUPON_AMOUNT
        ]);

        $this->scheduleEmail($coupon, $event->getOrder()->getCustomer());
    }

    private function scheduleEmail(Coupon $coupon, User $customer): void
    {
        Mail::to($customer->email)
            ->later(
                now()->add(CarbonInterval::minutes(self::EMAIL_DELAY_AFTER_EVENT_CREATED_IN_MINUTES)),
                $this->getMailable($coupon, $customer)
            );
    }

    private function getMailable(Coupon $coupon, User $customer): Mailable
    {
        return new AfterOrderCompleteCouponEmail($coupon, $customer);
    }
}
