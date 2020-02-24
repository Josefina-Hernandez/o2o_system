{{ $shop->{config('const.db.shops.NAME')} }} 様<br>
<br>
LIXIL簡易見積りシステムよりお客さまからお問い合わせがありました。<br>
以下の内容を確認し、お客さまへご連絡をお願いいたします。<br>
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
================================<br>
LIXIL簡易見積りシステム事務局<br>
<br>★このメールは送信専用メールアドレスから配信されています。