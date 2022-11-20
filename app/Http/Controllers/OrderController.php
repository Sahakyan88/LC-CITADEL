<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceReplacement;
use App\Models\ServiceTypes;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function getHash(){
        $c = uniqid (rand (),true);
        $md5c = md5($c); 
        return $md5c;
    }
    public function getSku(){
        $sku = uniqid('O-');
        return $sku;
    }
    public function homeOwner()
    {
        view()->share('menu', 'home-owner');
        $services = Service::all();
        $serviceTypes = ServiceTypes::all();
        $serviceReplacementices = ServiceReplacement::all();

        view()->share('services', $services);
        view()->share('serviceTypes', $serviceTypes);
        view()->share('serviceReplacementices', $serviceReplacementices);

        return view('app.home-owner');
    }

    public function create(Request $request)
    {
        // $request->validate([
        //     'first_name'      => 'required|string|max:255',
        //     'last_name'       => 'required|string|max:255',
        //     'new_gallery_id'  => 'required|int',
        //     'phone'           => 'required',
        //     'address'         => 'required',
        //     'service'         => 'required',
        //     'email'           => 'required',
        // ]);
        
        $order = new Order();
        $orderData = array();
        $orderData['replacment'] = array();

        $order->sku =  $this->getSku();
        $order->hash =  $hash  = $this->getHash();
        
        $order->first_name = $request->first_name;
        $order->gallery_id = $request->new_gallery_id;
        $order->last_name  = $request->last_name;
        $order->address    = $request->address;
        $order->email      = $request->email;
        $order->phone      = $request->phone;
        $order->find_us    = $request->find_us;
        $order->service_id = $request->service;
        $submittedPrice     = $request->total_price;
        
        $serviceId = $request->service;

        $serviceTypeTitle = 'service_type_'.$serviceId;
        $serviceType = $request->$serviceTypeTitle;
        $serviceTypeOther = null;

        //Todo Service type requierd ? 
        if($serviceType == "-1"){
            $serviceTypeOther = $request->service_other_type;
            $orderData['serviceTypeOther'] = $serviceTypeOther;
            $orderData['serviceType'] = "Other: ".$serviceType;
        }else{
            $serviceTypeObj =  ServiceTypes::select('title')->where("published",1)->where("id",$serviceType)->first();
            $orderData['serviceType'] = $serviceTypeObj->title;
        }  

        $service =  Service::select('id','price')->where("published",1)->where("id",$serviceId)->first();
        
        $serviceReplacment =  ServiceReplacement::select('id','price','title')->where("published",1)->where("parent_id",$serviceId)->get();
        $replacmentPrice = 0;
        foreach($serviceReplacment as $replacment){
            $replacment->price = $replacment->price > 0 ? $replacment->price : 0; 
            $replacmentTitle = "service_replacement_".$replacment->id;
            if($request->$replacmentTitle){
                $replacmentQtyTitle = "service_replacement_qty_".$replacment->id;
                $replacmentQty = $request->$replacmentQtyTitle;
                $orderData['replacment'][] = array('id'=>$request->$replacmentTitle,'qty'=>$replacmentQty,'price'=>$replacment->price,'title'=>$replacment->title);
                if($replacment->price > 0){
                    $replacmentPrice = $replacmentPrice + ($replacmentQty * $replacment->price);
                }
            }
        }
        $order->data = serialize($orderData);
        $total = $replacmentPrice + $service->price;

        if($total != $submittedPrice)
        {
            return json_encode(array('status' => 0,'message'=>"Something wrong with price, pls try again"));
        }
        $order->service_price = $service->price;
        $order->replacment_price = $replacmentPrice;
        $order->total = $total;
        $order->save();

        if($order->save()){
            $invoice   = new Invoice();
            $invoice->order_id = $order->id;
            $invoice->save();
            $id=$order->id;

            return json_encode(['status'=>1,'hash'=>$hash]);
        }
    }

    public function checkout($hash)
    {
        $query = DB::table('orders');

        $query->select(
            'orders.id as id',
            'orders.first_name',
            'orders.last_name',
            'orders.email',
            'orders.address',
            'orders.data',
            'orders.phone',
            'orders.service_id',
            'orders.total',
            'orders.service_price',
            'orders.replacment_price',
            'services.title'
        );
        $query->where('orders.hash', $hash);
        $query->leftJoin('services', 'services.id', '=', 'orders.service_id');
        $data = $query->first();
        $data->data = unserialize($data->data);
        
        view()->share('data', $data);
        view()->share('menu', 'checkout');
        return view('app.checkout');
    }
}
