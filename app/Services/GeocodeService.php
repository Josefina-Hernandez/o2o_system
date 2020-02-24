<?php

namespace App\Services;
class GeocodeService{

    //テスト用googleジオコードキー
    private $geocode_key;

    //GoogleジオコードURL
    private $googleGeoCodeUrl="https://maps.googleapis.com/maps/api/geocode/json?key=";

    private $url="";

    /**
     * コンストラクタ
     */
	public function __construct(){
        // configからgooglemap APIキーを取得する
        $this->geocode_key = config('const.common.api_key.GOOGLE_MAP');

        //URLの生成
        $this->url=$this->googleGeoCodeUrl . $this->geocode_key;
	}

    /**
     * @param 住所
     * @return 緯度経度をJSON形式で返却
     */
	public function convertAddressToLatLng($address){
	    $json = json_decode(@file_get_contents($this->url . "&address=" . $address),true);
	    return $json;
	}
}