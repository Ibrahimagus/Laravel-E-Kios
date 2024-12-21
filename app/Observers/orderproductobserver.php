<?php

namespace App\Observers;

use App\Models\orderproduct;
use App\Models\Product;


class orderproductobserver
{
    /**
     * Handle the orderproduct "created" event.
     */
    public function created(OrderProduct $orderProduct): void
    {
        $product = Product::find($orderProduct->product_id);
        $product->decrement('stock', $orderProduct->quantity);
    }

    /**
     * Handle the orderproduct "updated" event.
     */
    public function updated(orderproduct $orderproduct): void
    {
        $product = Product::find($orderProduct->product_id);
        $originalQuantity = $orderProduct->getOriginal('quantity');
        $newQuantity = $orderProduct->quantity;

        if ($originalQuantity !=  $newQuantity) {
            $product->increment('stock', $originalQuantity);
            $product->decrement('stock', $newQuantity);
        }

    }

    /**
     * Handle the orderproduct "deleted" event.
     */
    public function deleted(orderproduct $orderproduct): void
    {
        $product = Product::find($orderProduct->product_id);
        $product->increment('stock', $orderProduct->quantity);
    }

}
