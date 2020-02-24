<?php

return [
        'db' =>[
                  'ctg' =>  [
                            'nametable' => 'ctg',
                            'column' => [
                                    'CTG_ID'  => 'ctg_id',
                                    'CTG_TYPE'  => 'ctg_type',
                                    'PROD_PARENT_CTG_ID'  => 'prod_parent_ctg_id',
                                    'PARENT_CTG_ID'  => 'parent_ctg_id',
                                    'SORT_ORDER'  => 'sort_order',
                                    'SLUG_NAME' => 'slug_name'
                                    
                            ]
                 ],
            
                   'ctg_trans' =>  [
                            'nametable' => 'ctg_trans',
                            'column' => [
                                    'CTG_ID'  => 'ctg_id',
                                    'M_LANG_ID'  => 'm_lang_id',
                                    'CTG_NAME'  => 'ctg_name',
                            ]
                   ],
                   
                   'm_lang' =>  [
                            'nametable' => 'm_lang',
                            'column' => [
                                    'M_LANG_ID'  => 'm_lang_id',
                                    'LANG_CODE'  => 'lang_code',
                                    'IS_DEFAULT'  => 'is_default',
                                    'SORT_ORDER'  => 'sort_order',
                            ]
                   ],
                   'm_color' =>  [
                            'nametable' => 'm_color',
                            'column' => [
                                    'M_COLOR_ID'  => 'm_color_id',
                                    'COKOR_CODE_PRICE'  => 'color_code_price',
                                    'SORT_ORDER'  => 'sort_order',
                            ]
                   ],
                   'm_color_trans' =>  [
                            'nametable' => 'm_color_trans',
                            'column' => [
                                    'M_COLOR_ID'  => 'm_color_id',
                                    'M_LANG_ID'  => 'm_lang_id',
                                    'COLOR_NAME'  => 'color_name',
                            ]
                   ],
                    'm_color_ctg_prod' =>  [
                            'nametable' => 'm_color_ctg_prod',
                            'column' => [
                                    'M_COLOR_ID'  => 'm_color_id',
                                    'CTG_PROD_ID'  => 'ctg_prod_id',
                                    'IMG_PATH'  => 'img_path',
                                    'IMG_NAME'  => 'img_name',
                            ]
                   ],
                   'm_color_model' =>  [
                            'nametable' => 'm_color_model',
                            'column' => [
                                    'M_COLOR_ID'  => 'm_color_id',
                                    'M_MODEL_ID'  => 'm_model_id',
                                    'IMG_PATH'  => 'img_path',
                                    'IMG_NAME'  => 'img_name',
                            ]
                   ],
                   'check_product_model' =>  [
                            'nametable' => 'check_product_model',
                            'column' => [
                                    'PRODUCT_ID'  => 'product_id',
                                    'M_MODEL_ID'  => 'm_model_id',
                                    'M_LANG_ID'  => 'm_lang_id',
                                    'MODEL_NAME'  => 'model_name',
                            ]
                   ],
                   'm_model' =>  [
                            'nametable' => 'm_model',
                            'column' => [
                                    'M_MODEL_ID'  => 'm_model_id',
                                    'VIEWER_FLG'  => 'viewer_flg',
                                    'PRODUCT_FLG'  => 'public_flg',
                                    'IMG_PATH'  => 'img_path',
                                    'IMG_NAME'  => 'img_name',
                                    'CTG_MODEL_ID'  => 'ctg_model_id',
                                    'SORT_ORDER'  => 'sort_order',
                            ]
                   ],
                   'm_model_trans' =>  [
                            'nametable' => 'm_model_trans',
                            'column' => [
                                    'M_MODEL_ID'  => 'm_model_id',
                                    'M_LANG_ID'  => 'm_lang_id',
                                    'MODEL_NAME'  => 'model_name',
                                    'PRODUCT_ID'  => 'product_id',
                            ]
                   ],
                  'product' =>  [
                            'nametable' => 'product',
                            'column' => [
                                    'PRODUCT_ID'  => 'product_id',
                                    'SORT_ORDER'  => 'sort_order',
                                    'CTG_PROD_ID'  => 'ctg_prod_id',
                                    'CTG_RISE_ID'  => 'ctg_rise_id',
                                    'IMG_PATH' => 'img_path',
                                    'IMG_NAME' => 'img_name',
                                    'VIEWER_FLG' => 'viewer_flg', 
                            ]
                   ],
                   'm_model_spec' =>  [
                            'nametable' => 'm_model_spec',
                            'column' => [
                                    'M_MODEL_ID'  => 'm_model_id',
                                    'PRODUCT_ID'  => 'product_id',
                                    'SPEC'  => 'spec',
                            ]
                   ],
            
                   'product_trans' =>  [
                            'nametable' => 'product_trans',
                            'column' => [
                                    'PRODUCT_ID'  => 'product_id',
                                    'M_LANG_ID'  => 'm_lang_id',
                                    'PRODUCT_NAME'  => 'product_name',
                                    'PRODUCT_DESC'  => 'product_desc',
                            ]

                   ],
                  'm_selling_spec' =>  [
                            'nametable' => 'm_selling_spec',
                            'column' => [
                                    'SPEC_CODE'  => 'spec_code',
                                    'SPEC_GROUP'  => 'm_spec_group_id',
                                    'SORT_ORDER'  => 'sort_order',
                                    'IMG_PATH'  => 'img_path',
                                    'IMG_NAME'  => 'img_name',
                                    'DISPLAY_FLG'  => 'display_flg',
                            ]
                   ],
                  'm_spec_group' =>  [
                            'nametable' => 'm_spec_group',
                            'column' => [
                                    'SPEC_GROUP'  => 'm_spec_group_id',
                                    'CTG_SPEC_ID'  => 'ctg_spec_id',
                                    'SORT_ORDER'  => 'sort_order',
                                    'ALIAS_NAME'  => 'alias_name',
                            ]
                   ],
                  'm_special_color_code' =>  [
                            'nametable' => 'm_special_color_code',
                            'column' => [
                                    'M_COLOR_ID'  => 'm_color_id',
                                    'SPECIAL_CHARACTER'  => 'special_character',
                                    'REPLACE_CODE'  => 'replace_code',
                            ]
                   ],
                   'm_selling_spec_trans' =>  [
                            'nametable' => 'm_selling_spec_trans',
                            'column' => [
                                    'SPEC_CODE'  => 'spec_code',
                                    'M_LANG_ID'  => 'm_lang_id',
                                    'SPEC_NAME'  => 'spec_name',
                            ]
                   ],
                   'product_selling_spec' =>  [
                            'nametable' => 'product_selling_spec',
                            'column' => [
                                    'PRODUCT_ID'  => 'product_id',
                                    'SPEC_CODE'  => 'spec_code',
                            ]
                   ],
                   'm_selling_code' =>  [
                            'nametable' => 'm_selling_code',
                            'column' => [
                                    'SELLING_CODE'  => 'selling_code',
                                    'PRODUCT_ID'  => 'product_id',
                                    'INSECT_SCREEN'  => 'insect_screen',
                                    'DOOR_CLOSER'  => 'door_closer',
                                    'SPEC1'  => 'spec1',
                                    'SPEC2'  => 'spec2',
                                    'SPEC3'  => 'spec3',
                                    'SPEC4'  => 'spec4',
                                    'SPEC5'  => 'spec5',
                                    'SPEC6'  => 'spec6',
                                    'SPEC7'  => 'spec7',
                                    'SPEC8'  => 'spec8',
                                    'SPEC9'  => 'spec9',
                                    'SPEC10'  => 'spec10',
                                    'SPEC11'  => 'spec11',
                                    'SPEC12'  => 'spec12',
                                    'SPEC13'  => 'spec13',
                                    'SPEC14'  => 'spec14',
                                    'SPEC15'  => 'spec15',
                                    'SPEC16'  => 'spec16',
                                    'SPEC17'  => 'spec17',
                                    'SPEC18'  => 'spec18',
                                    'SPEC19'  => 'spec19',
                                    'SPEC20'  => 'spec20',
                                    'OPTION'  => 'option',
                                    'SPEC'  => 'spec',
                                    'SELLING_CODE_TYPE' => 'selling_code_type'

                            ]
                   ],
                   'product_selling_code_price' =>[
                            'nametable' => 'product_selling_code_price',
                            'column' => [
                                    'DESIGN'  => 'design',
                                    'WIDTH'  => 'width',
                                    'HEIGHT'  => 'height',
                                    'SPECIAL'  => 'special',
                                    'AMOUNT'=>'amount',
                                    'WIDTHORG'  => 'width_org',
                                    'HEIGHTORG'  => 'height_org',
                                   
                            ]
                   ],
                    'history_import_product_selling_code_price' =>[
                                   'nametable' => 'history_import_product_selling_code_price',
                                   'column' => [
                                           'ID'  => 'id',  
                                           'FILENAME'  => 'filename',
                                           'USER'  => 'user',
                                           'STATUS'  => 'status',
                                   ]
                          ],
                'common_columns' =>[
                    'column' => [
                          'DEL_FLG'  => 'del_flg',
                          'ADD_USER_ID'  => 'add_user_id',
                          'ADD_DATETIME'  => 'add_datetime',
                          'UPD_USER_ID'  => 'upd_user_id',
                          'UPD_DATETIME'=>'upd_datetime',
                                ]
                    ]
        ],

        

];
