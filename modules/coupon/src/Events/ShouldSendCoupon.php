<?php

namespace Modules\Coupon\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShouldSendCoupon
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        protected int $couponId,
        protected $userUnionId,
    ) {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

    /**
     * @return int
     */
    public function getCouponId(): int
    {
        return $this->couponId;
    }

    /**
     * @return mixed
     */
    public function getUserUnionId(): mixed
    {
        return $this->userUnionId;
    }
}
