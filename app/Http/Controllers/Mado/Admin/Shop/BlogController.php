<?php

namespace App\Http\Controllers\Mado\Admin\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Admin\Shop\BlogRequest;

class BlogController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        return view('mado.admin.shop.blog.index');
    }

    public function new()
    {
        return view('mado.admin.shop.blog.edit');
    }

    public function confirm(BlogRequest $request)
    {
        return view('mado.admin.shop.blog.confirm');
    }

    public function complete(BlogRequest $request)
    {
        return redirect()->route('admin.shop.blog');
    }

    public function edit()
    {
        return view('mado.admin.shop.blog.edit');
    }

    public function editConfirm(BlogRequest $request)
    {
        return view('mado.admin.shop.blog.confirm');
    }

    public function editComplete(BlogRequest $request)
    {
        return redirect()->route('admin.shop.blog');
    }

    public function delete(BlogRequest $request)
    {
        return redirect()->route('admin.shop.blog');
    }

}
