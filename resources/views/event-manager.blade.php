<?php

    $shop =auth()->user();
    
    $collections =  $shop->api()->rest('GET','/admin/api/2021-10/custom_collections.json')['body']['custom_collections'];
    
    $products =  $shop->api()->rest('GET','/admin/api/2021-10/products.json')['body']['products'];
    
    ?>


<div class="event-manager-main">
    
    <div class="bread-crumbs">
        <a id="event-back"href="javascript:void(0)">
        
           <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><title/><g data-name="Layer 2" id="Layer_2"><path d="M10.1,23a1,1,0,0,0,0-1.41L5.5,17H29.05a1,1,0,0,0,0-2H5.53l4.57-4.57A1,1,0,0,0,8.68,9L2.32,15.37a.9.9,0,0,0,0,1.27L8.68,23A1,1,0,0,0,10.1,23Z"/></g></svg>
        
        </a>
        <h2>Pixel Management</h2>
    </div>
    
    <div class="event-container">
        
        <h4 class="pixel-title">{{$get_pixel_title}}</h4>
        
        <div class="event-content-outer">
            
            <div class="tracking-content">
                
                <h4>Tracking on pages</h4>
               
                <div class="option-container">
                    
                    <input type="radio" id="all_pages" name="tracking_type" value="all_ pages" {{$tracking_status == 0 ? 'checked' : ''}}>
                    <label for="all_pages">All Pages</label>
                    
                    <input type="radio" id="selected_page" name="tracking_type" value="selected_page" {{$tracking_status == 1 ? 'checked' : ''}}>
                    <label for="selected_page">Selected Page</label>
                    
                </div>
                
                
                <div class="product-container" style="{{$tracking_status== 1?'display:block':'display:none'}}">
                
                    <div id="success-message" style="display:none"></div>
        
                    <div class="collection-btn">+ Select Collections</div>
                    
                    <div class="product-type-btn">+ Product with Type(s)</div>
                    
                    <div class="product-tag-btn">+ Product with Tag(s)</div>
                    
                    <div class="product-btn">+ Product</div>
                    
                    <div class="collection-count" style="display:none"></div>
                    
                    <div class="product-count" style="display:none"></div>
                    
                    <div class="product-sub-btn" data-pixel-id="{{$get_pixel_id}}">+ Add</div>
                    
                    <ul id="selected-list">
                        
                        <?php
                        
                            if($ecollections != null)
                            {
                               $ecollections_array = explode(',',$ecollections); 
                               for($i=0;$i<count($collections);$i++)
                               {
                                   if(in_array($collections[$i]->id,$ecollections_array)){?>
                                   
                                   <li class="selected-list-item" data-type="collection" data-value="<?php echo $collections[$i]->id ?>"><span class="item-text"><?php echo $collections[$i]->title ?></span><span class="collection-item-btn item-btn" data-id="<?php echo $collections[$i]->id ?>">X</span></li>
                                <?php      
                                   }
                               }
                            }
                        ?>
                        
                        
                        <?php
                        
                            if($etypes != null)
                            {
                               $etypes_array = explode(',',$etypes); 
                               for($i=0;$i<count($products);$i++)
                               {
                                   if(in_array($products[$i]->product_type,$etypes_array)){?>
                                   
                                   <li class="selected-list-item" data-type="type" data-value="<?php echo $products[$i]->product_type ?>"><span class="item-text"><?php echo $products[$i]->product_type ?></span><span class="type-item-btn item-btn" data-id="<?php echo $products[$i]->product_type ?>">X</span></li>
                                <?php      
                                   }
                               }
                            }
                        ?>
                        
                        
                        <?php
                        
                            if($etags != null)
                            {
                               $etags_array = explode(',',$etags);
                               
                               $ptags = [];
        
                                for($i=0;$i<count($products);$i++) { 
                            
                                    $tags = explode(', ',$products[$i]->tags);
                                    
                                    for($k=0;$k<count($tags);$k++)
                                    {
                                        if(!in_array($tags[$k], $ptags))
                                        {
                                            $ptags[] =  $tags[$k];
                                        }
                                    }
                                }
                                
                                for($l=0;$l<count($ptags);$l++) { 
                                    
                                    $stag = $ptags[$l];
                                    
                                    if(in_array($stag,$etags_array))
                                        { ?>
                                        
                                            <li class="selected-list-item" data-type="tag" data-value="<?php echo $ptags[$l] ?>"><span class="item-text"><?php echo $ptags[$l] ?></span><span class="tag-item-btn item-btn" data-id="<?php echo $ptags[$l] ?>">X</span></li>
                                        
                                    <?php 
                                   }
                               }
                            }
                        ?>
                        
                        
                        <?php
                        
                            if($esproducts != null)
                            {
                               $eproducts_array = explode(',',$esproducts); 
                               for($i=0;$i<count($products);$i++)
                               {
                                   if(in_array($products[$i]->id,$eproducts_array)){?>
                                   
                                   <li class="selected-list-item" data-type="type" data-value="<?php echo $products[$i]->id ?>"><span class="item-text"><?php echo $products[$i]->title ?></span><span class="product-item-btn item-btn" data-id="<?php echo $products[$i]->id ?>">X</span></li>
                                <?php      
                                   }
                               }
                            }
                        ?>
                        
                    </ul>
                    
                </div>
                
                <span class="pixel-del-btn" data-id="{{$get_pixel_id}}" data-pixel-id="{{$get_pid}}">Remove</span>
                
            </div>
            
            
            
            <div class="event-content">
                
                <table id="event-table">
                    <tr>
                        <th>Event</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <tbody>
                        
                        <?php $counter = 1;?>
                        
                            @foreach ($get_events_data as $event)
                              
                              <tr>
                                <td> {{ $event->title }} </td>
                                <td> {{ $event->description }} </td>
                                <td> {{ $event->formatted_status }} </td>
                                <td> 
                                    <label class="event-switch">
                                      <input type="checkbox" class="event-btn" data-id="{{$event->id}}" pixel-id="{{$get_pid}}" data-event-id="<?php echo $counter; ?>" {{$event->status == 1 ? 'checked' : ''}}>
                                      <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                             <?php $counter++; ?>
                            @endforeach
                          
                    </tbody>
                </table>
                
                @if ($purchase_script)
                
                <div class="script-section">
                    
                    <div class="script-heading">Add the script below to the "Additional scripts" section within your checkout settings page on shopify admin.</div>
                    
                    <textarea id="pscript" name="pscript">{{$purchase_script}}</textarea>
                    
                </div>
                
                @endif
                
            </div>
            
        </div>
        
    </div>
    
