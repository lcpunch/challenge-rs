<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'menu_id'];

    /**
     * @brief create order itens
     * @param array $items
     * @param int $orderId
     */
    public function createItems(array $items, int $orderId)
    {
        foreach($items as $item) {
            $orderItem = new OrderItem();
            $orderItem->menu_id = $item;
            $orderItem->order_id = $orderId;
            $orderItem->save();
        }
    }

    /**
     * @brief delete all items of a specific order
     * @param int $orderId
     */
    public function deleteAllItemsByOrderId(int $orderId)
    {
        OrderItem::where('order_id', '=', $orderId)
            ->delete();
    }

    /**
     * @param int $orderId
     * @return mixed
     */
    public function findItemsByOrder(int $orderId)
    {
        return OrderItem::where('order_id', '=', $orderId)
            ->get();
    }

}
