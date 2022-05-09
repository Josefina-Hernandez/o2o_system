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
                   'm_size_limit' =>  [
                            'nametable' => 'm_size_limit',
                            'column' => [
                                    'PRODUCT_ID'  => 'product_id',
                                    'M_MODEL_ID'  => 'm_model_id',
                                    'SPEC33'  => 'spec33',
                                    'SPEC35'  => 'spec35',
                                    'MIN_WIDTH'  => 'min_width',
                                    'MAX_WIDTH'  => 'max_width',
                                    'MIN_HEIGHT'  => 'min_height',
                                    'MAX_HEIGHT'  => 'max_height'
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
                            ]
                   ],
                  'm_spec_group' =>  [
                            'nametable' => 'm_spec_group',
                            'column' => [
                                    'SPEC_GROUP'  => 'm_spec_group_id',
                                    'CTG_SPEC_ID'  => 'ctg_spec_id',
                                    'SORT_ORDER'  => 'sort_order',
                                    'ALIAS_NAME'  => 'alias_name',
                                    'DISPLAY_FLG'  => 'display_flg',
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
                                    'OPTION'  => 'option',
                                    'SPEC'  => 'spec',
                                    'IMG_PATH'  => 'img_path',
                                    'IMG_NAME'  => 'img_name',
                            ]
                   ],
                   'm_option_selling_code' =>  [
                            'nametable' => 'm_option_selling_code',
                            'column' => [
                                    'OPTION_CTG_SPEC_ID' => 'option_ctg_spec_id',
                                    'M_COLOR_ID' => 'm_color_id',
                                    'MIN_WIDTH' => 'min_width',
                                    'MAX_WIDTH' => 'max_width',
                                    'MIN_HEIGHT' => 'min_height',
                                    'MAX_HEIGHT' => 'max_height',
                                    'SELLING_CODE'  => 'selling_code',
                                    'PRODUCT_ID'  => 'product_id',
                                    'OPTION'  => 'option',
                                    'SPEC'  => 'spec',
                                    'DESCRIPTION' => 'description'
                            ]
                   ],
                   'product_selling_code_price' =>[
                            'nametable' => 'product_selling_code_price',
                            'column' => [
                                    'ID'  => 'product_selling_code_price_id',
                                    'DESIGN'  => 'design',
                                    'WIDTH'  => 'width',
                                    'HEIGHT'  => 'height',
                                    'SPECIAL'  => 'special',
                                    'AMOUNT'=>'amount',
                                    'WIDTHORG'  => 'width_org',
                                    'HEIGHTORG'  => 'height_org',
                                     /* add new 2020/05/20 */
                                    'MATERIAL'  => 'material',
                                    'GLASS_TYPE'  => 'glass_type',
                                    'GLASS_THICKNESS'  => 'glass_thickness',
                                    /* end  add new 2020/05/20 */

                            ]
                   ],
                   'option_selling_code_price' =>[
                            'nametable' => 'option_selling_code_price',
                            'column' => [
                                    'ID'  => 'option_selling_code_price_id',
                                    'DESIGN'  => 'design',
                                    'WIDTH'  => 'width',
                                    'HEIGHT'  => 'height',
                                    'SPECIAL'  => 'special',
                                    'AMOUNT'=>'amount',
                                    'WIDTHORG'  => 'width_org',
                                    'HEIGHTORG'  => 'height_org',
                                     /* add new 2020/05/20 */
                                    'MATERIAL'  => 'material',
                                    'GLASS_TYPE'  => 'glass_type',
                                    'GLASS_THICKNESS'  => 'glass_thickness',
                                    /* end  add new 2020/05/20 */

                            ]
                   ],
                    'history_import_product_selling_code_price' =>[
                                   'nametable' => 'history_import_product_selling_code_price',
                                   'column' => [
                                           'ID'  => 'id',
                                           'FILENAME'  => 'filename',
                                           'STATUS'  => 'status',
                                           'OPTION'  => 'option',
                                   ]
                          ],
                    't_quotation' =>[
                                         'nametable' => 't_quotation',
                                         'column' => [
                                                  'NO'  => 'no',/*DELETED*/
                                                  'T_QUOTATION_ID'  => 't_quotation_id',
                                                  'QUOTATION_USER'  => 'quotation_user',
                                                  'ITEM'  => 'item',
                                                  'HL'  => 'hl',
                                                  'MATERIAL'  => 'material',
                                                  'DESIGN'  => 'design',
                                                  'REF'  => 'ref',
                                                  'QTY'  => 'qty',
                                                  'ONE_WINDOW'  => 'one_window',
                                                  'JOINT'  => 'joint',
                                                  'SCREEN'  => 'screen',
                                                  'OFF_SPEC'  => 'off_spec',
                                                  'MAIN_GLASS'  => 'main_glass',
                                                  'COLOR'  => 'color',
                                                  'W'  => 'w',
                                                  'H'  => 'h',
                                                  'W_OPENING'  => 'w_opening',
                                                  'H_OPENING'  => 'h_opening',
                                                  'SPECIAL_CODE'  => 'special_code',
                                                  'GLASS_TYPE'  => 'glass_type',
                                                  'GLASS_HIC_ENESS'  => 'glass_hic_eness',
                                                  'MATERIAL_REFERENCE'  => 'material_reference',
                                                  'MATERIAL_DESCRIPTION'  => 'material_description',
                                                  'M_QUOTATION_ID'=>'m_quotation_id',
                                                  'COLOR_CODE' => 'color_code',
                                                  'AMOUNT' => 'amount',
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
                    ],
                'm_mailaddress' =>[
                    'nametable' => 'm_mailaddress',
                    'column' => [
                          'ID' => 'id',
                          'DEPARTMENT_CODE'  => 'department_code',
                          'GROUPNAME' => 'groupname',
                          'ADMIN_FLG' => 'admin_flg'
                                ]
                    ],
                'users' =>[
                    'nametable' => 'users',
                    'column' => [
                          'DEPARTMENT_CODE'  => 'department_code',
                          'COMPANY'=>'company',
                          'M_MAILADDRESS_ID'=>'m_mailaddress_id',
                                ]
                    ],

                'm_quotation' =>[
                    'nametable' => 'm_quotation',
                    'column' => [
                        'M_QUOTATION_ID'  => 'm_quotation_id',
                        'QUOTATION_SESSION'  => 'quotation_session',
                        'QUOTATION_USER'  => 'quotation_user',
                        'QUOTATION_DEPARMENT'  => 'quotation_deparment',
                        'QUOTATION_DATE'  => 'quotation_date',
                        'QUOTATION_NO'  => 'quotation_no',
                        'DATA_CART' =>  'data_cart',
                        'HTML_CART' =>  'html_cart',
                        'BUTTON_PDF' =>  'button_pdf',
                        'BUTTON_MAIL' =>  'button_mail',
                        'NEW_OR_REFORM' => 'new_or_reform' //Add add popup status New/Reform hainp 20200924
                    ]
                ],
                'm_model_item_display' =>[
                    'nametable' => 'm_model_item_display',
                    'column' => [
                                  'M_MODEL_ID'  => 'm_model_id',
                                  'M_MODEL_ITEM_ID' => 'm_model_item_id',
                                  'SPEC'  => 'spec',
                                ]
                    ],
                'm_model_item' =>[
                    'nametable' => 'm_model_item',
                    'column' => [
                                  'M_MODEL_ITEM_ID'  => 'm_model_item_id',
                                  'SORT_ORDER'  => 'sort_order',
                                ]
                    ],
                'm_model_item_trans' =>[
                    'nametable' => 'm_model_item_trans',
                    'column' => [
                                  'M_MODEL_ITEM_ID' => 'm_model_item_id',
                                  'M_LANG_ID'  => 'm_lang_id',
                                  'ITEM_DISPLAY_NAME'  => 'item_display_name',
                                ]
                    ],
                'm_door_closer_color' =>[
                    'nametable' => 'm_door_closer_color',
                    'column' => [
                                  'SPEC51' => 'spec51',
                                  'DOOR_CLOSER_COLOR_ID'  => 'door_closer_color_id',
                                  'PANEL_COLOR_ID'  => 'panel_color_id',
                                ]
                    ],
                'm_option_selling_code_giesta' =>[
                    'nametable' => 'm_option_selling_code_giesta',
                    'column' => [
                                  'OPTION_CTG_SPEC_ID' => 'option_ctg_spec_id',
                                  'M_COLOR_ID' => 'm_color_id',
                                  'SELLING_CODE' => 'selling_code',
                                  'DESCRIPTION' => 'description',
                                  'PRODUCT_ID' => 'product_id',
                                  'SPEC_HANDLE_TYPE_PRODUCT_ID' => 'spec_handle_type_product_id',
                                  'OPTION4' => 'option4',
                                  'OPTION5' => 'option5',
                                  'SPEC' => 'spec',
                                  'M_OPTION_SELLING_CODE_GIESTA_ID' => 'm_option_selling_code_giesta_id'
                                ]
                    ],
                'm_selling_code_giesta' =>[
                    'nametable' => 'm_selling_code_giesta',
                    'column' => [
                                  'CTG_PART_ID' => 'ctg_part_id',
                                  'SPEC' => 'spec',
                                  'SELLING_CODE' => 'selling_code',
                                  'PRODUCT_ID' => 'product_id',
                                  'M_SELLING_CODE_GIESTA_ID' => 'm_selling_code_giesta_id',
                                ]
                ],
                'm_door_large_size' =>[
                    'nametable' => 'm_door_large_size',
                    'nametable_update' => 'm_large_size',// name table update new v2.0
                    'column' => [
                                  'PRODUCT_ID' => 'product_id',
                                  'M_MODEL_ID'  => 'm_model_id',
                                  'SPEC3' => 'spec3',
                                  'SPEC5' => 'spec5',
                                  'MIN_HEIGHT' => 'min_height',
                                  'MAX_HEIGHT' => 'max_height',
                                ]
                ],
                'm_spec_image' =>[
                    'nametable' => 'm_spec_image',
                    'column' => [
                                  'PRODUCT_ID' => 'product_id',
                                  'IMG_PATH'  => 'img_path',
                                  'IMG_NAME'  => 'img_name',
                                  'OPTION1'  => 'option1',
                                  'OPTION2'  => 'option2',
                                  'OPTION3'  => 'option3',
                                  'SPEC' => 'spec',
                                  'OPTION4'  => 'option4',
                                  'OPTION5'  => 'option5',
                                  'SPEC57'  => 'spec57',
                                  'SPEC53'  => 'spec53',
                                ]
                ],
                'm_fence_base_recommend_base' =>[
                    'nametable' => 'm_fence_base_recommend_base',
                    'column' => [
                                  'PITCH' => 'pitch',
                                  'MIN_WIDTH' => 'min_width',
                                  'MAX_WIDTH' => 'max_width',
                                ]
                ],
                'm_fence_base_recommend_wall' =>[
                    'nametable' => 'm_fence_base_recommend_wall',
                    'column' => [
                                  'PITCH' => 'pitch',
                                  'MIN_WIDTH' => 'min_width',
                                  'MAX_WIDTH' => 'max_width',
                                ]
                ],
                'm_fence_stright_joint_base' =>[
                    'nametable' => 'm_fence_stright_joint_base',
                    'column' => [
                                  'PITCH' => 'pitch',
                                  'MIN_MM' => 'min_mm',
                                  'MAX_MM' => 'max_mm',
                                  'QUANTITY' => 'quantity',
                                  'DIFFERENCE_PANEL' => 'difference_panel',

                                ]
                ],
                'm_fence_stright_joint_wall' =>[
                    'nametable' => 'm_fence_stright_joint_wall',
                    'column' => [
                                  'PITCH' => 'pitch',
                                  'MIN_MM' => 'min_mm',
                                  'MAX_MM' => 'max_mm',
                                  'QUANTITY' => 'quantity',
                                  'DIFFERENCE_PANEL' => 'difference_panel',

                                ]
                ],
                'fence_qty_define' =>[
                    'nametable' => 'fence_qty_define',
                    'column' => [
                                  'SPEC' => 'spec',
                                  'OPTION' => 'option',
                                  'DEFINE' => 'define',
                                ]
                ],
                'm_define_hardcode' => [
                	'nametable' => 'm_define_hardcode',
                	'column' => [
                		'M_DEFINE_HARDCODE_ID' => 'm_define_hardcode_id',
                		'DEF_NAME' => 'def_name',
                		'COLUMN_NAME' => 'column_name',
                		'DEF_VALUE' => 'def_value',
                		'DEF_VALUE1' => 'def_value1',
                		'DEF_VALUE2' => 'def_value2',
                		'DEF_VALUE3' => 'def_value3',
                		'DEF_VALUE4' => 'def_value4',
                		'DEF_VALUE5' => 'def_value5',
                	],
                ],
                'giesta_selling_code_price' =>[
                            'nametable' => 'giesta_selling_code_price',
                            'column' => [
                                    'ID'  => 'giesta_selling_code_price_id',
                                    'DESIGN'  => 'design',
                                    'WIDTH'  => 'width',
                                    'HEIGHT'  => 'height',
                                    'SPECIAL'  => 'special',
                                    'AMOUNT'=>'amount',
                                    'WIDTHORG'  => 'width_org',
                                    'HEIGHTORG'  => 'height_org',
                                      /* add new 2020/05/20 */
                                    'MATERIAL'  => 'material',
                                    'GLASS_TYPE'  => 'glass_type',
                                    'GLASS_THICKNESS'  => 'glass_thickness',
                                    /* end  add new 2020/05/20 */
                            ]
                   ],
                  'm_product_submenu' => [
                      'nametable' => 'm_product_submenu',
                      'column' =>[
                          'PRODUCT_ID' => 'product_id',
                          'SPEC_CODE' => 'spec_code',
                          'LINK_TEXT' => 'link_text',
                          'LINK_URL' => 'link_url',
                          'DESCRIPTION' => 'description',
                          'SORT_ORDER'  => 'sort_order',
                          'M_LANG_ID'  => 'm_lang_id',
                      ]
                  ],


        ],

];

