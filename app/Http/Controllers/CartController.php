<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Cart;
use App\Models\PaymentMethod;
use Auth;
use DB;
use View;
use Validator;

class CartController extends Controller
{
    public function addCart($id)
    {
        if(Auth::id()) {
            // dd($id);
            $user=auth()->user()->id;
            $cart = Cart::where('user_id', $user)
            ->where('item_id', $id)->first();
            // dd($cart);

            if($cart) {
                $items = Item::find($id);
                Cart::where('user_id', $user)
                ->where('item_id', $id)
                ->update([
                    "quantity" => $cart->quantity + 1,
                    "sellprice" => $cart->sellprice + $items->sellprice
                ]);

                return redirect()->back()->with('message', 'Product Added to Cart!');
            } else {
                $user=auth()->user();
                $items = Item::find($id);
                $cart = new Cart();

                $cart->user_id=$user->id;
                $cart->item_id=$items->id;
                $cart->quantity=$cart->quantity + 1;
                $cart->sellprice=$items->sellprice;
                $cart->save();
                // dd($cart);
                return redirect()->back()->with('message', 'Product Added to Cart!');
            }
        } else {
            return redirect('login');
        }
    }

    public function getItems()
    {
        $items = DB::table('items')
        ->join('categories', 'items.cat_id', '=', 'categories.id')
        ->where('categories.category_name', 'LIKE', '%Women%')//WHERE categories = men
        ->select('items.id as item_id', 'items.*', 'categories.*')->orderBy('items.id', 'ASC')
        ->get();

        return View::make(('customer.women'), compact('items'));
    }

}