</div>

 <div id="collectionModal" class="collection-modal pop-modal">

    <!-- Modal content -->
    <div class="collection-modal-content pop-content">
        <span class="collection-close">&times;</span>
        
        <div class="modal-heading">Select Collection</div>
        
        <div class="filter-outer">
        
        <input type="text" class="popup-filter" id="collection-filter" name="collection-filter" placeholder="Filter items" value="">
        
        <div class="filter-icon"><svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}</style></defs><title/><g data-name="Layer 2" id="Layer_2"><path d="M13,23A10,10,0,1,1,23,13,10,10,0,0,1,13,23ZM13,5a8,8,0,1,0,8,8A8,8,0,0,0,13,5Z"/><path d="M28,29a1,1,0,0,1-.71-.29l-8-8a1,1,0,0,1,1.42-1.42l8,8a1,1,0,0,1,0,1.42A1,1,0,0,1,28,29Z"/></g><g id="frame"><rect class="cls-1" height="32" width="32"/></g></svg></div>
        </div>
        
        <table id="collection-table">
                
            <tr>
                <th><input type="checkbox" id="all_collection" name="collection_all" value=""></th>
                <th>Collection</th>
            </tr>
            
            <tbody>
                
                <?php $pcollections_array = explode(',',$ecollections) ?>
             
                <?php for($i=0;$i<count($collections);$i++) { ?>
                
                    <tr>
                        <td><input type="checkbox" name="collection_list" value="<?php echo $collections[$i]->id; ?>" data-name="<?php echo $collections[$i]->title; ?>" <?php echo in_array( $collections[$i]->id, $pcollections_array) ? 'checked' : ''?>>
                        </td>
                        
                        <td class="title"><?php echo $collections[$i]->title; ?></td>
                        
                    </tr>
                    
                <?php } ?>  
                
            </tbody>
            
        </table>
        
        <div class="modal-btn-outer">
            
            <div class="modal-cancel-btn collection-cancel-btn">Cancel</div>
            
            <div class="modal-add-btn collection-add-btn">Add</div>
            
        </div>
    
    </div>

