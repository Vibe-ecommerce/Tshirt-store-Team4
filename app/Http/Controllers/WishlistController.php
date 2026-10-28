<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function toggle($id)
    {
        $product = Product::findOrFail($id);
        $wishlist = Session::get('wishlist', []);

        if (in_array($id, $wishlist)) {
            $wishlist = array_values(array_diff($wishlist, [$id]));
            $message = "Removed {$product->name} from your wishlist.";
        } else {
            $wishlist[] = (int) $id;
            $message = "Added {$product->name} to your wishlist!";
        }

        Session::put('wishlist', $wishlist);
        return redirect()->back()->with('success', $message);
    }
}
