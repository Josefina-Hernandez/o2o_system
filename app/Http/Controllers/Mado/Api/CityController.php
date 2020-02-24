<?php

namespace App\Http\Controllers\Mado\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * @param Illuminate\Http\Request $request
     * @param $prefId 都道府県ID
     */
    public function getCities(Request $request, $prefId)
    {
        return app()->make('get_list')->getCityList($prefId);
    }
}
