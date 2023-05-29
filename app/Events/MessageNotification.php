<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $order;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $message)
    {
        $this->message = $message;
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('orderNotification');
    }

    public function broadcastWith()
    {
        if (Auth::guard('web')->user()->avatar) {
            $image = Storage::url(Auth::guard('web')->user()->avatar);
        } else {
            $image = asset('images/shop/no-avatar.png');
        }
        
        return [
            'image' => $image,
            'message' => $this->message,
            'link' => url('admin/orders?search='.$this->order->order_id)
        ];
    }
}
