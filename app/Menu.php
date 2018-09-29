<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * @param int $item
     * @param int $restaurantId
     * @return mixed
     */
    public function findMenuItem(int $item, int $restaurantId)
    {
        return Menu::where('id', '=', $item)
            ->where('restaurant_id', '=', $restaurantId)
            ->first();
    }
}
