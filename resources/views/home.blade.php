<div class="home-page-main">
    
    <h4 class="pixel-success-message" style="display:none">Pixel added successfully!</h4>
    
    
    <div class="bottom-section">
            
            <div class="find-pixel-text">How to find Your Tiktok Pixel ID</div>
            
            <video width="100%" controls>
              <source src="{{ url('/images/pixel_install_1920.mp4')}}" type="video/mp4">
            </video>
             <div class="bottom-section-content">
            <div class="enable-app-text">How to Enable/Disable the app embed blocks from the store</div>
            <div class="embed-block-section1">
            <h3>Purpose of App Embed Blocks</h3>
            
            <p>App embed blocks are used in this app to activate the pixel tracking on your store.Pixel tracking did not work while you enable the app embed block from the theme editor.
            </p>
            </div>
              <div class="embed-block-section2">
            <h3>Enable/Disable App Embed Blocks</h3>
            
            <p>App embedd blocks are Enable/Disable from theme editor under App embeds page.First time you installed the app embed blocks disable by default you need to enable it to activate the pixel tracking code on the shopify store.Kindly check the below screenshot to Enable/Disable the embed blocks.
            </p>
            </div>
            </div>
            
            <img class="enable-app-image" src = "{{ asset('/images/enable-app.png') }}" />
            
            <div class="pixelAddButton pixel-btn">+ Add Pixels</div>
           
            <div class="pixel-working-outer">
                
                <a class="pixel-working" href="https://chrome.google.com/webstore/detail/tiktok-pixel-helper/aelgobmabdmlfmiblddjfnjodalhidnn?hl=en" target="_blank">How to check if your TikTok pixels are working properly?</a>
                
            </div>
            
    </div>

</div>


<div id="pixelsModal" class="pixels-modal">

    <!-- Modal content -->
    <div class="pixels-modal-content">
        <span class="pixels-close">&times;</span>
        
        <div class="top-section">
            
            <h2>Add a New Pixel</h2>
            
            <div class="pixel-section">
                
                <form id="pixel_form">
            
                    @csrf
                    
                    <div class="form-group">
                        <div class="row">
                            <h3>Pixel Title:</h3>
                            <div class="col-sm-12">
                                <input type="text" name="pixel_title" class="form-control" id="pixel_title" value="">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <h3>Pixel ID</h3>
                            <div class="col-sm-12">
                                <input type="text" name="pixel_id" class="form-control" id="pixel_id" value="">
                            </div>
                        </div>
                    </div>
                    
                     
                    <div class="submit-form">
                            
                            <button type="submit" id="pixel-add-btn" class="btn btn-primary mt-4">+ Add</button>
                    </div>
            
                </form>
                
            </div>
            
            <!--<div class="server-api-section">-->
                
            <!--    <form id="event-api-form">-->
                    
                    <!--<div class="api-note">Note: Enter a Developer Mode Pixel if-->
                    <!--you want to enable server-side tracking (IOS 14 Solution) </div>-->
                    
            <!--        <div class="api-outer">-->
                        
            <!--            <input type="checkbox" id="event-api" name="event-api" value="">-->
            <!--            <label for="event-api"> Enable Events API </label>-->
                        
            <!--        </div>-->
                    
            <!--        <div class="app-id">Events API access is required for analytic tracking.</div>-->
                    
            <!--        <div class="access-token-text">Fill TikTok access token</div>-->
            <!--        <div class="pwd-outer">-->
                        
            <!--            <input type="password" value="FakePSW" id="access-token">-->
                    <!--<div class="pwd-inner">-->
                    <!--    <input type="checkbox" id="show-pwd"><label>Show Password</label>-->
                    <!--    </div>-->
                           
                        
            <!--        </div>-->
                    
                   
            <!--    </form>-->
                
            <!--    <div class="api-video">-->
                    
                    
            <!--        <img class="api-image" src = "{{ asset('/images/video-placeholder.png') }}" />-->
                    
                    <!--<iframe width="853" height="480" src="https://www.youtube.com/embed/pICCkyNaIJU" title="How to install TikTok Ads pixel(s) & back it up with event API (the fast and right way for Shopify)" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
            <!--    </div>-->
                
            <!--</div>-->
            
        </div>
        
    </div>
    
</div>

<!--<style>-->
    
<!--  .bottom-section {-->
<!--    text-align: center;-->
<!--}-->
<!--.bottom-section iframe {-->
<!--    border: 0;-->
<!--    width: 100% !important;-->
<!--    max-width: 500px !important;-->
<!--    margin: 0 auto !important;-->
<!--}-->
<!--</style>-->

<style>.embedtool {position: relative;height: 0;padding-top: 56%;overflow: hidden;max-width: 100%;} .embedtool iframe, .embedtool object, .embedtool embed { position: absolute; top: 50%; left: 50%; transform:translate(-50%,-50%); width: 90%; height: 90%;text-align:center; } .embedtool .fluid-vids {position: initial !important}</style>