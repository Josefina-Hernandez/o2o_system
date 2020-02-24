var map;
var marker = [];
var infoWindow = [];
var mapLatLng = { // 県庁の位置を指定
    lat: 35.6896342, // 緯度
    lng: 139.689912 // 経度
};
var markerData = [ // 店舗名・緯度・経度
    {
        name: '陸知サッシ販売 亀有店',
        url: '/shop/index.html',
        lat: 35.7572341,
        lng: 139.8428883
    }, {
        name: '陸知サッシ販売 足立店',
        url: '/shop/aaa.html',
        lat: 35.7650512,
        lng: 139.8053568
    }, {
        name: '陸知サッシ販売 文京店',
        url: '/shop/bbb.html',
        lat: 35.72186,
        lng: 139.7523443
    }, {
        name: '陸知サッシ販売 新宿店',
        url: '/shop/ccc.html',
        lat: 35.6988598,
        lng: 139.6944131
    }, {
        name: '陸知サッシ販売 平井店',
        url: '/shop/ddd.html',
        lat: 35.7024852,
        lng: 139.8408436
    }, {
        name: '陸知サッシ販売 中野店',
        url: '/shop/eee.html',
        lat: 35.7077799,
        lng: 139.6669727
    }
];

function initMap() {
    map = new google.maps.Map(document.getElementById('gmapArea'), {
        center: mapLatLng, // 地図の中心を指定
        zoom: 12, // 地図のズームを指定
        streetViewControl: false,
        mapTypeControl: false
    });

    // マーカー毎の処理
    for (var i = 0; i < markerData.length; i++) {
        markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']}); // 緯度経度のデータ作成
        marker[i] = new google.maps.Marker({ // マーカーの追加
            position: markerLatLng, // マーカーを立てる位置を指定
            map: map, // マーカーを立てる地図を指定
            icon: {
                url: '/img/marker.png' // マーカーの画像を変更
            }
        });
        
        var j = i+1;

        infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
            content: '<div class="fukidashi"><a href="' + markerData[i]['url'] + '"/>' + markerData[i]['name'] + '</a></div>' // 吹き出しに表示する内容
        });

        markerEvent(i); // マーカーにクリックイベントを追加
    }
    
    autoZoom();
}

// マーカーにクリックイベントを追加
function markerEvent(i) {
    marker[i].addListener('click', function() { // マーカーをクリックしたとき
        infoWindow[i].open(map, marker[i]); // 吹き出しの表示
    });
}

// マーカー全てが表示される縮尺/位置に調整
function autoZoom() {
	var minLat = 999;
	var maxLat = 0;
	var minLng = 999;
	var maxLng = 0;
	for (var i = 0; i < markerData.length; i++) {
		if( !markerData[i] ) return false;
 
		if(markerData[i].lat < minLat) minLat = markerData[i].lat;
		if(markerData[i].lat > maxLat) maxLat = markerData[i].lat;
		if(markerData[i].lng < minLng) minLng = markerData[i].lng;
		if(markerData[i].lng > maxLng) maxLng = markerData[i].lng;
	}
	var sw = new google.maps.LatLng(maxLat,minLng);
	var ne = new google.maps.LatLng(minLat,maxLng);
	var bounds = new google.maps.LatLngBounds(sw, ne);
	map.fitBounds(bounds);
}
