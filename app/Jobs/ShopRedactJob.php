<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use stdClass;
use App\User;
use App\PixelDetail;
use App\PixelEvent;
use App\PixelProduct;
use Log;
use File;

class ShopRedactJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Shop's myshopify domain
     *
     * @var ShopDomain|string
     */
    public $shopDomain;

    /**
     * The webhook data
     *
     * @var object
     */
    public $data;

    /**
     * Create a new job instance.
     *
     * @param string   $shopDomain The shop's myshopify domain.
     * @param stdClass $data       The webhook data (JSON decoded).
     *
     * @return void
     */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Convert domain
        $this->shopDomain = ShopDomain::fromNative($this->shopDomain);
        $this->app_uninstalled_job($this->shopDomain->toNative() );

        // Do what you wish with the data
        // Access domain name as $this->shopDomain->toNative()
    }
    
    public function app_uninstalled_job($shop) {

        try {

            $shop = User::where('name',$shop)->first();
            info($shop);
            
            PixelDetail::where('shop_id',$shop->id)->delete();
            PixelEvent::where('shop_id',$shop->id)->delete();
            PixelProduct::where('shop_id',$shop->id)->delete();
            
            $shop->delete();
            
            
            $dir = base_path().'/pull/'.$shop->name;
            
            $this->rrmdir($dir);
              
        }
        
        catch(\Exception $e) {
            
            Log::error($e->getMessage());
            
        }

    }
    
    public function rrmdir($dir)
    {
        if (is_dir($dir))
        {
             $objects = scandir($dir);
            
             foreach ($objects as $object)
             {
                   if ($object != '.' && $object != '..')
                   {
                        if (filetype($dir.'/'.$object) == 'dir') {rrmdir($dir.'/'.$object);}
                        else {unlink($dir.'/'.$object);}
                   }
             }
            
             reset($objects);
             
             rmdir($dir);
         }
    }
}
