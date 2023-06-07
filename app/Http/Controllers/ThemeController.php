<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PixelDetail;
use App\Curluse;
use App\PixelEvent;
use App\PixelProduct;
use File;
use App\User;
use Osiset\BasicShopifyAPI\BasicShopifyAPI;
use Osiset\BasicShopifyAPI\Options;
use Illuminate\Support\Facades\Session;

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

class ThemeController extends Controller
{
   
   public function insert_content_view_script(Request $request)
   {
        $pid = $request->input('pixel_id');
        
        $tracking_type = $request->input('tracking_type');
        
        $shop =auth()->user();
       
        $shop_id = $shop->id;
        
        $shop_name = $shop->name;
       
        $pixels = PixelDetail::where('id', $pid)->where('shop_id',$shop_id)->get(['pixel_id']);
       
        $pixel_id = $pixels[0]->pixel_id;
       
        
        $events = '';
        
        $events = PixelEvent::where('shop_id',$shop_id)->where('status',1)->get(['pixel_id','event_id']);
        
        $view_script = '';
        
        $main_script = "var dg$; 
        var script = document.createElement('script');
        script.setAttribute('src', '//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js');
        script.addEventListener('load', function() {
        dg$ = $.noConflict(true);
        mainScript(dg$);});
        document.head.appendChild(script)";
        
        $mscript_start = "
        function mainScript($) {";
        $mscript_end = "
        }";
        
        $events_count = count($events);
        
        if($events_count > 0)
        {
            $pixel_array = [];
            
            for($i=0;$i<count($events);$i++)
            {
                $event_id = $events[$i]->event_id;
                $px_id = $events[$i]->pixel_id;
                
                if(!in_array($px_id,$pixel_array))
                {
                
                    $main_code = "
            
                        var showPixel = '';
                        
                        tiktokPixel = '".$px_id."';
                        
                        showPixel += \"ttq.load('\"+tiktokPixel+\"');\";
                        
                        var tiktokTrackCode = \"!function (w, d, t) { w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=['page','track','identify','instances','debug','on','off','once','ready','alias','group','enableCookie','disableCookie'],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i='https://analytics.tiktok.com/i18n/pixel/events.js';ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement('script');o.type='text/javascript',o.async=!0,o.src=i+'?sdkid='+e+'&lib='+t;var a=document.getElementsByTagName('script')[0];a.parentNode.insertBefore(o,a)};}(window, document, 'ttq');\"; 
                        
                       
                            $('head').append(\"<script>\"+tiktokTrackCode+\"\"+showPixel+\";ttq.page();</script>\");";
                          
                    $view_script = $view_script.''.$main_code;
                    
                    $pixel_array[] = $px_id;
                    
                }
                    
                //********** View Content Event Start ************
                
                if($event_id == 1)
                {
                    
                    $product_array = PixelProduct::where('shop_id',$shop_id)->where('pixel_id',$pixel_id)->get(['*']);
                    
                    $products_array_count = count($product_array);
        
                    if($products_array_count > 0 && $tracking_type == 'selected_page')
                    {
                    
                        $collections = $product_array[0]->collections;
                        $types = $product_array[0]->types;
                        $tags = $product_array[0]->tags;
                        $sproducts = $product_array[0]->products;
                        
                        if($collections != null)
                        {
                            $collections_array = explode(',', $collections);
                            
                            $cproducts_main_array = [];
                            
                            for($c=0;$c<count($collections_array);$c++)
                            {
                                $collection_id = $collections_array[$c];
                                
                                $collection =  $shop->api()->rest('GET','/admin/api/2023-04/collections/'.$collection_id.'.json')['body']['collection'];
                                
                                $content_id = $collection->id;
                                $collection_handle = $collection->handle;
                                $content_name = $collection->title;
                                
                                $pcode = "
                                
                                $(document).ready(function(){
                                        
                                            if (window.location.href.indexOf('"      .$collection_handle."') > -1) {
                                                ttq.instance('".$px_id."').track('ViewContent', {
                                                       content_id:".$content_id                 .",
                                                      content_name:'"                           .$content_name."'
                                                    });
                                                
                                            }
                                        });
                                    ";
                                        
                                    $view_script = $view_script.''.$pcode;
                                
                            }
                        }
                        if($types != null)
                        {
                            $types_array = explode(',', $types);
                            
                            for($t=0;$t<count($types_array);$t++)
                            {
                                $type = $types_array[$t];
                                
                                $products =  $shop->api()->rest('GET','/admin/api/2023-04/products.json')['body']['products'];
                                
                                for($p=0;$p<count($products);$p++)
                                {
                                    $ptype = $products[$p]->product_type;
                                    
                                    if($type == $ptype)
                                    {
                                        $variants = $products[$p]->variants;
                                        
                                        $chandle = $products[$p]->handle;
                                        
                                        for($k=0;$k<count($variants);$k++)
                                        {
                                            $product_price = $variants[0]->price;
                                        }                                                                               $content_id = $products[$p]->id;
                                        $content_type = 'product';
                                        $content_name = $products[$p]->title;
                                        $price = $product_price;
                        
                                        $pcode = "
                                       
                                        $(document).ready(function(){
                                            if (window.location.href.indexOf('"      .$chandle."') > -1) {
                                        
                                               ttq.instance('".$px_id."').track('ViewContent', {
                                                       content_id:".$content_id                 .",
                                                       content_type:'product',
                                                       content_name:'"                           .$content_name."',
                                                       quantity:1,
                                                       price:".$price."
                                                    });
                                                
                                            }
                                        });
                                        
                                    ";
                                        
                                        $view_script = $view_script.''.$pcode;
                                    }
                                }
                            }
                        }
                        else if($tags != null)
                        {
                            $tags_array = explode(',', $tags);
                            
                            $products =  $shop->api()->rest('GET','/admin/api/2023-04/products.json')['body']['products'];
                            
                            for($t=0;$t<count($tags_array);$t++)
                            {
                                $tag = $tags_array[$t];
                                
                                for($p=0;$p<count($products);$p++)
                                {
                                    $ptags = $products[$p]->tags;
                                    
                                    $ptags_array = explode(', ',$ptags);
                                    
                                    if(in_array($tag,$ptags_array)){
                                        
                                            $variants = $products[$p]->variants;
                                            
                                            $chandle = $products[$p]->handle;
                                            
                                            for($k=0;$k<count($variants);$k++)
                                            {
                                                $product_price = $variants[0]  
                                                ->price;
                                            }
                                            
                                            $content_id = $products[$p]->id;
                                            $content_name = $products[$p]->title;
                                            $price = $product_price;
                                            
                                            $pcode = "
                                            
                                        $(document).ready(function(){
                                        
                                            if (window.location.href.indexOf('"      .$chandle."') > -1) {
                                                ttq.instance('".$px_id."').track('ViewContent', {
                                                       content_id:".$content_id                 .",
                                                       content_type:'product',
                                                       content_name:'"                           .$content_name."',
                                                       quantity:1,
                                                       price:".$price."
                                                    });
                                                
                                            }
                                        });
                                    ";
                                        $view_script = $view_script.''.$pcode;
                                        
                                    }
                                }
                            }
                        }
                        else if($sproducts != null)
                        {
                            $sproducts_array = explode(',', $sproducts);
                            
                            for($t=0;$t<count($sproducts_array);$t++)
                            {
                               $sproduct_id = $sproducts_array[$t];
                                
                               $products =  $shop->api()->rest('GET','/admin/api/2023-04/products.json')['body']['products'];
                                
                                for($p=0;$p<count($products);$p++)
                                {
                                    $product_id = $products[$p]->id;
                                    
                                    if ($product_id == $sproduct_id)
                                    {
                                        $variants = $products[$p]->variants;
                                        
                                        $chandle = $products[$p]->handle;
                                        
                                        for($k=0;$k<count($variants);$k++)
                                        {
                                            $product_price = $variants[0]->price;
                                        }
                                        
                                        $content_id = $products[$p]->id;
                                        $content_name = $products[$p]->title;
                                        $price = $product_price;
                                        
                                        $pcode = "
                                       
                                        $(document).ready(function(){
                                            if (window.location.href.indexOf('"      .$chandle."') > -1) {
                                             ttq.instance('".$px_id."').track('ViewContent', {
                                                       content_id:".$content_id                 .",
                                                       content_type:'product',
                                                       content_name:'"                           .$content_name."',
                                                       quantity:1,
                                                       price:".$price."
                                                    });
                                            }
                                        });
                                    ";
                                        
                                        $view_script = $view_script.''.$pcode;
                                        
                                    }
                                }
                            }
                        }
                        
                    }
                    
                }
                
                if($event_id == 2)
                {
                    $cart_btn = 'button[name="add"]';
                    
                    $add_cart_code = "
                    
                    var pageURL = window.location.href;  
                    
                    var currency = $('.shopTiktokCurrency').text();
                            
                    if(pageURL.indexOf('/products/') > -1) {
                        // product page start 
                       
                        if (pageURL.indexOf('?') > -1) {
                            var producUrl = pageURL.split('?');
                            product_url = product_url[0] + '.json';
                        } else {
                            var productUrl = pageURL + '.json';
                        }    
                    }
                    
                    
                    $.ajax({
                            url: producUrl,
                            dataType: 'json',
                            header: {
                              'Access-Control-Allow-Origin': '*'
                            },
                            success: function(responseData) {
                                var product = responseData.product;
                                
                                $(document).on('click','".$cart_btn."',function(){
                                    data = $(this).parents('form').serializeArray();
                                    var quantity = '';
                                    var vid = '';
                                    var vname='';
                                    var shop_name = '".$shop_name."';
                                    $.each(data,function(i, field) {
                                        if(field.name == 'quantity')
                                        {
                                            quantity =field.value;
                                          
                                        }
                                        else
                                        {
                                            quantity = 1;
                                        }
                                      
                                        if(field.name == 'id')
                                        {
                                            vid =field.value;
                                          
                                        }
                                        
                                    });
                                    
                                    $.each(product.variants, function(index) {
                                        
                                        if(product.variants[index].id == vid){
                                            var price = product.variants[index]    .price;
                                            
                                            ttq.instance('".$px_id."').track('AddToCart', {content_id: product.id, content_type:'product_group', value:price, content_name:product.title,currency:currency});
                                    
                                        }
                                    
                                    });
                            
                                }); 
                            } 
                                                   
                        }); 
                    
                    ";
                    
                    $view_script = $view_script.''.$add_cart_code;
                }
                
                if($event_id == 3)
                {
                    
                    $btn_one = 'input[name="checkout"]';
                    
                    $checkout_code_one = "
                    
                    $(document).on('click','".$btn_one."',function(){
                        
                           ttq.instance('".$px_id."').track('InitiateCheckout');
                        });
                    
                    ";
                    
                    
                     $btn_two = 'button[name="checkout"]';
                    
                    
                    $checkout_code_two = "
                    
                    $(document).on('click','".$btn_two."',function(){
                        
                        ttq.instance('".$px_id."').track('InitiateCheckout');
                    });
                    
                    ";
                    
                    $view_script = $view_script.''.$checkout_code_one.''.$checkout_code_two;
                }
                
                if($event_id == 5)
                {
                    
                    $search_btn = 'input[name="q"]';
                    
                    $search_code = "
                    
                    $(document).on('submit','form.search',function(){
                        
                            var search_query = $('".$search_btn."').val();
                            var search_query_length = $('".$search_btn."').val().length;
                        
                            ttq.instance('".$px_id."').track('Search', {
                            
                               content_id:search_query_length,
                               query:search_query
                               
                            });
                            
                        });
                    
                    ";
                     
                    
                    $view_script = $view_script.''.$search_code;
                }
                
            }
            
            $view_script = $main_script.' '.$mscript_start.' '.$view_script.' '.$mscript_end;
        }
        else
        {
            
            $view_script = '';
        }
        
        // check directory for folder 'pull'
	    
	     if(is_dir(base_path().'/pull')) {
	         if (!is_dir(base_path().'/pull/'.$shop_name)) {
        		mkdir(base_path().'/pull/'.$shop_name);
        		$filepath = base_path().'/pull/'.$shop_name;
        	} else {
        		$filepath = base_path().'/pull/'.$shop_name;
        	}
        	$filename = $filepath.'/titkok.js';
        	$jsfile = fopen($filename, "w");
        	fwrite($jsfile, $view_script);
        	fclose($jsfile);
        }
        
        return $scripts;
    }
    
    
    public function get_product_deatils(Request $request)
    {
        
        $quantity = $request->input('quantity');
        
        $id = $request->input('vid');
        
        $shop_name = $request->input('shop_name');
        
        $shop = User::where('name',$shop_name)->first();
       
        $variant = $shop->api()->rest('GET','/admin/api/2021-10/variants/'.$id.'.json')['body']['variant'];
        
        if($variant->title == 'Default Title')
        {
            $name = '';
        }
        else
        {
            $name = $variant->title;
        }
        
        
        $price = $variant->price;
        
        $new_price = (float)$price;
        $new_quantity = (int)$quantity;
        
        $value = $new_price * $new_quantity;
        
        return response()->json([ 'success' => true, 'pname'=> $name, 'price'=>$price, 'value' => $value]);
    }
}
