<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $main_lang;

    function __construct()
    {
        $this->main_lang = Lang::where('is_main', 1)
            ->firstOrFail();
    }

    function dwn()
    {
    	return $this->download($_GET["url"], $_GET["quality"], $_GET["option"]);
    }

    function download($url, $quality, $option) {
	    $api = "https://x.wwi.su/x/download/";
	    $curl = curl_init();
	    curl_setopt_array($curl, [
	        CURLOPT_URL => $api."?option=download&url=".$url,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_USERAGENT => "PHPiB",
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => "GET",
	    ]);
	    $response = curl_exec($curl);
	    curl_close($curl);
	    return $response;
	}
}
