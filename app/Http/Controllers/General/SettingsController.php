<?php

namespace App\Http\Controllers\General;

use App\Models\Settings;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingsResoucre;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:settings');
    }
    public function index()
    {

        $settings = Settings::first();
        if(!$settings){
            return responseApi(404, 'Not Found Settings');
        }
        return responseApi(200, 'Response data successfully', new SettingsResoucre($settings));
    }
}
