{{ $data[config('const.form.front.standard.contact.NAME1')] }} {{ $data[config('const.form.front.standard.contact.NAME2')] }} 様<br>
<br>
この度はLIXIL簡易見積りシステムへお問い合わせいただき誠にありがとうございます。<br>
以下の内容をお問い合わせ先へ送信いたしました。<br>
お問い合わせいただいた内容を確認次第、担当者からご連絡させていただきます。<br>
<br>
--------<br>
お名前：{{ $data[config('const.form.front.standard.contact.NAME1')] }}{{ $data[config('const.form.front.standard.contact.NAME2')] }}<br>
フリガナ：{{ $data[config('const.form.front.standard.contact.KANA1')] }}{{ $data[config('const.form.front.standard.contact.KANA2')] }}<br>
ご連絡方法：{{ config('const.form.front.standard.contact.CONTACT_WAY_LIST')[$data[config('const.form.front.standard.contact.CONTACT_WAY')]] }}<br>
メールアドレス：{{ $data[config('const.form.front.standard.contact.EMAIL')] }}<br>
電話番号：{{ $data[config('const.form.front.standard.contact.TEL')] }}<br>
リフォーム先の住所：{{ $data[config('const.form.front.standard.contact.ADDRESS')] }}<br>
お問い合わせ先店舗：{{ $shop->{config('const.db.shops.NAME')} }}<br>
お問い合わせ内容：{{ config('const.form.front.standard.contact.CONTACT_CATEGORY_LIST')[$data[config('const.form.front.standard.contact.CONTACT_CATEGORY')]] }}<br>
ご相談内容：{!! nl2br($data[config('const.form.front.standard.contact.CONTACT_TEXT')], false) !!}<br>
--------<br>
<br>
店舗の電話番号：{{ $shop->{config('const.db.shops.TEL')} }}<br>
店舗のメールアドレス：{{ $shop->{config('const.db.shops.EMAIL')} }}<br>
<br>
================================<br>
LIXIL簡易見積りシステム事務局<br>
<br>★このメールは送信専用メールアドレスから配信されています。