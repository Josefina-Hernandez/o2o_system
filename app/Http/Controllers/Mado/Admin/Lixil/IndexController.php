<?php

namespace App\Http\Controllers\Mado\Admin\Lixil;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view(
            'mado.admin.lixil.index',
            [
            ]
        );
    }
}
