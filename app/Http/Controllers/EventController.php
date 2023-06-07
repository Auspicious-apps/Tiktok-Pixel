<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Event;
use App\PixelEvent;
use App\PixelDetail;
use App\PixelProduct;

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

class EventController extends Controller
{
    
    
    public function get_events(Request $request)
    {
        
        $pixel_id = $request->input('pixel_id');
        
        $purchase_script = '';
        
        //$tracking_type = $request->input('tracking_type');
        
        $pixels = PixelDetail::where('id',$pixel_id)->get(['shop_id','pixel_id','pixel_title']);
        
        $sid = $pixels[0]->shop_id;
        
        $pid = $pixels[0]->pixel_id;
        
        $ptitle = $pixels[0]->pixel_title;
        
        $events = PixelEvent::where('shop_id',$sid)->where('pixel_id',$pid)->get(['*']);
        
        $tracking_type = $events[0]->tracking_type;
        
        $products = PixelProduct::where('shop_id',$sid)->where('pixel_id',$pid)->get(['*']);
        
        $products_count = count($products);
        
        if($products_count > 0)
        {
        
            $collections = $products[0]->collections;
            $types = $products[0]->types;
            $tags = $products[0]->tags;
            $sproducts = $products[0]->products;
            
        }
        else
        {
            $collections = '';
            $types = '';
            $tags = '';
            $sproducts = '';
            
        }
        
        $tracking_status = 0;
        
        if($tracking_type == 'selected_page')
        {
            $tracking_status = 1;
        }
        
        
        $purchase_events = PixelEvent::where('shop_id',$sid)->where('pixel_id',$pid)->where('event_id',4)->get(['*']);
        
        $purchase_status = $purchase_events[0]->status;
        
        
        if($purchase_status == 1)
        {
        
                $purchase_main_script = '<script>
                        !function (w, d, t) {
                        w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};
                        ttq.load("'.$pid.'");
                        ttq.page();
                        }(window, document, "ttq");'; 
                        
                $purchase_code = '
                
                ttq.instance("'.$pid.'").track("CompletePayment");
                </script>';
                
                $purchase_script = $purchase_script.' '.$purchase_main_script.' '.$purchase_code;
        }
        
        
        $view = view('event-manager',['get_events_data'=>$events,'get_pixel_title'=>$ptitle,'get_pid'=>$pixel_id,'get_pixel_id'=>$pid,'tracking_status'=>$tracking_status,'ecollections'=>$collections,'etypes'=>$types,'etags'=>$tags,'esproducts'=>$sproducts,'purchase_script'=>$purchase_script])->render();
        
        return response()->json(['view'=>$view]);
        
    }
    
    
    public function edit_status(Request $request, $id)
    {
        
        $status = $request->input('status');
        $tracking_type = $request->input('tracking_type');
        
        if($status == 1)
        {
            PixelEvent::where('id',$id)->update([
            
                'status' => $status,
                'tracking_type' => $tracking_type
                
            ]);
            
        }
        
        if($status == 0)
        {
            PixelEvent::where('id',$id)->update([
            
                'status' => $status,
                'tracking_type' => null
                
            ]);
            
        }
        
        return response()->json(['success' => true]);
        
    }
    
   
}
