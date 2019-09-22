<?php

namespace App\Modules\ModuleExemple\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function exemple()
    {   
        // Storage::makeDirectory('criado_pela_api');
        // Storage::put('/criado_pela_api/xml.txt', 'Contents');
        return ["msg" => "2000"];
    }
}
