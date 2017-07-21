<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Repositories\SellerRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

//todo: Using queue
class ProductCreateNotification
{

    private $sellerRepo;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SellerRepository $repository)
    {
        $this->sellerRepo = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  ProductCreated  $event
     * @return void
     */
    public function handle(ProductCreated $event)
    {
        $this->sellerRepo->attachProduct($event->product);
    }
}
