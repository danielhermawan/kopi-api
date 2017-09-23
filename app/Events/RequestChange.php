<?php

namespace App\Events;

use App\Models\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RequestChange implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('request');
    }
    // todo: add private channel
    public function broadcastAs()
    {
        return 'request.change';
    }


    public function broadcastWith()
    {
        $user = $this->request->user;
        $products = DB::select('SELECT purchase_price, quantity 
              FROM request_product rp INNER JOIN products p On p.id = rp.product_id
              WHERE request_id = ?', [$this->request->id]);
        $sum = 0;
        foreach ($products as $p) {
            if($p->purchase_price != null)
                $sum += $p->purchase_price * $p->quantity;
        }
        return [
            "id" => $this->request->id,
            "seller" => [
                'name' => $user->name,
                'id' => $user->id
            ],
            "total" => $sum,
            "status" => $this->request->status,
            "created_at" => $this->request->created_at,
            "updated_at" => $this->request->updated_at
        ];
    }
}
