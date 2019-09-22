<?php

namespace App\Modules\DanfeExpo\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
// use App\Http\Interfaces\DanfeStorageInterface;
// use App\Http\Validators\XmlValidator;

class DanfeController extends BaseController
{	
    // public function uploadXml(Request $request, DanfeStorageInterface $repository, XmlValidator $validator)
    // {
    // 	$file = $request->all();
		// $validator->validate($file);
		// dd($repository->xml($file));
    // }

    public function danfe()
    {
      return ["msg" => "DanfeExpo 200"];
    }
}

