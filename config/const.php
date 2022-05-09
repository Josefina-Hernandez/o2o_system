<?php

return [
    // データベースに関する項目
    'db' => [
        // ユーザー情報テーブル
        'users' => [
            'ID'            => 'id',
            'PASSWORD'      => 'password',
            'CREATED_AT'    => 'created_at',
            'UPDATED_AT'    => 'updated_at',
            'SHOP_ID'       => 'shop_id',
            'SHOP_CLASS_ID' => 'shop_class_id',
            'LOGIN_ID'      => 'login_id',
            'DELETED_AT' => 'deleted_at',
            'NAME' => 'name',
            'EMAIL' => 'email',
            'PHONENUMBER' => 'phonenumber',
            'COMPANY' => 'company',
            'STATUS' =>'status',
            'ADMIN' => 'admin',
            'UPDATED_USER' => 'update_user',
            'CREATE_USER' => 'create_user',
            'DEL_FLG' => 'del_flg',
            'EMAIL_VERIFIED_AT' => 'email_verified_at',
            'DEPARTMENT_CODE' => 'department_code',
			'M_MAILADDRESS_ID'=>'m_mailaddress_id',
        ],

        // ショップ情報テーブル
        'shops' => [
            'ID' => 'id',
            'SHOP_CLASS_ID' => 'shop_class_id',
            'NAME' => 'name',
            'DELETED_AT' => 'deleted_at',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
            'COMPANY_NAME' => 'company_name',
            'COMPANY_NAME_KANA' => 'company_name_kana',
            'KANA' => 'kana',
            'PRESIDENT_NAME' => 'president_name',
            'PERSONNEL_NAME' => 'personnel_name',
            'ZIP1' => 'zip1',
            'ZIP2' => 'zip2',
            'PREF_ID' => 'pref_id',
            'CITY_ID' => 'city_id',
            'STREET' => 'street',
            'BUILDING' => 'building',
            'LATITUDE' => 'latitude',
            'LONGITUDE' => 'longitude',
            'SUPPORT_AREA' => 'support_area',
            'TEL' => 'tel',
            'FAX' => 'fax',
            'EMAIL' => 'email',
            'OPEN_TIME' => 'open_time',
            'CLOSE_TIME' => 'close_time',
            'OTHER_TIME' => 'other_time',
            'NORMALLY_CLOSE_DAY' => 'normally_close_day',
            'SUPPORT_DETAIL' => 'support_detail',
            'SUPPORT_DETAIL_LIST' => 'support_detail_list',
            'CERTIFICATE' => 'certificate',
            'SITE_URL' => 'site_url',
            'CAPITAL' => 'capital',
            'COMPANY_START' => 'company_start',
            'COMPANY_HISTORY' => 'company_history',
            'LICENSE' => 'license',
            'EMPLOYEE_NUMBER' => 'employee_number',
            'MESSAGE' => 'message',
            'PHOTO_SUMMARY' => 'photo_summary',
            'HAS_T_POINT' => 'has_t_point',
            'IS_NO_RATE' => 'is_no_rate',
            'CAN_PAY_BY_CREDIT_CARD' => 'can_pay_by_credit_card',
            'IS_MADO_MEISTER' => 'is_mado_meister',
            'TWITTER' => 'twitter',
            'FACEBOOK' => 'facebook',
            'SHOP_CODE' => 'shop_code',
            'PREMIUM_SHOP_DOMAIN' => 'premium_shop_domain',
            'CAN_SIMULATE' => 'can_simulate',
            'STANDARD_SHOP_PUBLISH_STATUS' => 'standard_shop_publish_status',
            'IS_PUBLISHED_PREMIUM' => 'is_published_premium',
            'SHOP_TYPE' => 'shop_type'
        ],

        // ショップ区分テーブル
        'shop_classes' => [
            'ID' => 'id',
            'NAME' => 'name',
            'DELETED_AT' => 'deleted_at',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
        ],

        // スタンダードショップ施工事例テーブル
        'standard_photos' => [
            'ID' => 'id',
            'SHOP_ID' => 'shop_id',
            'TITLE' => 'title',
            'SUMMARY' => 'summary',
            'MAIN_TEXT' => 'main_text',
            'BEFORE_TEXT' => 'before_text',
            'AFTER_TEXT' => 'after_text',
            'IS_CUSTOMER_PUBLISH' => 'is_customer_publish',
            'CUSTOMER_TEXT' => 'customer_text',
            'CUSTOMER_TEXT_2' => 'customer_text_2',
            'CATEGORY' => 'category',
            'BUILT_YEAR' => 'built_year',
            'CATEGORY_FOR_SEARCH' => 'category_for_search',
            'PARTS' => 'parts',
            'REASON' => 'reason',
            'LOCALE' => 'locale',
            'BUDGET' => 'budget',
            'PERIOD' => 'period',
            'PRODUCT' => 'product',
            'CLIENT_AGE' => 'client_age',
            'HOUSEHOLD' => 'household',
            'CHILD' => 'child',
            'PET' => 'pet',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
            'DELETED_AT' => 'deleted_at',
        ],

        // プレミアムショップ施工事例テーブル
        'premium_photos' => [
            'ID' => 'id',
            'SHOP_ID' => 'shop_id',
            'WP_ARTICLE_ID' => 'wp_article_id',
            'WP_ARTICLE_URL' => 'wp_article_url',
            'POSTED_AT' => 'posted_at',
            'TITLE' => 'title',
            'SUMMARY' => 'summary',
            'IS_CUSTOMER_PUBLISH' => 'is_customer_publish',
            'FEATURED_IMAGE_URL' => 'featured_image_url',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
            'DELETED_AT' => 'deleted_at',
        ],

        // スタンダードショップ記事テーブル
        'standard_articles' => [
            'ID' => 'id',
            'SHOP_ID' => 'shop_id',
            'CATEGORY' => 'category',
            'PUBLISHED_AT' => 'published_at',
            'TITLE' => 'title',
            'SUMMARY' => 'summary',
            'TEXT' => 'text',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
            'DELETED_AT' => 'deleted_at',
        ],

        // プレミアムショップ記事テーブル
        'premium_articles' => [
            'ID' => 'id',
            'SHOP_ID' => 'shop_id',
            'WP_ARTICLE_ID' => 'wp_article_id',
            'WP_ARTICLE_URL' => 'wp_article_url',
            'POSTED_AT' => 'posted_at',
            'CATEGORY' => 'category',
            'TITLE' => 'title',
            'SUMMARY' => 'summary',
            'FEATURED_IMAGE_URL' => 'featured_image_url',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
            'DELETED_AT' => 'deleted_at',
        ],

        // スタッフテーブル
        'staffs' => [
            'ID' => 'id',
            'SHOP_ID' => 'shop_id',
            'RANK' => 'rank',
            'POST' => 'post',
            'NAME' => 'name',
            'MESSAGE' => 'message',
            'CERTIFICATE' => 'certificate',
            'HOBBY' => 'hobby',
            'CASE' => 'case',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
            'DELETED_AT' => 'deleted_at',
        ],

        // スタンダードショップお知らせテーブル
        'standard_notices' => [
            'ID' => 'id',
            'SHOP_ID' => 'shop_id',
            'PUBLISHED_AT' => 'published_at',
            'TEXT' => 'text',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
            'DELETED_AT' => 'deleted_at',
        ],

        // 緊急メッセージテーブル
        'emergency_messages' => [
            'ID' => 'id',
            'SHOP_ID' => 'shop_id',
            'IS_PUBLISH' => 'is_publish',
            'TEXT' => 'text',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
            'DELETED_AT' => 'deleted_at',
        ],

        // 都道府県テーブル
        'prefs' => [
            'ID' => 'id',
            'CODE' => 'code',
            'NAME' => 'name',
            'DELETED_AT' => 'deleted_at',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
        ],

        // 市区町村テーブル
        'cities' => [
            'ID' => 'id',
            'PREF_ID' => 'pref_id',
            'CODE' => 'code',
            'NAME' => 'name',
            'DELETED_AT' => 'deleted_at',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
        ],

        // バナーテーブル
        'banners' => [
            'ID' => 'id',
            'SHOP_ID' => 'shop_id',
            'RANK' => 'rank',
            'URL' => 'url',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
            'DELETED_AT' => 'deleted_at',
        ],

        't_generate_shop_history' => [
            'ID' => 't_generate_shop_history_id',
            'CUSTOMER_NAME' => 'customer_name',
            'CUSTOMER_EMAIL' => 'customer_email',
            'REPRESENT' => 'represent',
            'EMAIL_SALES' => 'email_sales',
            'LOGIN_INFO_MAIL_CONTENT' => 'login_info_mail_content',
            'FRONTEND_URL_PUBLISH' => 'frontend_url_publish',
            'FRONTEND_URL_MAIL_CONTENT' => 'frontend_url_mail_content',
            'SHOP_ID' => 'shop_id',
            'CREATED_AT' => 'created_at',
            'UPDATED_AT' => 'updated_at',
        ]
    ],

    // フォームに関する項目
    'form' => [
        // フロント画面に関する項目
        'front' => [
            // LIXIL問い合わせ画面に関する項目
            'contact' => [
                'NAME1' => 'name1',
                'NAME2' => 'name2',
                'KANA1' => 'kana1',
                'KANA2' => 'kana2',
                'CONTACT_WAY' => 'contact_way',
                'EMAIL' => 'email',
                'TEL' => 'tel',
                'ADDRESS' => 'address',
                'CONTACT_CATEGORY' => 'contact_category',
                'CONTACT_TEXT' => 'contact_text',
                'CONTACT_PRIVACY' => 'contact_privacy',

                // ご連絡方法
                'CONTACT_WAY_LIST' => [
                    1 => 'メール',
                    2 => '電話',
                    3 => 'どちらでも可'
                ],
                
                // お問い合わせ内容
                'CONTACT_CATEGORY_LIST' => [
                    1 => 'お見積り',
                    2 => '出張見積り・ご相談',
                    3 => 'その他のお問い合わせ'
                ],
            ],

            // 加盟店詳細画面に関する項目
            'standard' => [
                // 加盟店問い合わせ画面に関する項目
                'contact' => [
                    'NAME1' => 'name1',
                    'NAME2' => 'name2',
                    'KANA1' => 'kana1',
                    'KANA2' => 'kana2',
                    'CONTACT_WAY' => 'contact_way',
                    'EMAIL' => 'email',
                    'TEL' => 'tel',
                    'ADDRESS' => 'address',
                    'CONTACT_CATEGORY' => 'contact_category',
                    'CONTACT_TEXT' => 'contact_text',
                    'CONTACT_PRIVACY' => 'contact_privacy',
    
                    // ご連絡方法
                    'CONTACT_WAY_LIST' => [
                        1 => 'メール',
                        2 => '電話',
                        3 => 'どちらでも可'
                    ],
                    
                    // お問い合わせ内容
                    'CONTACT_CATEGORY_LIST' => [
                        1 => 'お見積り',
                        2 => '出張見積り・ご相談',
                        3 => 'その他のお問い合わせ'
                    ],
                ],
            ],
        ],

        // 管理画面に関する項目
        'admin' => [
            // LIXIL管理画面に関する項目
            'lixil' => [
                // ログインフォームに関する項目
                'login' => [
                    'LOGIN_ID' => 'login_id',
                    'PASSWORD' => 'password',
                ],

                // 加盟店登録画面に関する項目
                'shop' => [
                    // メイン写真
                    'MAIN_PICTURE' => 'main_picture',

                    // プラン
                    'PLAN' => [
                        2 => 'プレミアム',
                        3 => 'スタンダード',
                    ],

                    // スタンダードショップ公開ステータス
                    'STANDARD_PUBLISH_STATUS' => [
                        1 => '非公開',
                        2 => 'プレビュー',
                        3 => '公開',
                    ],

                    // プレミアムショップ公開フラグ
                    'PREMIUM_PUBLISH_FLG' => [
                        1 => '非公開',
                        3 => '公開',
                    ]
                ]
            ],

            // 加盟店管理画面に関する項目
            'shop' => [
                // ログインフォームに関する項目
                'login' => [
                    'LOGIN_ID' => 'login_id',
                    'PASSWORD' => 'password',
                ],

                // メイン写真
                'MAIN_PICTURE' => 'main_picture',

                // 取扱施工内容
                'SUPPORT_DETAIL_LIST' => [
                    1 => '窓まわり',
                    2 => '玄関まわり',
                    3 => 'エクステリア',
                    4 => 'キッチン',
                    5 => 'バスルーム',
                    6 => '洗面化粧台',
                    7 => 'トイレ',
                    8 => 'インテリア建材',
                    9 => '太陽光',
                    10 => 'メンテナンス',
                    99 => 'その他',
                ],

                // スタンダード事例登録画面に関する項目
                'standard_photo' => [
                    // タイトル: 最大文字数
                    'TITLE_MAX_LENGTH' => 50,

                    // 概要: 最大文字数
                    'SUMMARY_MAX_LENGTH' => 255,

                    // メイン画像
                    'MAIN_PICTURE' => 'main_picture',

                    // 施工前写真
                    'BEFORE_PICTURE' => 'before_picture',
                    'BEFORE_PICTURE_2' => 'before_picture_2',
                    'BEFORE_PICTURE_3' => 'before_picture_3',
                    
                    // 施工後写真
                    'AFTER_PICTURE' => 'after_picture',
                    'AFTER_PICTURE_2' => 'after_picture_2',
                    'AFTER_PICTURE_3' => 'after_picture_3',

                    // 写真1
                    'CUSTOMER_PICTURE' => 'customer_picture',
                    
                    // 写真2
                    'CUSTOMER_PICTURE_2' => 'customer_picture_2',

                    // 建物種別
                    'CATEGORY' => [
                        2 => '戸建て',
                        1 => 'マンション',
                        3 => '店舗',
                        5 => 'オフィス',
                        4 => 'その他',
                    ],

                    // 住宅の築年数
                    'BUILT_YEAR' => [
                        1 => '5年以下',
                        2 => '6年～10年',
                        3 => '11年～15年',
                        4 => '16年～20年',
                        5 => '21年～25年',
                        6 => '26年～30年',
                        7 => '31年～35年',
                        8 => '36年～40年',
                        9 => '41年以上',
                    ],

                    // リフォーム箇所
                    'PARTS' => [
                        1 => '窓',
                        2 => '玄関ドア',
                        6 => '玄関引戸',
                        7 => '勝手口ドア',
                        8 => '雨戸',
                        9 => 'シャッター',
                        10 => '日よけ',
                        3 => 'エクステリア',
                        4 => 'インテリア',
                        5 => 'その他',
                    ],

                    // リフォーム理由
                    'REASON' => [
                        1 => '紫外線対策',
                        2 => '結露',
                        3 => '防音',
                        4 => '防犯',
                        5 => '省エネ',
                        6 => 'バリアフリー',
                        7 => '採光',
                        8 => '彩風',
                        9 => '快適',
                        10 => 'デザイン',
                    ],

                    // カテゴリー
                    'CATEGORY_FOR_SEARCH' => [
                        1 => 'リビング',
                        2 => '寝室',
                        3 => '子供部屋',
                        4 => '和室',
                        5 => 'キッチン',
                        6 => 'トイレ',
                        7 => '洗面',
                        8 => '浴室',
                        9 => '玄関',
                        10 => 'ガーデン',
                        11 => 'ファサード',
                        12 => 'カースペース',
                        99 => 'その他'
                    ],

                    // お施主のご年齢
                    'CLIENT_AGE' => [
                        1 => '20歳代',
                        2 => '30歳代',
                        3 => '40歳代',
                        4 => '50歳代',
                        5 => '60歳代',
                        6 => '70歳代以上',
                        99 => 'なし',
                    ],

                    // 世帯
                    'HOUSEHOLD' => [
                        1 => 'ご夫婦',
                        2 => '二世帯',
                        3 => '三世帯',
                        99 => 'なし',
                    ],

                    // お子さま
                    'CHILD' => [
                        1 => '1名',
                        2 => '2名',
                        3 => '3名',
                        4 => '4名',
                        5 => '5名以上',
                        99 => 'なし',
                    ],

                    // ペット
                    'PET' => [
                        1 => 'ワンちゃん',
                        2 => '猫ちゃん',
                        99 => 'その他',
                    ],
                ],

                // スタッフ登録画面に関する項目
                'staff' => [
                    // 写真
                    'PICTURE' => 'picture',
                ],

                // バナー登録画面に関する項目
                'banner' => [
                    // 写真
                    'PICTURE' => 'picture',
                ],

                // スタンダード現場ブログ・イベントキャンペーン登録画面に関する項目
                'standard_article' => [
                    // カテゴリ
                    'CATEGORY' => [
                        1 => '現場ブログ',
                        2 => 'イベントキャンペーン',
                    ],

                    // メイン写真
                    'MAIN_PICTURE' => 'main_picture',
                ],
            ],
        ],

        // 全画面共通の項目
        'common' => [
            'ENABLE_FLG' => [
                1 => '有効',
                0 => '無効'
            ],

            // チェックボックスが有効になっている時にvalueとする値
            'CHECKED' => 'on',
            
            // 検索キーワード
            'SEARCH_KEYWORDS' => 'search_keywords',
            
            // プレミアム区分
            'PREMIUM' => 'premium',

            // スタンダード区分
            'STANDARD' => 'standard',

            // 見積もりシミュレーション
            'SIMULATE' => 'simulate',

            // お客様の声
            'VOICE' => 'voice',

            // 取扱施工内容
            'DETAIL' => 'detail',
        ]
    ],

    // コマンド
    'command' => [
        'exit_code' => [
            'SUCCESS' => 0,
            'ERROR' => 1,
        ],
    ],

    // 日本地図
    'japan_map' => [
        'hokkaido' => [
            'hokkaido' => [
                'NAME' => '北海道',
                'rect' => [
                    'X' => 675,
                    'Y' => null,
                    'WIDTH' => 143,
                    'HEIGHT' => 131
                ],
                'text' => [
                    'X' => 746.721,
                    'Y' => 71.504
                ],
            ],
        ],
        'tohoku' => [
            'yamagata' => [
                'NAME' => '山形',
                'rect' => [
                    'X' => 676,
                    'Y' => 240,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 705.721,
                    'Y' => 266.504
                ],
            ],
            'akita' => [
                'NAME' => '秋田',
                'rect' => [
                    'X' => 676,
                    'Y' => 195,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 705.721,
                    'Y' => 222.509
                ],
                
            ],
            'fukushima' => [
                'NAME' => '福島',
                'rect' => [
                    'X' => 676,
                    'Y' => 285,
                    'WIDTH' => 118,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 734.72,
                    'Y' => 312.509
                ],
            ],
            'miyagi' => [
                'NAME' => '宮城',
                'rect' => [
                    'X' => 736,
                    'Y' => 240,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 765.72,
                    'Y' => 266.504
                ],
            ],
            'iwate' => [
                'NAME' => '岩手',
                'rect' => [
                    'X' => 736,
                    'Y' => 195,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 765.72,
                    'Y' => 222.509
                ],
            ],
            'aomori' => [
                'NAME' => '青森',
                'rect' => [
                    'X' => 676,
                    'Y' => 150,
                    'WIDTH' => 118,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 734.72,
                    'Y' => 177.509
                ],
            ],
        ],
        'kanto' => [
            'kanagawa' => [
                'NAME' => '神奈川',
                'rect' => [
                    'X' => 676,
                    'Y' => 465,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 705.721,
                    'Y' => 491.505
                ],
            ],
            'tokyo' => [
                'NAME' => '東京',
                'rect' => [
                    'X' => 676,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 705.721,
                    'Y' => 447.51
                ],
            ],
            'saitama' => [
                'NAME' => '埼玉',
                'rect' => [
                    'X' => 676,
                    'Y' => 375,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 705.721,
                    'Y' => 401.504
                ],
            ],
            'gumma' => [
                'NAME' => '群馬',
                'rect' => [
                    'X' => 676,
                    'Y' => 330,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 705.721,
                    'Y' => 357.509
                ],
            ],
            'tochigi' => [
                'NAME' => '栃木',
                'rect' => [
                    'X' => 736,
                    'Y' => 330,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 765.72,
                    'Y' => 357.509
                ],
            ],
            'ibaraki' => [
                'NAME' => '茨城',
                'rect' => [
                    'X' => 736,
                    'Y' => 375,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 765.72,
                    'Y' => 401.504
                ],
            ],
            'chiba' => [
                'NAME' => '千葉',
                'rect' => [
                    'X' => 736,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 88
                ],
                'text' => [
                    'X' => 765.72,
                    'Y' => 468.505
                ],
            ],
        ],
        'chubu' => [
            'fukui' => [
                'NAME' => '福井',
                'rect' => [
                    'X' => 496,
                    'Y' => 330,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 525.721,
                    'Y' => 357.509
                ],
            ],
            'ishikawa' => [
                'NAME' => '石川',
                'rect' => [
                    'X' => 496,
                    'Y' => 285,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 525.721,
                    'Y' => 312.509
                ],
            ],
            'aichi' => [
                'NAME' => '愛知',
                'rect' => [
                    'X' => 556,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 585.72,
                    'Y' => 447.51
                ],
            ],
            'gifu' => [
                'NAME' => '岐阜',
                'rect' => [
                    'X' => 556,
                    'Y' => 330,
                    'WIDTH' => 58,
                    'HEIGHT' => 88
                ],
                'text' => [
                    'X' => 585.72,
                    'Y' => 379.503
                ],
            ],
            'toyama' => [
                'NAME' => '富山',
                'rect' => [
                    'X' => 556,
                    'Y' => 285,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 585.72,
                    'Y' => 312.509
                ],
            ],
            'shizuoka' => [
                'NAME' => '静岡',
                'rect' => [
                    'X' => 616,
                    'Y' => 465,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 645.721,
                    'Y' => 492.51
                ],
            ],
            'yamanashi' => [
                'NAME' => '山梨',
                'rect' => [
                    'X' => 616,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 645.721,
                    'Y' => 447.51
                ],
            ],
            'nagano' => [
                'NAME' => '長野',
                'rect' => [
                    'X' => 616,
                    'Y' => 330,
                    'WIDTH' => 58,
                    'HEIGHT' => 88
                ],
                'text' => [
                    'X' => 645.721,
                    'Y' => 379.503
                ],
            ],
            'niigata' => [
                'NAME' => '新潟',
                'rect' => [
                    'X' => 616,
                    'Y' => 285,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 645.721,
                    'Y' => 312.509
                ],
            ],
        ],
        'kinki' => [
            'osaka' => [
                'NAME' => '大阪',
                'rect' => [
                    'X' => 376,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 405.72,
                    'Y' => 447.51
                ],
            ],
            'hyogo' => [
                'NAME' => '兵庫',
                'rect' => [
                    'X' => 376,
                    'Y' => 375,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 405.72,
                    'Y' => 402.51
                ],
            ],
            'wakayama' => [
                'NAME' => '和歌山',
                'rect' => [
                    'X' => 376,
                    'Y' => 465,
                    'WIDTH' => 118,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 435.721,
                    'Y' => 492.51
                ],
            ],
            'nara' => [
                'NAME' => '奈良',
                'rect' => [
                    'X' => 436,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 465.721,
                    'Y' => 447.51
                ],
            ],
            'kyoto' => [
                'NAME' => '京都',
                'rect' => [
                    'X' => 436,
                    'Y' => 375,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 465.721,
                    'Y' => 402.51
                ],
            ],
            'mie' => [
                'NAME' => '三重',
                'rect' => [
                    'X' => 496,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 525.721,
                    'Y' => 447.51
                ],
            ],
            'shiga' => [
                'NAME' => '滋賀',
                'rect' => [
                    'X' => 496,
                    'Y' => 375,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 525.721,
                    'Y' => 402.51
                ],
            ],
        ],
        'chugoku' => [
            'yamaguchi' => [
                'NAME' => '山口',
                'rect' => [
                    'X' => 196,
                    'Y' => 375,
                    'WIDTH' => 58,
                    'HEIGHT' => 88
                ],
                'text' => [
                    'X' => 225.72,
                    'Y' => 425.509
                ],
            ],
            'hiroshima' => [
                'NAME' => '広島',
                'rect' => [
                    'X' => 256,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 285.721,
                    'Y' => 447.51
                ],
            ],
            'shimane' => [
                'NAME' => '島根',
                'rect' => [
                    'X' => 256,
                    'Y' => 375,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 285.721,
                    'Y' => 402.51
                ],
            ],
            'okayama' => [
                'NAME' => '岡山',
                'rect' => [
                    'X' => 316,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 345.721,
                    'Y' => 447.51
                ],
            ],
            'tottori' => [
                'NAME' => '鳥取',
                'rect' => [
                    'X' => 316,
                    'Y' => 375,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 345.721,
                    'Y' => 402.51
                ],
            ],
        ],
        'shikoku' => [
            'kochi' => [
                'NAME' => '高知',
                'rect' => [
                    'X' => 242,
                    'Y' => 525,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 271.721,
                    'Y' => 552.51
                ],
            ],
            'ehime' => [
                'NAME' => '愛媛',
                'rect' => [
                    'X' => 242,
                    'Y' => 480,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 271.721,
                    'Y' => 507.51
                ],
            ],
            'tokushima' => [
                'NAME' => '徳島',
                'rect' => [
                    'X' => 302,
                    'Y' => 525,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 331.72,
                    'Y' => 552.51
                ],
            ],
            'kagawa' => [
                'NAME' => '香川',
                'rect' => [
                    'X' => 302,
                    'Y' => 480,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 331.72,
                    'Y' => 507.51
                ],
            ],
        ],
        'kyushu' => [
            'okinawa' => [
                'NAME' => '沖縄',
                'rect' => [
                    'X' => null,
                    'Y' => 532,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 29.721,
                    'Y' => 560.509
                ],
            ],
            'nagasaki' => [
                'NAME' => '長崎',
                'rect' => [
                    'X' => null,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 29.721,
                    'Y' => 447.51
                ],
            ],
            'saga' => [
                'NAME' => '佐賀',
                'rect' => [
                    'X' => null,
                    'Y' => 375,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 29.721,
                    'Y' => 402.51
                ],
            ],
            'kagoshima' => [
                'NAME' => '鹿児島',
                'rect' => [
                    'X' => null,
                    'Y' => 465,
                    'WIDTH' => 118,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 59.72,
                    'Y' => 492.51
                ],
            ],
            'kumamoto' => [
                'NAME' => '熊本',
                'rect' => [
                    'X' => 60,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 89.721,
                    'Y' => 447.51
                ],
            ],
            'fukuoka' => [
                'NAME' => '福岡',
                'rect' => [
                    'X' => 60,
                    'Y' => 375,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 89.721,
                    'Y' => 402.51
                ],
            ],
            'miyazaki' => [
                'NAME' => '宮崎',
                'rect' => [
                    'X' => 120,
                    'Y' => 420,
                    'WIDTH' => 58,
                    'HEIGHT' => 88
                ],
                'text' => [
                    'X' => 149.72,
                    'Y' => 468.505
                ],
            ],
            'oita' => [
                'NAME' => '大分',
                'rect' => [
                    'X' => 120,
                    'Y' => 375,
                    'WIDTH' => 58,
                    'HEIGHT' => 43
                ],
                'text' => [
                    'X' => 149.72,
                    'Y' => 402.51
                ],
            ],
        ],
    ],

    // google mapsに利用する各都道府県の中央座標
    'pref_positions' => [
        'hokkaido' => [
            'lat' => 43.50868,
            'lng' => 142.568674,
            'zoom' => 7,
        ],
        'yamagata' => [
            'lat' => 38.503126,
            'lng' => 140.237249,
            'zoom' => 9,
        ],
        'akita' => [
            'lat' => 39.868446,
            'lng' => 140.291915,
            'zoom' => 9,
        ],
        'fukushima' => [
            'lat' => 37.408562,
            'lng' => 140.401604,
            'zoom' => 9,
        ],
        'miyagi' => [
            'lat' => 38.443269,
            'lng' => 141.097302,
            'zoom' => 9,
        ],
        'iwate' => [
            'lat' => 39.59998,
            'lng' => 141.745971,
            'zoom' => 8,
        ],
        'aomori' => [
            'lat' => 40.803304,
            'lng' => 140.969938,
            'zoom' => 9,
        ],
        'kanagawa' => [
            'lat' => 35.410568,
            'lng' => 139.369115,
            'zoom' => 10,
        ],
        'tokyo' => [
            'lat' => 35.720977,
            'lng' => 139.446599,
            'zoom' => 10,
        ],
        'saitama' => [
            'lat' => 35.990875,
            'lng' => 139.245129,
            'zoom' => 10,
        ],
        'gumma' => [
            'lat' => 36.532071,
            'lng' => 139.011013,
            'zoom' => 9,
        ],
        'tochigi' => [
            'lat' => 36.708825,
            'lng' => 139.944891,
            'zoom' => 9,
        ],
        'ibaraki' => [
            'lat' => 36.39045,
            'lng' => 140.614344,
            'zoom' => 9,
        ],
        'chiba' => [
            'lat' => 35.45305,
            'lng' => 140.323825,
            'zoom' => 9,
        ],
        'fukui' => [
            'lat' => 35.876276,
            'lng' => 136.158511,
            'zoom' => 9,
        ],
        'ishikawa' => [
            'lat' => 36.735731,
            'lng' => 136.383883,
            'zoom' => 8,
        ],
        'aichi' => [
            'lat' => 35.094993,
            'lng' => 137.046708,
            'zoom' => 9,
        ],
        'gifu' => [
            'lat' => 35.746451,
            'lng' => 137.038168,
            'zoom' => 8,
        ],
        'toyama' => [
            'lat' => 36.658929,
            'lng' => 137.211342,
            'zoom' => 10,
        ],
        'shizuoka' => [
            'lat' => 35.129066,
            'lng' => 138.33912,
            'zoom' => 9,
        ],
        'yamanashi' => [
            'lat' => 35.664161,
            'lng' => 138.568459,
            'zoom' => 9,
        ],
        'nagano' => [
            'lat' => 36.227056,
            'lng' => 137.956019,
            'zoom' => 8,
        ],
        'niigata' => [
            'lat' => 37.783126,
            'lng' => 138.608491,
            'zoom' => 8,
        ],
        'osaka' => [
            'lat' => 34.689862,
            'lng' => 135.534403,
            'zoom' => 9,
        ],
        'hyogo' => [
            'lat' => 35.040586,
            'lng' => 134.944108,
            'zoom' => 8,
        ],
        'wakayama' => [
            'lat' => 33.939417,
            'lng' => 135.450115,
            'zoom' => 9,
        ],
        'nara' => [
            'lat' => 34.395736,
            'lng' => 135.98656,
            'zoom' => 9,
        ],
        'kyoto' => [
            'lat' => 35.280772,
            'lng' => 135.498634,
            'zoom' => 9,
        ],
        'mie' => [
            'lat' => 34.42045,
            'lng' => 136.571769,
            'zoom' => 8,
        ],
        'shiga' => [
            'lat' => 35.24041,
            'lng' => 136.272355,
            'zoom' => 9,
        ],
        'yamaguchi' => [
            'lat' => 34.18613,
            'lng' => 131.470497,
            'zoom' => 9,
        ],
        'hiroshima' => [
            'lat' => 34.607106,
            'lng' => 132.7178,
            'zoom' => 9,
        ],
        'shimane' => [
            'lat' => 34.850348,
            'lng' => 132.542402,
            'zoom' => 8,
        ],
        'okayama' => [
            'lat' => 34.90989,
            'lng' => 133.860241,
            'zoom' => 9,
        ],
        'tottori' => [
            'lat' => 35.338002,
            'lng' => 133.844027,
            'zoom' => 10,
        ],
        'kochi' => [
            'lat' => 33.319047,
            'lng' => 133.462431,
            'zoom' => 9,
        ],
        'ehime' => [
            'lat' => 33.613239,
            'lng' => 132.897207,
            'zoom' => 8,
        ],
        'tokushima' => [
            'lat' => 33.853893,
            'lng' => 134.296998,
            'zoom' => 9,
        ],
        'kagawa' => [
            'lat' => 34.299214,
            'lng' => 134.021396,
            'zoom' => 10,
        ],
        'okinawa' => [
            'lat' => 27.252754,
            'lng' => 128.303335,
            'zoom' => 8,
        ],
        'nagasaki' => [
            'lat' => 32.975526,
            'lng' => 129.54411,
            'zoom' => 9,
        ],
        'saga' => [
            'lat' => 33.259906,
            'lng' => 130.100677,
            'zoom' => 10,
        ],
        'kagoshima' => [
            'lat' => 31.304721,
            'lng' => 130.744762,
            'zoom' => 8,
        ],
        'kumamoto' => [
            'lat' => 33.206038,
            'lng' => 131.511001,
            'zoom' => 9,
        ],
        'fukuoka' => [
            'lat' => 33.53126,
            'lng' => 130.591342,
            'zoom' => 9,
        ],
        'miyazaki' => [
            'lat' => 32.139671,
            'lng' => 131.361185,
            'zoom' => 8,
        ],
        'oita' => [
            'lat' => 33.238205,
            'lng' => 131.612625,
            'zoom' => 9,
        ],
    ],

    // 一般的な項目
    'common' => [
        // 有効無効
        'ENABLE' => 1,
        'DISABLE' => 0,

        // ショップに関する項目
        'shops' => [
            // ショップ区分
            // shop_classesのidは下記各区分のvalueに等しい
            'classes' => [
                'LIXIL' => 1,
                'PREMIUM' => 2,
                'STANDARD' => 3,
                'EMPLOYEE' => 4,
            ],

            'classes_name' => [
                1 => 'LIXIL',
                2 => 'プレミアム',
                3 => 'スタンダード',
                4 => 'Employee',
            ],

            // スタンダードショップ公開ステータス
            'standard_publish_status' => [
                'PRIVATE' => 1,
                'PREVIEW' => 2,
                'PUBLIC' => 3,
            ],
            
            // プレミアムショップ公開ステータス
            'premium_publish_status' => [
                'PRIVATE' => 1,
                'PUBLIC' => 3,
            ],

            // 窓マイスターアイコン表示
            'MADO_MEISTER_FLG' => [
                1 => '窓マイスターアイコンを表示する',
                0 => '窓マイスターアイコン非表示',
            ],

            // 見積りシミュレーション
            'SIMULATE_USABLE_FLG' => [
                1 => '利用する',
                0 => '見積りシミュレーションは利用しない',
            ],
        ],

        // ユーザーに関する項目
        'users' => [
            // パスワードに用いる文字
            // 半角大文字, 半角小文字, 半角数字のみで構成し、
            // 紛らわしい文字（Oo0 lI1 S5 b6）を除いている。
            'PASSWORD_CHARACTERS' => '234789acdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXYZ',

            // パスワードの長さ
            'PASSWORD_LENGTH' => 8,
        ],

        // 記事に関する項目
        'articles' => [
            'category' => [
                'BLOG' => 1,
                'EVENT' => 2,
            ],
        ],

        // 画像に関する項目
        'image' => [
            // ファイルサイズ: 単位KB
            'FILE_SIZE' => 10000,
            
            // 画像のjpg変換後の品質
            'ENCODE_QUALITY' => 70,
            
            // 長辺の最大長（単位px）と、画像サイズ名の組み合わせを保持する
            // サイズ名はファイル名に使用される。半角英数字推奨
            'MAX_LENGTHS' => [
                'l' => 1200,
                's' => 550,
            ],
        ],

        // 画面上部に表示させるメッセージに関する項目
        'notice_message' => [
            'MESSAGE' => 'message',
            'STATUS' => 'status',
            'status' => [
                'GRAY' => 'gray',
                'ORANGE' => 'orange',
            ],
        ],

        // APIキー
        'api_key' => [
            'GOOGLE_MAP' => env('GOOGLE_MAP_API_KEY', ''),
        ],

        // オートロードページのconfigパス
        'PAGE_CONFIG_PATH' => 
        "views" . DIRECTORY_SEPARATOR . 
        "mado" . DIRECTORY_SEPARATOR . 
        "page" . DIRECTORY_SEPARATOR . 
        "config" . DIRECTORY_SEPARATOR . 
        "page_config.ini",
    ],

    // Add Start BP_O2OQ-4 hainp 20200608
    'front' => [
        'cart' => [
            'PRODUCT_ID_GIESTA' => 5
        ],
    ]
    // End Start BP_O2OQ-4 hainp 20200608
];
