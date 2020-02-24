<?php

namespace App\Services;

/**
 * ページオートロードに関するサービス
 */
class PageAutoLoadService
{
    //INIファイルの保管場所
    private $inifile="";

    //タイトル
    private $title="";

    //ディスクリプション
    private $description="";

    //ブレードパス
    private $blade_path="";

    //CSSファイル名
    private $css_name="";

    //インクルードするサイドナビ名
    private $side_navi_path="";

    //URLにてアクセスしてきた際に404へ返す第一階層の文字
    private $not_access_page=["config","side_navi","notify"];


    public function __construct()
    {
        if(!file_exists(resource_path(config('const.common.PAGE_CONFIG_PATH')))){
            abort(403,resource_path(config('const.common.PAGE_CONFIG_PATH')) . "にファイルが存在しません。シンボリックリンクにて対応してください。不明な場合は管理者に御問合せください。");
        }
        $this->inifile = parse_ini_file(resource_path(config('const.common.PAGE_CONFIG_PATH')),true);
    }

    public function getOneDepthPath($end_name)
    {
        //禁止ＵＲＬにアクセスしていないかチェック
        $this->notAllowAccess($end_name);

        //タイトルタグの設置
        if(isset($this->inifile["title"][$end_name])){
            $this->title = $this->inifile["title"][$end_name];
        }

        //ディスクリプションタグの設置
        if(isset($this->inifile["description"][$end_name])){
            $this->description = $this->inifile["description"][$end_name];
        }

        //読み込むブレードの指定
        $this->blade_path = 'mado.page.' . $end_name;

        //読み込むＣＳＳの指定
        $this->css_name = $end_name . ".css";
        
        //読み込むサイドナビの指定
        $this->side_navi_path = 'mado.page.side_navi.' . $end_name;

        return 
        [
            "title" => $this->title,
            "description" => $this->description,
            "blade_path" => $this->blade_path,
            "css_name" => $this->css_name,
            "side_navi_path" => $this->side_navi_path,
        ];
    }

    public function getTwoDepthPath($path1,$end_name)
    {
        //禁止ＵＲＬにアクセスしていないかチェック
        $this->notAllowAccess($path1);

        //タイトルタグの設置
        if(isset($this->inifile["title"][$path1 . "." . $end_name])){
            $this->title = $this->inifile["title"][$path1 . "." . $end_name];
        }

        //ディスクリプションタグの設置
        if(isset($this->inifile["description"][$path1 . "." . $end_name])){
            $this->description = $this->inifile["description"][$path1 . "." . $end_name];
        }

        //読み込むブレードの指定
        $this->blade_path = 'mado.page.' . $path1 . "." . $end_name;

        //読み込むＣＳＳの指定
        $this->css_name = $path1 . ".css";
        
        //読み込むサイドナビの指定
        $this->side_navi_path = 'mado.page.side_navi.' . $path1;

        return 
        [
            "title" => $this->title,
            "description" => $this->description,
            "blade_path" => $this->blade_path,
            "css_name" => $this->css_name,
            "side_navi_path" => $this->side_navi_path,
        ];
    }

    /**
     * 禁止ＵＲＬにアクセスしていないかチェック
     */
    private function notAllowAccess($first_path){
        if(in_array($first_path,$this->not_access_page)){
            abort(404);
        }
    }


}