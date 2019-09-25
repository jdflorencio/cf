<?php

namespace App\Modules\DanfeExpo\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Modules\DanfeExpo\Interfaces\DanfeStorageInterface;
use App\Modules\DanfeExpo\Repositories\DanfeStorageRepository;
use App\Modules\DanfeExpo\Validators\XmlValidator;

use Illuminate\Support\Facades\Storage;


class DanfeExpoController extends BaseController
{	
    public function uploadXml(Request $request, DanfeStorageRepository $repository, XmlValidator $validator)
    {
        $file = $request->all();
        $validator->validate($file);
        $repository->xml($file);
    }

    public function danfe(Request $request, $teste, $file)
    {	
    	dd($file);
    	$dados = $request['file'];
    	return ["msg" => $dados, "outher" => $file];
    }

    public function index()
    {
        return view('welcome');
    }
}   	

