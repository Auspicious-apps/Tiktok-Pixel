<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PixelProduct;

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

class PixelProductController extends Controller
{
    public function insert_products(Request $request)
    {
        
        $shop = auth()->user();
        $shop_id = $shop->id;
        
        $collections = $request->input('collections');
        $types = $request->input('types');
        $tags = $request->input('tags');
        $products = $request->input('products');
        $pixel_id = $request->input('pixel_id');
        
        $item_count = PixelProduct::where('shop_id',$shop_id)->where('pixel_id',$pixel_id)->count();
        
        if($item_count > 0)
        {
            PixelProduct::where('shop_id',$shop_id)->where('pixel_id',$pixel_id)->update([
                
                    'collections' => $collections,
                    'types' => $types,
                    'tags' => $tags,
                    'products' => $products
                ]);
            
        }
        else
        {
            $insert_product = new PixelProduct;
        
            $insert_product->shop_id = $shop_id;
            $insert_product->pixel_id = $pixel_id;
            $insert_product->collections = $collections;
            $insert_product->types = $types;
            $insert_product->tags = $tags;
            $insert_product->products = $products;
            $insert_product->save();
            
        }
        
        return response()->json([ 'success' => true, 'message'=> 'Items added successfully']);
        
    }
}
