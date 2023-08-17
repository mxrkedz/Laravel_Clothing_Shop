<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Orderline;
use App\Models\User;
use App\Models\Shipper;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use Auth;
use DB;
use View;
use Validator;

class CheckoutController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        $shipper = Shipper::all();
        $cartitems = Cart::where('user_id', Auth::id())->get();
        if ($cartitems->isEmpty()) {
            return redirect()->route('cart.view')->with('message', 'Your cart is empty. Please add items to your cart before proceeding to checkout.');
        }
        return view('customer.checkout', compact('cartitems', 'paymentMethods', 'shipper'));
    }

    public function placeOrder(Request $request)
    {
        $order = new Order();

        $pmethod_id = $request->input('pmethod_id');
        $shipper_id = $request->input('shipper_id');

        if ($pmethod_id == "Select Payment Method") {
            return redirect()->back()->with('message', 'Please select a payment method.');
        }
        if ($shipper_id == "Select Shipper") {
            return redirect()->back()->with('message', 'Please select a shipping courier.');
        }
        $ship = $request->shipper_id;
        $pm = $request->pmethod_id;

        $order->pm_id = $pm;
        $order->ship_id = $ship;

        $order->fname = $request->input('fname');
        $order->lname = $request->input('lname');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->address1 = $request->input('address1');
        $order->address2 = $request->input('address2');
        $order->city = $request->input('city');
        $order->province = $request->input('province');
        $order->country = $request->input('country');
        $order->postcode = $request->input('postcode');
        $order->save();

        $order->id;

        $cartitems = Cart::where('user_id', Auth::id())->get();
        foreach($cartitems as $item) {
            $orderLineQuantity = $item->quantity;

            // Find the item's stock and update the quantity
            $stock = Stock::where('item_id', $item->item_id)->first();
            if ($stock) {
                $stock->quantity -= $orderLineQuantity;
                $stock->save();
            }
            Orderline::create([
                'item_id' => $item->item_id,
                'orderinfo_id' => $order->id,
                'quantity' => $item->quantity


            ]);
        }

        if(Auth::user()->address1 == null) {
            $user = User::where('id', Auth::id())->first();
            $user->name = $request->input('fname');
            $user->lname = $request->input('lname');
            $user->phone = $request->input('phone');
            $user->address1 = $request->input('address1');
            $user->address2 = $request->input('address2');
            $user->city = $request->input('city');
            $user->province = $request->input('province');
            $user->country = $request->input('country');
            $user->postcode = $request->input('postcode');
            $user->update();
        }
        Cart::where('user_id', Auth::id())->delete();

        // Send order confirmation email
        // Mail::to(Auth::user()->email)->send(new OrderConfirmation($order));
        Mail::to($order->email)->send(new OrderConfirmation($order->email, $order));

        // return response()->json(['success' => true, 'message' => 'Your order has been placed successfully.']);
        return redirect()->route('order.success');

    }

    public function success()
    {
        return view('transact.success');
    }
}
