<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['restaurant_id', 'user_id'];

    /**
     * @brief Inserts an order
     * @param integer $restaurantId
     * @param integer $userId
     * @return Order|string
     */
    public function create(int $restaurantId, int $userId)
    {
        try {
            $order = new Order();
            $order->restaurant_id = $restaurantId;
            $order->user_id = $userId;
            $order->save();

            return $order;
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param int $orderId
     * @return bool|null|void
     */
    public function deleteByOrderId(int $orderId)
    {
        Order::where('id', '=', $orderId)
            ->delete();
    }
}
