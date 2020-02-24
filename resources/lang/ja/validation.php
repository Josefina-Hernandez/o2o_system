<?php

return [

    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行はバリデタークラスにより使用されるデフォルトのエラー
    | メッセージです。サイズルールのようにいくつかのバリデーションを
    | 持っているものもあります。メッセージはご自由に調整してください。
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'active_url'           => ':attributeが有効なURLではありません。',
    'after'                => ':attributeには、:dateより後の日付を入力してください。',
    'after_or_equal'       => ':attributeには、:date以前の日付を入力してください。',
    'alpha'                => ':attributeはアルファベットのみがご利用できます。',
    'alpha_dash'           => ':attributeはアルファベットとダッシュ(-)及び下線(_)がご利用できます。',
    'alpha_num'            => ':attributeはアルファベット数字がご利用できます。',
    'array'                => ':attributeは配列でなくてはなりません。',
    'before'               => ':attributeには、:dateより前の日付をご利用ください。',
    'before_or_equal'      => ':attributeには、:date以前の日付をご利用ください。',
    'between'              => [
        'numeric' => ':attributeは、:minから:maxの間で入力してください。',
        'file'    => ':attributeは、:min kBから、:max kBの間で入力してください。',
        'string'  => ':attributeは、:min文字から、:max文字の間で入力してください。',
        'array'   => ':attributeは、:min個から:max個の間で入力してください。',
    ],
    'boolean'              => ':attributeは、trueかfalseを入力してください。',
    'confirmed'            => ':attributeと、確認フィールドとが、一致していません。',
    'date'                 => ':attributeには有効な日付を入力してください。',
    'date_format'          => ':attributeは:format形式で入力してください。',
    'different'            => ':attributeと:otherには、異なった内容を入力してください。',
    'digits'               => ':attributeは:digits桁で入力してください。',
    'digits_between'       => ':attributeは:min桁から:max桁の間で入力してください。',
    'dimensions'           => ':attributeの図形サイズが正しくありません。',
    'distinct'             => ':attributeには異なった値を入力してください。',
    'email'                => ':attributeには、有効なメールアドレスを入力してください。',
    'exists'               => '選択された:attributeは正しくありません。',
    'file'                 => ':attributeにはファイルを入力してください。',
    'filled'               => ':attributeに値を入力してください。',
    'image'                => ':attributeには画像ファイルを入力してください。',
    'in'                   => '選択された:attributeは正しくありません。',
    'in_array'             => ':attributeには:otherの値を入力してください。',
    'integer'              => ':attributeは整数で入力してください。',
    'ip'                   => ':attributeには、有効なIPアドレスを入力してください。',
    'ipv4'                 => ':attributeには、有効なIPv4アドレスを入力してください。',
    'ipv6'                 => ':attributeには、有効なIPv6アドレスを入力してください。',
    'json'                 => ':attributeには、有効なJSON文字列を入力してください。',
    'max'                  => [
        'numeric' => ':attributeには、:max以下の数字を入力してください。',
        'file'    => ':attributeには、:max kB以下のファイルを入力してください。',
        'string'  => ':attributeは、:max文字以下で入力してください。',
        'array'   => ':attributeは:max個以下入力してください。',
    ],
    'mimes'                => ':attributeには:valuesタイプのファイルを入力してください。',
    'mimetypes'            => ':attributeには:valuesタイプのファイルを入力してください。',
    'min'                  => [
        'numeric' => ':attributeには、:min以上の数字を入力してください。',
        'file'    => ':attributeには、:min kB以上のファイルを入力してください。',
        'string'  => ':attributeは、:min文字以上で入力してください。',
        'array'   => ':attributeは:min個以上入力してください。',
    ],
    'not_in'               => '選択された:attributeは正しくありません。',
    'numeric'              => ':attributeには、数字を入力してください。',
    'present'              => ':attributeが存在していません。',
    'regex'                => ':attributeに正しい形式を入力してください。',
    'required'             => ':attributeは必ず入力してください。',
    'required_if'          => ':otherが:valueの場合、:attributeも入力してください。',
    'required_unless'      => ':otherが:valuesでない場合、:attributeを入力してください。',
    'required_with'        => ':valuesを入力する場合は、:attributeも入力してください。',
    'required_with_all'    => ':valuesを入力する場合は、:attributeも入力してください。',
    'required_without'     => ':valuesを入力しない場合は、:attributeを入力してください。',
    'required_without_all' => ':valuesのどれも入力しない場合は、:attributeを入力してください。',
    'same'                 => ':attributeと:otherには同じ値を入力してください。',
    'size'                 => [
        'numeric' => ':attributeは:sizeを入力してください。',
        'file'    => ':attributeのファイルは、:sizeキロバイトでなくてはなりません。',
        'string'  => ':attributeは:size文字で入力してください。',
        'array'   => ':attributeは:size個入力してください。',
    ],
    'string'               => ':attributeは文字列を入力してください。',
    'timezone'             => ':attributeには、有効なゾーンを入力してください。',
    'unique'               => ':attributeの値は既に存在しています。',
    'uploaded'             => ':attributeのアップロードに失敗しました。',
    'url'                  => ':attributeに正しい形式を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    | 以下は各configで各テーブルのカラム毎に日本語で定義したものである。
    | 各ＤＢのカラム名フィールドは他のテーブルでも同名で定義されているため、重複している文言についてはコメントで
    |「重複あり」と記載する。
    | 各ページで単語の定義を変更したい場合はRequestのattributesで再定義して上書き定義をすること
    */

    'attributes' => [
        // ユーザーテーブル
        config('const.db.users.ID')             => "システムID",        // 重複あり
        config('const.db.users.PASSWORD')       => "パスワード",        // 重複あり
        config('const.db.users.CREATED_AT')     => "登録日時",          // 重複あり
        config('const.db.users.UPDATED_AT')     => "更新日時",          // 重複あり
        config('const.db.users.SHOP_ID')        => "ショップID",        // 重複あり
        config('const.db.users.SHOP_CLASS_ID')  => "システム区分ID",    // 重複あり
        config('const.db.users.LOGIN_ID')       => "ログインID",        // 重複あり
        config('const.db.users.DELETED_AT')     => "削除日時",          // 重複あり

        // ショップ区分テーブル
        // config('const.db.shop_classes.NAME')    => "区分名",            // 重複あり

        // ショップテーブル
        config('const.db.shops.NAME')                           => "店名",
        config('const.db.shops.COMPANY_NAME')                   => "法人名",
        config('const.db.shops.COMPANY_NAME_KANA')              => "法人名（カナ）",
        config('const.db.shops.KANA')                           => "店名（カナ）",
        config('const.db.shops.PRESIDENT_NAME')                 => "代表者名",
        config('const.db.shops.PERSONNEL_NAME')                 => "担当者名",
        config('const.db.shops.ZIP1')                           => "郵便番号　上3桁",
        config('const.db.shops.ZIP2')                           => "郵便番号　下4桁",
        config('const.db.shops.PREF_ID')                        => "都道府県ID",
        config('const.db.shops.CITY_ID')                        => "市区町村ID",
        config('const.db.shops.STREET')                         => "町名・番地",
        config('const.db.shops.BUILDING')                       => "ビル名",
        config('const.db.shops.LATITUDE')                       => "緯度",
        config('const.db.shops.LONGITUDE')                      => "経度",
        config('const.db.shops.SUPPORT_AREA')                   => "対応エリア",
        config('const.db.shops.TEL')                            => "電話番号",
        config('const.db.shops.FAX')                            => "FAX番号",
        config('const.db.shops.EMAIL')                          => "メールアドレス",
        config('const.db.shops.OPEN_TIME')                      => "営業開始時間",
        config('const.db.shops.CLOSE_TIME')                     => "営業終了時間",
        config('const.db.shops.OTHER_TIME')                     => "営業時間追記",
        config('const.db.shops.NORMALLY_CLOSE_DAY')             => "定休日",
        config('const.db.shops.SUPPORT_DETAIL')                 => "取扱施工内容",
        config('const.db.shops.CERTIFICATE')                    => "資格",                                  // 重複あり
        config('const.db.shops.SITE_URL')                       => "サイトURL",
        config('const.db.shops.CAPITAL')                        => "資本金",
        config('const.db.shops.COMPANY_START')                  => "創業・起業",
        config('const.db.shops.COMPANY_HISTORY')                => "沿革",
        config('const.db.shops.LICENSE')                        => "許可登録番号",
        config('const.db.shops.EMPLOYEE_NUMBER')                => "社員数",
        config('const.db.shops.MESSAGE')                        => "メッセージ",                            // 重複あり
        config('const.db.shops.HAS_T_POINT')                    => "Tポイント提携フラグ",
        config('const.db.shops.IS_NO_RATE')                     => "無金利フラグ",
        config('const.db.shops.CAN_PAY_BY_CREDIT_CARD')         => "クレジットカード決済フラグ",
        config('const.db.shops.IS_MADO_MEISTER')                => "窓マイスターフラグ",
        config('const.db.shops.TWITTER')                        => "Twitterアカウント",
        config('const.db.shops.FACEBOOK')                       => "Facebookアカウント",
        config('const.db.shops.SHOP_CODE')                      => "ショップコード",
        config('const.db.shops.PREMIUM_SHOP_DOMAIN')            => "プレミアムショップドメイン",
        config('const.db.shops.CAN_SIMULATE')                   => "見積りシステム利用フラグ",
        config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS')   => "スタンダードショップ公開ステータス",
        config('const.db.shops.IS_PUBLISHED_PREMIUM')           => "プレミアムショップ公開フラグ",

        // スタンダードショップ施工事例テーブル
        config('const.db.standard_photos.TITLE')                => "タイトル",                              // 重複あり
        config('const.db.standard_photos.SUMMARY')              => "概要",                                  // 重複あり
        config('const.db.standard_photos.MAIN_TEXT')            => "本文",
        config('const.db.standard_photos.BEFORE_TEXT')          => "施工前テキスト",
        config('const.db.standard_photos.AFTER_TEXT')           => "施工後テキスト",
        config('const.db.standard_photos.IS_CUSTOMER_PUBLISH')  => "お客様の声掲載フラグ",                   // 重複あり
        config('const.db.standard_photos.CUSTOMER_TEXT')        => "お客様の声テキスト",
        // config('const.db.standard_photos.CATEGORY')             => "建物種別",                              // Requestで対応
        config('const.db.standard_photos.PARTS')                => "リフォーム箇所",
        config('const.db.standard_photos.LOCALE')               => "地域",
        config('const.db.standard_photos.BUDGET')               => "予算",
        config('const.db.standard_photos.PERIOD')               => "工期",
        config('const.db.standard_photos.PRODUCT')              => "採用商品",
        config('const.db.standard_photos.BUILT_YEAR')           => "住宅の築年数",
        config('const.db.standard_photos.REASON')               => "リフォーム理由",
        config('const.db.standard_photos.CATEGORY_FOR_SEARCH')  => "カテゴリー",
        config('const.db.standard_photos.CLIENT_AGE')           => "お施主のご年齢",
        config('const.db.standard_photos.HOUSEHOLD')            => "世帯",
        config('const.db.standard_photos.CHILD')                => "お子さま",
        config('const.db.standard_photos.PET')                  => "ペット",

        // プレミアムショップ施工事例テーブル
        config('const.db.premium_photos.WP_ARTICLE_ID')         => "記事ID",
        config('const.db.premium_photos.WP_ARTICLE_URL')        => "記事URL",
        config('const.db.premium_photos.POSTED_AT')             => "公開日時",
        config('const.db.premium_photos.FEATURED_IMAGE_URL')    => "アイキャッチ画像URL",

        // スタッフテーブル
        config('const.db.staffs.RANK')                          => "並び順",
        config('const.db.staffs.POST')                          => "役職",
        config('const.db.staffs.HOBBY')                         => "趣味",
        // config('const.db.staffs.MESSAGE')                       => "メッセージ",                            // Requestで対応

        // スタンダードショップお知らせテーブル
        config('const.db.standard_notices.PUBLISHED_AT')        => "公開日",
        // config('const.db.standard_notices.TEXT')                => "内容",                                 // Requestで対応

        // 緊急メッセージテーブル
        config('const.db.emergency_messages.IS_PUBLISH')        => "掲載フラグ",
        // config( 'const.db.emergency_messages.TEXT')             => "メッセージ内容",                        // Requestで対応

        // 都道府県テーブル
        // config('const.db.prefs.CODE')                           => "都道府県コード",                       // Requestで対応

        // 市区町村テーブル
        // config('const.db.cities.CODE')                          => "市区町村コード",                       // Requestで対応
        // config('const.db.cities.NAME')                          => "市区町村名",                           // Requestで対応
    ],

];
