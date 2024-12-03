<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Support\ServiceProvider;

class checkSettingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $getSettings = Settings::firstOr(function(){
            return Settings::create([
                'site_name' => 'My Site',
                'favicon' => 'defualt',
                'logo' => 'default',
                'email' => 'sendnw@gmail.com',
                'facebook' => 'https://www.facebook.com/',
                'youtube' => 'https://www.youtube.com/',
                'phone' => '01110524632',
                'country' => 'Egypt',
                'city' => 'Cairo',
                'street' => 'Ain shams',
                'small_description'=>'small description for SEO'
            ]);
        });
         // Store the whatsapp URL in a variable
    $whatsappUrl = "https://wa.me/" . $getSettings->phone;
    $getSettings->whatsapp = $whatsappUrl; // Optionally set it back to the model
        view()->share([
            'getSetting' => $getSettings,
            'whatsappUrl' => $whatsappUrl, // Share the variable if needed
        ]);
    }
}
