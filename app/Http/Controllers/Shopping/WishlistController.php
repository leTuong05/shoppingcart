<?php

namespace App\Http\Controllers\Shopping;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function addToFavorite() {
        $params = request()->all();
        $params['user_id'] = Auth::user()->id;

        $itemExistInWishlist = Favorite::where([
            'product_id' => $params['product_id'],
            'user_id' => $params['user_id']
        ])->first();

        if ($itemExistInWishlist) {
            $newWishlistItem = false;
        }
        else {
            $newWishlistItem = Favorite::create($params);
            $product = Product::where('id', $params['product_id'])->first();
        }

        if ($newWishlistItem) {
            return [
                'status' => true,
                'product' => $product
            ];
        }

        return ['status' => false];
    }

    public function removeFromFavorite() {
        $params = request()->all();
        $params['user_id'] = Auth::user()->id;

        $isRemoved = Favorite::where([
            'product_id' => $params['product_id'],
            'user_id' => $params['user_id']
        ])->delete();

        if ($isRemoved) {
            return ['status' => true];
        }

        return ['status' => false];
    }
}