</div>



<div id="productTypeModal" class="product-type-modal pop-modal">

    <!-- Modal content -->
    <div class="product-type-modal-content pop-content">
        <span class="product-type-close">&times;</span>
        
        <div class="modal-heading">Select Type</div>
        
        <div class="filter-outer">
        
            <input type="text" class="popup-filter" id="type-filter" name="type-filter" placeholder="Filter items" value="">
            
            <div class="filter-icon"><svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}</style></defs><title/><g data-name="Layer 2" id="Layer_2"><path d="M13,23A10,10,0,1,1,23,13,10,10,0,0,1,13,23ZM13,5a8,8,0,1,0,8,8A8,8,0,0,0,13,5Z"/><path d="M28,29a1,1,0,0,1-.71-.29l-8-8a1,1,0,0,1,1.42-1.42l8,8a1,1,0,0,1,0,1.42A1,1,0,0,1,28,29Z"/></g><g id="frame"><rect class="cls-1" height="32" width="32"/></g></svg>
            </div>
        </div>
        
        <?php 
        
            $ptypes = [];
        
            for($i=0;$i<count($products);$i++) { 
        
                if(!in_array($products[$i]->product_type, $ptypes))
                {
                    $ptypes[] =  $products[$i]->product_type;
                }
            }
            
        ?>
            
        <table id="product-type-table">
            
            <tr>
                <th><input type="checkbox" id="all_type" name="type_all" value="">
            </th>
                <th>Type</th>
            </tr>
            
            <tbody>
                
                <?php $ptypes_array = explode(',',$etypes) ?>
                
                <?php for($j=0;$j<count($ptypes);$j++) { ?>
                
                    <tr>
                        
                        <td>  <input type="checkbox" name="type_list" value="<?php echo $ptypes[$j]; ?>" data-name="<?php echo $ptypes[$j]; ?>" <?php echo in_array( $ptypes[$j], $ptypes_array) ? 'checked' : ''?>>
                        </td>
                        
                        <td class="title"><?php echo $ptypes[$j]; ?> </td>
                        
                    </tr>
                  
                <?php } ?> 
                
            </tbody>
            
        </table>
        
        <div class="modal-btn-outer">
            
            <div class="modal-cancel-btn type-cancel-btn">Cancel</div>
            
            <div class="modal-add-btn type-add-btn">Add</div>
            
        </div>
        
    </div>

</div>


