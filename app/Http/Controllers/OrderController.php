<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Order;
use App\OrderItem;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private $order;
    private $orderItem;
    private $menu;

    /**
     * OrderController constructor.
     * @param Order $order
     * @param OrderItem $orderItem
     * @param Menu $menu
     */
    public function __construct(Order $order, OrderItem $orderItem, Menu $menu)
    {
        $this->order     = $order;
        $this->orderItem = $orderItem;
        $this->menu      = $menu;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|integer',
            'menu_items'    => 'required|array',
            'user_id'       => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $restaurantId = $request->get('restaurant_id');
        $menuItems    = $request->get('menu_items');
        $userId       = $request->get('user_id');

        if (!Restaurant::find($restaurantId)) {
            return response()->json(
                ["error" => "Invalid restaurant: " . $restaurantId]
            );
        }

        foreach ($menuItems as $item) {
            if (!$this->menu->findMenuItem($item, $restaurantId)) {
                return response()->json(["error" => "Invalid menu item id: " . $item]);
            }
        }

        $orderResponse = $this->order->create($restaurantId, $userId);
        $this->orderItem->createItems($menuItems, $orderResponse->id);

        return response()->json(["success" => "Your order # is created: " . $orderResponse->id]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|integer',
            'menu_items'    => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $restaurantId = $request->get('restaurant_id');
        $menuItems    = $request->get('menu_items');
        $orderId      = $id;

        if (!Restaurant::find($restaurantId)) {
            return response()->json(
                ["error" => "Invalid restaurant: " . $restaurantId]
            );
        }

        foreach ($menuItems as $item) {
            if (!$this->menu->findMenuItem($item, $restaurantId)) {
                return response()->json(["error" => "Invalid menu item id: " . $item]);
            }
        }

        $this->orderItem->deleteAllItemsByOrderId($orderId);
        $this->orderItem->createItems($menuItems, $orderId);

        //@TODO return the updated order object
        return response()->json([
            "order" => $this->order->find($orderId),
            "orderItems" => $this->orderItem->findItemsByOrder($orderId)
        ]);
    }

    public function delete(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|integer',
            'order_id'      => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $restaurantId  = $request->get('restaurant_id');
        $orderId       = $request->get('order_id');

        if (!Restaurant::find($restaurantId)) {
            return response()->json(
                ["error" => "Invalid restaurant: " . $restaurantId]
            );
        }

        $this->orderItem->deleteAllItemsByOrderId($orderId);
        $this->order->deleteByOrderId($orderId);

        //@TODO return the updated order object
        return response()->json(["success" => "Your order # is deleted: " . $orderId]);
    }

}
