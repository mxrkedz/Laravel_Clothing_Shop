<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\PaymentMethod;
use Auth;
use DB;
use View;
use Validator;

class CartController extends Controller
{
    public function addItem(Request $request)
    {
        $item_id = $request->input('item_id');
        $quantity = $request->input('quantity');

        if(Auth::check()) {

            $item_check = Item::where('id', $item_id)->first();

            if($item_check) {
                if (Cart::where('item_id', $item_id)->where('user_id', Auth::id())->exists()) {
                    return response()->json(['status' => $item_check->item_name." already added to cart!"]);
                } else {
                    $cartItem = new Cart();
                    $cartItem->item_id = $item_id;
                    $cartItem->user_id = Auth::id();
                    $cartItem->quantity = $quantity;
                    $cartItem->save();
                    return response()->json(['status' => $item_check->item_name." added to cart!"]);
                }
            }
        } else {
            return response()->json(['status' => "Login To Continue!"]);
        }
    }

    public function viewCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        return view('customer.cart', compact('cartItems'));
    }

    public function deleteItem(Request $request)
    {
        if(Auth::check()) {
            $item_id = $request->input('item_id');
            if(Cart::where('item_id', $item_id)->where('user_id', Auth::id())->exists()) {
                $cartItem = Cart::where('item_id', $item_id)->where('user_id', Auth::id())->first();
                $cartItem->delete();
                return response()->json(['status' => "Item Removed Successfully!"]);
            }
        } else {
            return response()->json(['status' => "Login To Continue!"]);
        }
    }

    public function updateCart(Request $request)
    {
        $item_id = $request->input('item_id');
        $quantity = $request->input('quantity');

        if(Auth::check()) {
            if(Cart::where('item_id', $item_id)->where('user_id', Auth::id())->exists()) {
                $cart = Cart::where('item_id', $item_id)->where('user_id', Auth::id())->first();
                $cart->quantity = $quantity;
                $cart->update();

                return response()->json(['status' => "Quantity Updated!"]);
            }
        }
    }

    public function addCart($id)
    {
        // if(Auth::id()) {
        //     // dd($id);
        //     $user=auth()->user()->id;
        //     $cart = Cart::where('user_id', $user)
        //     ->where('item_id', $id)->first();
        //     // dd($cart);

        //     if($cart) {
        //         $items = Item::find($id);
        //         Cart::where('user_id', $user)
        //         ->where('item_id', $id)
        //         ->update([
        //             "quantity" => $cart->quantity + 1,
        //             "sellprice" => $cart->sellprice + $items->sellprice
        //         ]);

        //         return redirect()->back()->with('message', 'Product Added to Cart!');
        //     } else {
        //         $user=auth()->user();
        //         $items = Item::find($id);
        //         $cart = new Cart();

        //         $cart->user_id=$user->id;
        //         $cart->item_id=$items->id;
        //         $cart->quantity=$cart->quantity + 1;
        //         $cart->sellprice=$items->sellprice;
        //         $cart->save();
        //         // dd($cart);
        //         return redirect()->back()->with('message', 'Product Added to Cart!');
        //     }
        // } else {
        //     return redirect('login');
        // }

        $items = Item::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "item_name" => $items->item_name,
                "img_path" => $items->img_path,
                "price" => $items->sellprice,
                "quantity" => 1
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product Added to Cart!');
    }

    public function cart()
    {
        return view('customer.cart');
    }

    public function checkout()
    {
        return view('customer.checkout');
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product successfully removed!');
        }
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart successfully updated!');
        }
    }

    public function getItems()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $items = DB::table('items')
        ->join('categories', 'items.cat_id', '=', 'categories.id')
        ->join('suppliers', 'items.sup_id', '=', 'suppliers.id')
        ->whereRaw('LOWER(categories.category_name) = ?', ['Women'])//WHERE categories = men
        ->select('items.id as item_id', 'items.img_path as img', 'items.*', 'categories.*', 'suppliers.*')->orderBy('items.id', 'ASC')
        ->get();

        return View::make(('customer.women'), compact('items'));
    }

    public function getItems2()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $items = DB::table('items')
        ->join('categories', 'items.cat_id', '=', 'categories.id')
        ->join('suppliers', 'items.sup_id', '=', 'suppliers.id')
        ->whereRaw('LOWER(categories.category_name) = ?', ['Men'])//WHERE categories = men
        ->select('items.id as item_id', 'items.img_path as img', 'items.*', 'categories.*', 'suppliers.*')->orderBy('items.id', 'ASC')
        ->get();

        return View::make(('customer.men'), compact('categories', 'items', 'suppliers'));
    }

    public function getItems3()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $items = DB::table('items')
        ->join('categories', 'items.cat_id', '=', 'categories.id')
        ->join('suppliers', 'items.sup_id', '=', 'suppliers.id')
        ->whereRaw('LOWER(categories.category_name) = ?', ['Unisex'])//WHERE categories = men
        ->select('items.id as item_id', 'items.img_path as img', 'items.*', 'categories.*', 'suppliers.*')->orderBy('items.id', 'ASC')
        ->get();

        return View::make(('customer.unisex'), compact('items'));
    }

}
