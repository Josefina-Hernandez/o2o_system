
<html>
<head>
<title>
@if('admin.lixil.shop.geocode' === \Route::currentRouteName())
    @section('title', '会員登録緯度経度確認')
@elseif('admin.lixil.shop.edit.geocode' === \Route::currentRouteName())
    @section('title', '会員編集緯度経度確認')
@endif

@if('admin.lixil.shop.geocode' === \Route::currentRouteName())
    会員登録緯度経度確認
@elseif('admin.lixil.shop.edit.geocode' === \Route::currentRouteName())
    会員編集緯度経度確認
@endif
</title>
<style>
* {
  margin: 0;
  font-family: "游ゴシック", YuGothic, "ヒラギノ角ゴ Pro", "Hiragino Kaku Gothic Pro", "メイリオ", "Meiryo", sans-serif;
}
.closeBtn {
  margin: 0px 5px 0 0;
  padding: 5px 20px;
  color: #fff;
  background-color: #ed6c00;
  float: right;
}
.closeBtn a {
  color: #fff;
  text-decoration: none;
}
p.text {
  font-size: 1.2em;
  font-weight: bold;
  text-align: left;
  margin: 7px 20px 0px;
}
p.small {
  font-size: 0.8em;
  margin: 0px 20px;
}
.label {
  margin: 30px 10px 10px 20px;
  float: left;
  line-height: 40px;
}
input.pref {
  margin: 30px 10px 10px 10px;
  float: left;
  width: 380px;
  padding: 4px;
  height: 40px;
  font-size: 14px;
  line-height: 20px;
}
input.btn {
  padding: 5px 20px;
  font-size: 14px;
  text-align: center;
  margin: 0 auto;
}
table {
  width: 450px;
  margin: 20px 0 0 20px;
}
</style>
</head>

<body>
<span class="closeBtn"><a href="#" onClick="window.close(); return false;">閉じる</a></span>
<p class="text">緯度経度変換</p>
<p class="small">APIのリクエストは1日上限1000リクエストとなります。</p>
{{ Form::open(['method' => 'get',"route"=>"admin.lixil.shop.geocode"]) }}
  <div class="label">住所</div>
  {{ Form::text("address","",["class"=>"pref"]) }}</input>
  <div align="center">
    {{ Form::button("変換",["type"=>"submit","class"=>"btn"]) }}</input>
  </div>
{{ Form::close() }}
@if($address != "")
  <table align="center">
    <tr><td width="60" valign="top">住所</td><td>{{ $address }}</td></tr>
    <tr><td width="60" valign="top">緯度</td><td>{{ $lat }}</td></tr>
    <tr><td width="60" valign="top">経度</td><td>{{ $lng }}</td></tr>
      <tr>
          <td>
          </td>
          <td>
          <a href="https://maps.google.co.jp/maps?q={{ $lat }},{{ $lng }}" target="_blank">Google Mapで確認</a>
          <p class="small" style="margin-left: 0;">(別ウィンドウを開きます)</p>
          </td>

      </tr>
  </table>
@endif
</body>
</html>
