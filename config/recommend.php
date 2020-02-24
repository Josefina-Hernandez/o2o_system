<?php
return [
    'sql' => array(
        'check_display' => "
            SELECT sm.* FROM m_shop_management sm
            INNER JOIN m_shop_category sc ON sm.m_shop_category_id = sc.m_shop_category_id
            WHERE sm.del_flg = 0 AND sc.del_flg = 0
                AND sm.handling_flg = 1 AND sc.m_product_id = 9 -- product curtain
                AND sc.shop_id = :shop_id 
                AND sm.setting_type IS NULL
        "
    ),
    'status' => [
        'display' => "ON",
        'not_display' => "OFF"
    ],
    'recommend_curtain' => ['9'],
    'recommend_html' => [
        'head_title' => '結露等で汚れたカーテンも <br> 一緒に取り替えませんか？',
        'body_title' => '■オーダーカーテン 参考金額（製品代のみ）',
        'body_title_recommends' => '■オーダーカーテン 参考金額（セット）',
        'product_name' => "ブランシェⅡ",
        'double_door ' => 'ブランシェⅡ',
        'product_name_screen_cart' => "ブランシェⅡ（スタンダード仕様 ドレープA+レースC 1.5倍ヒダ）",
        'drape_price' => 'Ａ',
        'race_price' => 'C',
        'fold_magnification' => '1.5倍'

    ]
];