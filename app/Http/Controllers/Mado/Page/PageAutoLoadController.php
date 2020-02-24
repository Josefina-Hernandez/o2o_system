<?php

namespace App\Http\Controllers\Mado\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 固定ページをオートロードする仕組み
 * resource/mado/page/配下に存在するbladeを自動でURLを生成し、表示する仕組み
 */
class PageAutoLoadController extends Controller
{
    //スタティックオートロード1階層
    public function one_depth(Request $request){

        $paths = app()->make('page_auto_load')->getOneDepthPath($request->end_name);

        if(\View::exists($paths["blade_path"])){
        
            return view("mado.front.page.page_autoload",
            [
                "title"=>$paths["title"],
                "description"=>$paths["description"],
                "blade_path"=>$paths["blade_path"],
                "css_name"=>$paths["css_name"],
                "side_navi_path"=>$paths["side_navi_path"],
            ]);
        }else{
            abort(404); 
        }
    }
    //スタティックオートロード2階層
    public function two_depth(Request $request){
        
        $paths = app()->make('page_auto_load')->getTwoDepthPath($request->path1,$request->end_name);

        if(\View::exists($paths["blade_path"])){
            return view("mado.front.page.page_autoload",
                [
                    "title"=>$paths["title"],
                    "description"=>$paths["description"],
                    "blade_path"=>$paths["blade_path"],
                    "css_name"=>$paths["css_name"],
                    "side_navi_path"=>$paths["side_navi_path"],
                ]);
        }else{
            abort(404); 
        }
    }
}
