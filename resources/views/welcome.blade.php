@extends('shopify-app::layouts.default')

@section('content')

    <?php
      $shop = auth()->user();
      $shop_id = $shop->id;
    
    ?>
    
    
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" />
    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    

    <div class="container">
        
        <div class="shop-id" style="display:none"><?php echo $shop_id ?></div>
        <div id="exTab1">
            <ul class="nav tabs">
                <li class="active">
                    <a href="#1a" data-toggle="tab" data-id ="1a" class="active" id="one_tab">Home</a>
                </li>
                <li><a href="#2a" data-toggle="tab" data-id ="2a" id="two-tab">Pixel Management</a>
                </li>
                <li><a href="mailto:support@lifted-apps.net" id="three-tab" target="_blank">Support</a>
                </li>
                <li><a href="#4a" data-toggle="tab" id="four-tab" >By Lifted Apps</a>
                </li>
            </ul>

            <div class="tab-content clearfix">
                <div class="tab-pane active" id="1a">
                  @include('home')
                </div>
                <div class="tab-pane" id="2a">
                    @include('pixel-management')
                </div>
               
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--<script>-->
    <!--    actions.TitleBar.create(app, { title: 'Welcome' });-->
    <!--</script>-->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.1/js/jquery.dataTables.min.js"></script>
    
   
    <script>
        
        $(document).ready(function(){
            
            //var shop="{{ Auth::user() }}";
            
            get_pixel_list();
            
            $('#collection-table').DataTable();
           
            $('.pixel-btn').click(function(){
                
                $('#pixelsModal').show();
                
            });
            
            $('.pixels-close').click(function(){
                
                $('#pixelsModal').hide();
                
            });
            
            $(document).on('click','.pixel-management-close',function(){
                
                $('#pixelManagementModal').hide();
                
            });
            
            
            /* ------  Collection Model Starts ------ */
            
            $('body').on('click', '.collection-btn', function (event) {
               
                $('#collectionModal').show();
                
            });
            
            $('body').on('click', '.collection-close', function (event) {
            
                 $('#collectionModal').hide();
                
            });
            
            $('body').on('click', '.collection-cancel-btn', function (event) {
            
                 $('#collectionModal').hide();
                
            });
            
            
            $('body').on('click', '.collection-add-btn', function (event) {
                
                //$('#selected-list').html('');
                
                $('#selected-list li').each(function(){
                    
                    var data_type = $(this).attr('data-type');
                    
                    if(data_type == 'collection')
                    {
                        $(this).remove();
                    }
                    
                });
                
                $('input:checkbox[name="collection_list"]:checked').each(function(){
                    
                    var cval = $(this).val();
                    var dname = $(this).attr('data-name');
                    
                    var item_flag = false;
                    
                    var item = '<li class="selected-list-item" data-type="collection" data-value="'+cval+'"><span class="item-text">'+dname+'</span><span class="collection-item-btn item-btn" data-id="'+cval+'">X</span></li>';
                   
                    $('#selected-list').append(item);
                    
                    $('#collectionModal').hide();

                });
                
            });
            
            
            $('body').on('click', '.collection-item-btn', function (event) {
                
                var sval = $(this).attr('data-id');
                
                $('input:checkbox[name="collection_list"]:checked').each(function(){
                    
                    var cval = $(this).val();
                   
                    if(cval == sval)
                    {
                        $(this).prop('checked', false);
                    }
                    
                });
                
                $(this).parent('li').remove();
                
            });
            
                
            $('body').on('click', '#all_collection', function (event) {

                $('input:checkbox[name="collection_list"]').prop('checked', $(this).prop('checked'));
    
            });
            
            $('body').on('click', 'input:checkbox[name="collection_list"]', function (event) {

               if ($('input:checkbox[name="collection_list"]').length == $('input:checkbox[name="collection_list"]:checked').length) {
                    $("#all_collection").prop("checked", true);
                } else {
                    $("#all_collection").prop('checked',false);
                }
    
            });
            
            
            /* ------  Collection Model Ends ------ */
            
            
            /* ------  Type Model Starts ------ */
            
            $('body').on('click', '.product-type-btn', function (event) {
            
                $('#productTypeModal').show();
                
            });
            
            $('body').on('click', '.product-type-close', function (event) {
            
                $('#productTypeModal').hide();
                
            });
            
            $('body').on('click', '.type-cancel-btn', function (event) {
            
                $('#productTypeModal').hide();
                
            });
            
            
            $('body').on('click', '.type-add-btn', function (event) {
                
                $('#selected-list li').each(function(){
                    
                    var data_type = $(this).attr('data-type');
                    
                    if(data_type != 'collection')
                    {
                        $(this).remove();
                    }
                    
                });
                
                $('input:checkbox[name="type_list"]:checked').each(function(){
                    
                    var tyval = $(this).val();
                    var tyname = $(this).attr('data-name');
                    
                    var item = '<li class="selected-list-item" data-type="type" data-value="'+tyval+'"><span class="item-text">'+tyname+'</span><span class="type-item-btn item-btn" data-id="'+tyval+'">X</span></li>';
                    
                    
                    $('#selected-list').append(item);
                    
                    $('#productTypeModal').hide();

                });
                
            });
            
            
            $('body').on('click', '.type-item-btn', function (event) {
                
                var sval = $(this).attr('data-id');
                
                $('input:checkbox[name="type_list"]:checked').each(function(){
                    
                    var tyval = $(this).val();
                   
                    if(tyval == sval)
                    {
                        $(this).prop('checked', false);
                    }
                    
                });
                
                $(this).parent('li').remove();
                
            });
            
            
            $('body').on('click', '#all_type', function (event) {

                $('input:checkbox[name="type_list"]').prop('checked', $(this).prop('checked'));
    
            });
            
            $('body').on('click', 'input:checkbox[name="type_list"]', function (event) {

               if ($('input:checkbox[name="type_list"]').length == $('input:checkbox[name="type_list"]:checked').length) {
                    $("#all_type").prop("checked", true);
                } else {
                    $("#all_type").prop('checked',false);
                }
    
            });
            
            
            /* ------  Type Model Ends ------ */
            
            
            /* ------  Tag Model Starts ------ */
            
            $('body').on('click', '.product-tag-btn', function (event) {
                
                $('#productTagModal').show();
                
            });
            
            $('body').on('click', '.product-tag-close', function (event) {
           
                $('#productTagModal').hide();
                
            });
            
            
            $('body').on('click', '.tag-cancel-btn', function (event) {
           
                $('#productTagModal').hide();
                
            });
            
            
            $('body').on('click', '.tag-add-btn', function (event) {
                
                
                 $('#selected-list li').each(function(){
                    
                    var data_type = $(this).attr('data-type');
                    
                    if(data_type != 'collection')
                    {
                        $(this).remove();
                    }
                    
                });
                    
                $('input:checkbox[name="tag_list"]:checked').each(function(){
                    
                    var tgval = $(this).val();
                    var tgname = $(this).attr('data-name');
                    
                    var item = '<li class="selected-list-item" data-type="tag" data-value="'+tgval+'"><span class="item-text">'+tgname+'</span><span class="tag-item-btn item-btn" data-id="'+tgval+'">X</span></li>';
                    
                    
                    $('#selected-list').append(item);
                    
                    $('#productTagModal').hide();

                });
                
            });
            
            
            $('body').on('click', '.tag-item-btn', function (event) {
                
                var sval = $(this).attr('data-id');
                
                $('input:checkbox[name="tag_list"]:checked').each(function(){
                    
                    var tgval = $(this).val();
                   
                    if(tgval == sval)
                    {
                        $(this).prop('checked', false);
                    }
                    
                });
                
                $(this).parent('li').remove();
                
            });
            
            $('body').on('click', '#all_tag', function (event) {

                $('input:checkbox[name="tag_list"]').prop('checked', $(this).prop('checked'));
    
            });
            
            $('body').on('click', 'input:checkbox[name="tag_list"]', function (event) {

               if ($('input:checkbox[name="tag_list"]').length == $('input:checkbox[name="tag_list"]:checked').length) {
                    $("#all_tag").prop("checked", true);
                } else {
                    $("#all_tag").prop('checked',false);
                }
    
            });
            
            
            /* ------  Tag Model Ends ------ */
            
            
            /* ------  Product Model Starts ------ */
            
            
            $('body').on('click', '.product-btn', function (event) {
                
                $('.pop-modal').hide();
                
                $('#productModal').show();
                
            });
            
            $('body').on('click', '.product-close', function (event) {
           
                $('#productModal').hide();
                
            });
            
            $('body').on('click', '.product-cancel-btn', function (event) {
           
                $('#productModal').hide();
                
            });
            
            
            
            $('body').on('click', '.product-add-btn', function (event) {
                
                
                 $('#selected-list li').each(function(){
                    
                    var data_type = $(this).attr('data-type');
                    
                    if(data_type != 'collection')
                    {
                        $(this).remove();
                    }
                    
                });
                    
                $('input:checkbox[name="product_list"]:checked').each(function(){
                    
                    var pdval = $(this).val();
                    var pdname = $(this).attr('data-name');
                    
                    var item = '<li class="selected-list-item" data-type="product" data-value="'+pdval+'"><span class="item-text">'+pdname+'</span><span class="product-item-btn item-btn" data-id="'+pdval+'">X</span></li>';
                    
                   
                    $('#selected-list').append(item);
                    
                    $('#productModal').hide();

                });
                
            });
            
            
            $('body').on('click', '.product-item-btn', function (event) {
                
                var sval = $(this).attr('data-id');
                
                $('input:checkbox[name="product_list"]:checked').each(function(){
                    
                    var pdval = $(this).val();
                   
                    if(pdval == sval)
                    {
                        $(this).prop('checked', false);
                    }
                    
                });
                
                $(this).parent('li').remove();
                
            });
            
            $('body').on('click', '#all_product', function (event) {

                $('input:checkbox[name="product_list"]').prop('checked', $(this).prop('checked'));
    
            });
            
            $('body').on('click', 'input:checkbox[name="product_list"]', function (event) {

               if ($('input:checkbox[name="product_list"]').length == $('input:checkbox[name="product_list"]:checked').length) {
                    $("#all_product").prop("checked", true);
                } else {
                    $("#all_product").prop('checked',false);
                }
    
            });
            
            
            /* ------  Product Model Ends ------ */
            
            
            /* ------  Add the new pixel ------ */
            
            
            $('body').on('click', '#pixel-add-btn', function (event) {
            
                event.preventDefault();
                
                var pixel_title = $("#pixel_title").val();
                var pixel_id = $("#pixel_id").val();
                var api_status = 0;
                var access_token = '';
                
                if($('#event-api').prop('checked') == true)
                {
                    api_status = 1;
                    access_token = $("#access-token").val();
                    
                }
                
                setTimeout(function(){
              
                $.ajax({

                    // headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
    
                    url: "{{ url('insert-pixel') }}",
                    type: "GET",
                    data: {
                        pixel_title:pixel_title ,
                        pixel_id:pixel_id,
                        event_api_status:api_status,
                        tiktok_access_token:access_token
                    },
    
                    dataType: 'json',
                    success: function (data) {
                       
                        $("#pixel_title").val('');
    
                        $("#pixel_id").val('');
                        
                        $('#event-api').prop('checked',false)
                        
                        $("#access-token").val('');
                        
                        $('.pixel-success-message').show();
                        
                         $("html, body").animate({ scrollTop: 0 }, "slow");
                        
                        $('#pixelsModal').hide();
    
                        var oTable = $('#pixel-table').dataTable();
                        oTable.fnDraw(false);
                        
                        setTimeout(function(){
                            
                            $('.pixel-success-message').hide();
                            
                        },5000);
                    
                    }
                });
                
                },500);
            });
            
            
            /* ------  Pixel manage button ------ */
            
            
            $('body').on('click', '#managePixel', function (event) {
            
                event.preventDefault();
                
               
                var pid = $(this).attr('data-id');
              
                $.ajax({

                    url: "{{ url('event-list') }}",
                    type: "GET",
                    data: {
                        
                        pixel_id:pid
                        
                    },
    
                    dataType: 'json',
                    success: function (data) {
                       
                        $("#3a").html(data.view);
                        
                        //$("#three-tab").trigger('click');
                        
                        $('.pixel-management-content').html(data.view);
                        
                        $('#pixelManagementModal').show();
                    
                    }
                });
            });
            
            
            /* ------  Back button in pixel management popup ------ */
            
            
            $('body').on('click', '#event-back', function (event) {
            
                $('#pixelManagementModal').hide();
                
            });
            
            
            /* ------  Event On/Off button in pixel management popup ------ */
            
            
            $('body').on('click', '.event-btn', function (event) {
                
                var data_id = $(this).attr('data-id');
                
                var pid = $(this).attr('pixel-id'); 
                
                var tracking_type = $("input[name='tracking_type']:checked").val();
                
                if($(this).prop('checked')== true)
                {
                    
                    var status = 1;
                }
                else
                {
                    
                    var status = 0;
                }
                
                
                var url = 'edit-event/'+data_id;
                
                 $.ajax({

                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    
                    url: url,
                    type: "GET",
                    data: {
                        status : status,
                        tracking_type: tracking_type
                    },
    
                    dataType: 'json',
                    success: function (data) {
                        
                        $.ajax({
        
                            url: "{{ url('event-list') }}",
                            type: "GET",
                            data: {
                                
                                pixel_id:pid
                                
                            },
            
                            dataType: 'json',
                            success: function (data) {
                                
                                //$("#3a").html(data.view);
                                
                                //$("#three-tab").trigger('click');
                                
                                $('.pixel-management-content').html(data.view);
                        
                                $('#pixelManagementModal').show();
                            
                            }
                            
                        });
                        
                    }
                });
                
                
                $.ajax({

                    url: "{{ url('insert-content-view') }}",
                    type: "GET",
                    data: {
                        
                        pixel_id:pid,
                        tracking_type: tracking_type
                        
                    },
    
                    dataType: 'json',
                    success: function (data) {
                       
                      
                    }
                });
                
                
            });
            
            
           /* ------  Tracking type option in pixel management popup ------ */
            
            
            $('body').on('click', 'input[name="tracking_type"]', function (event) {
            
                var soption =  $("input[name='tracking_type']:checked").val();
                
                if(soption == 'selected_page')
                {
                    
                    $('.product-container').show();
                }
                else
                {
                    $('.product-container').hide();
                    
                }
                
            });
            
            
             /* ------  Add button in pixel management popup ------ */
            
            $('body').on('click', '.product-sub-btn', function (event) {
                
                var collections = [];
                var types = [];
                var tags = [];
                var products = [];
                var pixel_id = $(this).attr('data-pixel-id');
                
                $('#selected-list li').each(function(){
                    
                    var data_type = $(this).attr('data-type');
                    var data_value = $(this).attr('data-value');
                            
                    if(data_type == 'collection')
                    {
                        collections.push(data_value);
                    }
                    else if (data_type == 'type')
                    {
                        types.push(data_value);
                    }
                    else if (data_type == 'tag')
                    {
                        tags.push(data_value);
                    }
                    else if (data_type == 'product')
                    {
                        products.push(data_value);
                    }
                    
                });
                
                var collections_array = collections.join(",");
                
                var types_array = types.join(",");
                
                var tags_array = tags.join(",");
                
                var products_array = products.join(",");
                
                $.ajax({

                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    
                    url: "{{ url('insert-product') }}",
                    type: "GET",
                    data: {
                        
                        collections:collections_array,
                        types:types_array,
                        tags:tags_array,
                        products:products_array,
                        pixel_id:pixel_id
                    },
                    dataType: 'json',
                    success: function (data) {
                        
                        $('#success-message').show();
                        $('#success-message').text(data.message);
                      
                    }
                });
                
                
            
            });
            
            
            /* ------ Serach field in collection popup ------ */
            
            $('body').on('keyup', '#collection-filter', function (event) {
                
                var fcval = $(this).val();
                
                $('#collection-table tbody tr').hide();
                
                $('#collection-table tbody .title').each(function(){
                    
                    var ttext = $(this).text()
                    
                    
                    if (ttext.indexOf(fcval) > -1) {
                        
                        $(this).parent('tr').show();
                    }
                    
                    
                });
            
            });
            
            /* ------ Serach field in type popup ------ */
            
            $('body').on('keyup', '#type-filter', function (event) {
                
                var ftyval = $(this).val();
                
                $('#product-type-table tbody tr').hide();
                
                $('#product-type-table tbody .title').each(function(){
                    
                    var ttext = $(this).text()
                    
                    
                    if (ttext.indexOf(ftyval) > -1) {
                        
                        $(this).parent('tr').show();
                    }
                    
                    
                });
            
            });
            
             /* ------ Serach field in tag popup ------ */
            
            $('body').on('keyup', '#tag-filter', function (event) {
                
                var ftgval = $(this).val();
                
                $('#product-tag-table tbody tr').hide();
                
                $('#product-tag-table tbody .title').each(function(){
                    
                    var ttext = $(this).text()
                    
                    
                    if (ttext.indexOf(ftgval) > -1) {
                        
                        $(this).parent('tr').show();
                    }
                    
                    
                });
            
            });
            
            
             /* ------ Serach field in product popup ------ */
            
            
            $('body').on('keyup', '#product-filter', function (event) {
                
                var fpval = $(this).val();
                
                $('#product-table tbody tr').hide();
                
                $('#product-table tbody .title').each(function(){
                    
                    var ttext = $(this).text()
                    
                    
                    if (ttext.indexOf(fpval) > -1) {
                        
                        $(this).parent('tr').show();
                    }
                    
                    
                });
            
            });
            
            
            /* ------  Remove button in pixel management popup ------ */
            
            
           $('body').on('click', '.pixel-del-btn', function (event) {
               
               
                var data_id = $(this).attr('data-id');
                
                var data_pixel_id = $(this).attr('data-pixel-id');
                
                var tracking_type = $("input[name='tracking_type']:checked").val();
                
                $.ajax({
                    
                    url: "remove-pixel",
                    type: "GET",
                    data: {
                        
                        pixel_id:data_id
                    },
                    dataType: 'json',
                    success: function (data) {
                        
                        $('#pixelManagementModal').hide();
                        
                    }
                });
                
                $.ajax({

                    url: "{{ url('insert-content-view') }}",
                    type: "GET",
                    data: {
                        
                        pixel_id:data_pixel_id,
                        tracking_type: tracking_type
                    },
    
                    dataType: 'json',
                    success: function (data) {
                      
                    }
                });
                
                $.ajax({
                    
                    url: "remove-pixels",
                    type: "GET",
                    data: {
                        
                        pixel_id:data_id
                    },
                    dataType: 'json',
                    success: function (data) {
                        
                        var oTable = $('#pixel-table').dataTable();
                        oTable.fnDraw(false);
                        
                    }
                });
               
               
           });
           
           
        });
        
        
        /* ------  Display pixel table in pixel management tab ------ */
        
        
        function get_pixel_list()
        {

            var shop_id = $('.shop-id').text();
            
            $('#pixel-table').DataTable({
                
                processing: true,
                serverSide: true,
                ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('pixel-list') }}",
                type: 'GET',
                data:{id:shop_id}
                },
                columns: [
                {data: 'id', name: 'id', 'visible': false},
                {data: 'shop_id', name: 'shop id', 'visible': false},
                { data: 'pixel_id', name: 'pixel id' },
                { data: 'pixel_title', name: 'pixel title' },
                {data: 'action', name: 'action', orderable: false},
                ],
                order: [[0, 'desc']]
                
            });
        }
        
        function addAsset() {	
			$.ajax({	
				type: 'GET',			
				url: "{{url('addasset')}}",		
				success: function(response){			
					//console.log(response);
				}
			});
		}
        
    </script>
@endsection