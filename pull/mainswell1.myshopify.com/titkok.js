var dg$; 
        var script = document.createElement('script');
        script.setAttribute('src', '//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js');
        script.addEventListener('load', function() {
        dg$ = $.noConflict(true);
        mainScript(dg$);});
        document.head.appendChild(script) 
        function mainScript($) { 
            
                        var showPixel = '';
                        
                        tiktokPixel = 'CHILG4BC77U26MR7OMS0';
                        
                        showPixel += "ttq.load('"+tiktokPixel+"');";
                        
                        var tiktokTrackCode = "!function (w, d, t) { w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=['page','track','identify','instances','debug','on','off','once','ready','alias','group','enableCookie','disableCookie'],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i='https://analytics.tiktok.com/i18n/pixel/events.js';ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement('script');o.type='text/javascript',o.async=!0,o.src=i+'?sdkid='+e+'&lib='+t;var a=document.getElementsByTagName('script')[0];a.parentNode.insertBefore(o,a)};}(window, document, 'ttq');"; 
                        
                       
                            $('head').append("<script>"+tiktokTrackCode+""+showPixel+";ttq.page();</script>");
                    
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
                                
                                $(document).on('click','button[name="add"]',function(){
                                    data = $(this).parents('form').serializeArray();
                                    var quantity = '';
                                    var vid = '';
                                    var vname='';
                                    var shop_name = 'mainswell1.myshopify.com';
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
                                            
                                            ttq.instance('CHILG4BC77U26MR7OMS0').track('AddToCart', {content_id: product.id, content_type:'product_group', value:price, content_name:product.title,currency:currency});
                                    
                                        }
                                    
                                    });
                            
                                }); 
                            } 
                                                   
                        }); 
                    
                    
                    
                    $(document).on('click','input[name="checkout"]',function(){
                        
                           ttq.instance('CHILG4BC77U26MR7OMS0').track('InitiateCheckout');
                        });
                    
                    
                    
                    $(document).on('click','button[name="checkout"]',function(){
                        
                        ttq.instance('CHILG4BC77U26MR7OMS0').track('InitiateCheckout');
                    });
                    
                    
                    
                    $(document).on('submit','form.search',function(){
                        
                            var search_query = $('input[name="q"]').val();
                            var search_query_length = $('input[name="q"]').val().length;
                        
                            ttq.instance('CHILG4BC77U26MR7OMS0').track('Search', {
                            
                               content_id:search_query_length,
                               query:search_query
                               
                            });
                            
                        });
                    
                     
        }