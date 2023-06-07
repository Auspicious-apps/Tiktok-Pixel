<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PixelDetail;
use App\Http\Requests;
use Auth;
use App\User;
use App\Event;
use App\PixelEvent;
use App\PixelProduct;


header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

class PixelController extends Controller
{
    
    public function insert_pixel(Request $request)
    {
        $shop = auth()->user();
        $shop_id = $shop->id;
        
        $pixel_title = $request->input('pixel_title');
        $pixel_id = $request->input('pixel_id');
        $event_api = $request->input('event_api_status');
        $access_token = $request->input('tiktok_access_token');
        
        $insert_pixel = new PixelDetail;
        
        $insert_pixel->shop_id = $shop_id;
        $insert_pixel->pixel_title = $pixel_title;
        $insert_pixel->pixel_id = $pixel_id;
        $insert_pixel->event_api_status = $event_api;
        $insert_pixel->tiktok_access_token = $access_token;
        $insert_pixel->save();
        
        $events = Event::get(['id']);
        
        for($i=0;$i<count($events);$i++)
        {
            
            $event_id = $events[$i]->id;
            
            $insert_event = new PixelEvent;
        
            $insert_event->shop_id = $shop_id;
            $insert_event->pixel_id = $pixel_id;
            $insert_event->event_id = $event_id;
            $insert_event->save();
        }
        
        return response()->json([ 'success' => true, 'message'=> 'Pixel added successfully']);

    }
    
    
    public function get_pixels(Request $request)
    {
      
        $id = $request->input('id');
        $pixels = PixelDetail::where('shop_id',$id)->get(['*']);
        return datatables()->of($pixels)
         ->addColumn('action', function($row){
       
            $btn = '<a href="javascript:void(0)" id="managePixel" class="btn btn-success btn-sm" data-id="'.$row->id.'">Manage</a>';

            return $btn;
        })        
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true); 
        
    }
    
    
    public function delete_pixel(Request $request)
    {
        
        $pixel_id = $request->input('pixel_id');
        $shop = auth()->user();
        $shop_id = $shop->id;
       
        PixelEvent::where('shop_id',$shop_id)->where('pixel_id',$pixel_id)->delete();
        PixelProduct::where('shop_id',$shop_id)->where('pixel_id',$pixel_id)->delete();
        
        return response()->json([ 'success' => true]);
        
    }
    
    
    public function delete_pixels(Request $request)
    {
        
        $pixel_id = $request->input('pixel_id');
        $shop = auth()->user();
        $shop_id = $shop->id;
       
        PixelDetail::where('shop_id',$shop_id)->where('pixel_id',$pixel_id)->delete();
        
        return response()->json([ 'success' => true]);
        
    }
    
    
}
