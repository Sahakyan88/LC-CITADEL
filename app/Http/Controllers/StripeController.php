<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Models\Order;

class StripeController extends Controller
{
  /**
   * success response method.

   *

   * @return \Illuminate\Http\Response

   */  public function stripe(Request $request)

  {
    $price = $request->price;
    $id    = $request->id;

    return view('app.stripe', compact('price', 'id'));
  }

  public function stripePost(Request $request)

  {

    Stripe\Stripe::setApiKey('sk_test_51LtslEGwBFZgS2PiFfq8fMPndqrBhnXOpKIX9D4TiGahM57IBpckhWCrAuN2khDtxRLJTXyAIpv90X0RctxsvvxA00N0CVvCos');
    $customer = Stripe\Customer::create(array(
      "address" => [

        "line1" => "Virani Chowk",

        "postal_code" => "360001",

        "city" => "Rajkot",

        "state" => "GJ",

        "country" => "IN",

      ],

      "email" => "demo@gmail.com",

      "name" => "Hardik Savani",

      "source" => $request->stripeToken

    ));



    Stripe\Charge::create([

      "amount" => $request->price,

      "currency" => "usd",

      "customer" => $customer->id,

      "description" => "Test payment from itsolutionstuff.com.",

      "shipping" => [

        "name" => "Jenny Rosen",

        "address" => [

          "line1" => "510 Townsend St",

          "postal_code" => "98140",

          "city" => "San Francisco",

          "state" => "CA",

          "country" => "US",

        ],

      ]

    ]);
    $order = Order::find($request->id);
    $order->status = 'approved';
    $order->save();
    Session::flash('success', 'Payment successful!');
    return redirect('/owner');
  }
}