<div id="productTagModal" class="product-tag-modal pop-modal">

    <!-- Modal content -->
    <div class="product-tag-modal-content pop-content">
        <span class="product-tag-close">&times;</span>
        
        <div class="modal-heading">Select Tag</div>
        
        <div class="filter-outer">
        
            <input type="text" class="popup-filter" id="tag-filter" name="tag-filter" placeholder="Filter items" value="">
            
            <div class="filter-icon"><svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}</style></defs><title/><g data-name="Layer 2" id="Layer_2"><path d="M13,23A10,10,0,1,1,23,13,10,10,0,0,1,13,23ZM13,5a8,8,0,1,0,8,8A8,8,0,0,0,13,5Z"/><path d="M28,29a1,1,0,0,1-.71-.29l-8-8a1,1,0,0,1,1.42-1.42l8,8a1,1,0,0,1,0,1.42A1,1,0,0,1,28,29Z"/></g><g id="frame"><rect class="cls-1" height="32" width="32"/></g></svg>
            </div>
        </div>
        
        <?php 
        
            $ptags = [];
        
            for($i=0;$i<count($products);$i++) { 
        
                $tags = explode(', ',$products[$i]->tags);
                
                for($k=0;$k<count($tags);$k++)
                {
                    if(!in_array($tags[$k], $ptags))
                    {
                        $ptags[] =  $tags[$k];
                    }
                }
            }
            
        ?>
            
        <table id="product-tag-table">
            
            <tr>
                <tr>
                <th><input type="checkbox" id="all_tag" name="tag_all" value="">
            </th>
                <th>Tag</th>
            </tr>
            
            <tbody>
                
                <?php $ptags_array = explode(',',$etags) ?>
                
                <?php for($l=0;$l<count($ptags);$l++) { ?>
                 
                    <tr>
                        <td> <input type="checkbox" name="tag_list" value="<?php echo $ptags[$l]; ?>" data-name="<?php echo $ptags[$l]; ?>" <?php echo in_array( $ptags[$l], $ptags_array) ? 'checked' : ''?> ></td>
                          
                        <td class="title"><?php echo $ptags[$l]; ?> </td>
                    </tr>
                   
                <?php } ?> 
                
            </tbody>
            
        </table>
        
        <div class="modal-btn-outer">
            
            <div class="modal-cancel-btn tag-cancel-btn">Cancel</div>
            
            <div class="modal-add-btn tag-add-btn">Add</div>
            
        </div>
        
    </div>

</div>


<div id="productModal" class="product-modal pop-modal">

    <!-- Modal content -->
    <div class="product-modal-content pop-content">
        <span class="product-close">&times;</span>
        
        <div class="modal-heading">Select Item</div>
        
        <div class="filter-outer">
        
            <input type="text" class="popup-filter" id="product-filter" name="product-filter" placeholder="Filter items" value="">
            
            <div class="filter-icon"><svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}</style></defs><title/><g data-name="Layer 2" id="Layer_2"><path d="M13,23A10,10,0,1,1,23,13,10,10,0,0,1,13,23ZM13,5a8,8,0,1,0,8,8A8,8,0,0,0,13,5Z"/><path d="M28,29a1,1,0,0,1-.71-.29l-8-8a1,1,0,0,1,1.42-1.42l8,8a1,1,0,0,1,0,1.42A1,1,0,0,1,28,29Z"/></g><g id="frame"><rect class="cls-1" height="32" width="32"/></g></svg>
            </div>
        </div>
        
        <table id="product-table">
            
            <tr>
                <th><input type="checkbox" id="all_product" name="product_all" value=""></th>
                <th>Image</th>
                <th>Product</th>
            </tr>
            
            <tbody>
                
                 <?php $pproducts_array = explode(',',$esproducts); ?>
                
                <?php for($i=0;$i<count($products);$i++) {  ?>
                 
                    <tr>
                        <td> <input type="checkbox" name="product_list" value="<?php echo $products[$i]->id; ?>" data-name="<?php echo $products[$i]->title; ?>" <?php echo in_array( $products[$i]->id, $pproducts_array) ? 'checked' : ''?>></td>
                        
                        <?php
                        
                        $images = $products[$i]->images;
                        
                        $image_count = count($images);
                        
                        if($image_count > 0)
                        {
                        
                            for($j=0;$j<count($images);$j++) {  ?> 
                            
                                <td> <img class="prod-image" src="<?php echo $images[0]->src; ?>"></td>
                                
                            <?php } ?>
                            
                            
                       <?php } else { ?>
                        
                            <td> <img class="prod-image" src=""></td>
                            
                        <?php } ?>
                        
                        <td class="title"><?php echo $products[$i]->title; ?> </td>
                    </tr>
                   
                <?php } ?> 
                
            </tbody>
            
        </table>
        
        <div class="modal-btn-outer">
            
            <div class="modal-cancel-btn product-cancel-btn">Cancel</div>
            
            <div class="modal-add-btn product-add-btn">Add</div>
            
        </div>
        
    </div>

</div>


<style>
table {
    
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}


</style>
