<?php
return [
    'select' => [
    	'SPEC_GROUP' => "
    		SELECT m_spec_group_id, MIN(sort_order) AS sort_order
			FROM `m_selling_spec`
			GROUP BY m_spec_group_id
			ORDER BY sort_order, CAST(m_spec_group_id as int)
    	",

    	'GET_CONFIG_DISPLAY_PITCH_LIST' => "
    		SELECT
    			h.def_value AS m_model_id
    			, h.def_value1 AS product_id
    			, h.def_value2 AS img_name
    		FROM
    			m_define_hardcode AS h
    		WHERE
    			h.del_flg = 0
    			AND h.def_name = 'config_display_pitch_list'
    			AND h.column_name = 'm_model_id'
    			AND h.def_value = :m_model_id
    			AND h.def_value1 = :product_id
    	",

    	'GET_CONFIG_PICTURE_SHOW_R_MOVEMENT' => "
    		SELECT
    			h.def_value AS m_model_id
    			, h.def_value1 AS product_id
    			, h.def_value2 AS spec_setting
    		FROM
    			m_define_hardcode AS h
    		WHERE
    			h.del_flg = 0
    			AND h.def_name = 'config_picture_show_r_movement'
    			AND h.column_name = 'm_model_id'
    			AND h.def_value = :m_model_id
    			AND h.def_value1 = :product_id
    	",

    	'GET_CONFIG_STACK_NUMBER_DISPLAY' => "
    		SELECT
    			h.def_value AS m_model_id
    			, h.def_value1 AS spec_value
    			, h.def_value2 AS stack_number
    			, h.def_value3 AS product_id
    		FROM m_define_hardcode AS h
    		WHERE
    			h.del_flg = 0
    			AND h.def_name = 'config_stack_number_display'
    			AND h.column_name = 'm_model_id'
    			AND h.def_value = :m_model_id
    	",

		//Add Start BP_O2OQ-4 hainp 20200608
		'GET_CONFIG_DO_NOT_DISPLAY_DETAIL_CART' => "
    		SELECT
				h.m_define_hardcode_id
				, h.def_value
    		FROM m_define_hardcode AS h
    		WHERE
    			h.del_flg = 0
    			AND h.def_name = 'config_do_not_display_detail_cart'
    			AND h.column_name = 'product_id'
		",
		//Add End BP_O2OQ-4 hainp 20200608

    	'GET_CONFIG_FENCE_QUANTITY' => "
    		SELECT
    			h.def_value AS m_model_id
    			, h.def_value1 AS selling_code
    			, h.def_value2 AS compare_value
    			, h.def_value3 AS add_qty
    		FROM m_define_hardcode AS h
    		WHERE
    			h.del_flg = 0
    			AND h.def_name = 'config_fence_quantity'
    			AND h.column_name = 'm_model_id'
    	",

    	"SPEC_GROUP_DO_NOT_DISPLAY" => "
    		SELECT DISTINCT
    			CASE WHEN g.m_spec_group_id LIKE '%o%' THEN REPLACE(g.m_spec_group_id, 'o', 'option')
    			ELSE CONCAT('spec', g.m_spec_group_id)
				END AS m_spec_group_id
			FROM m_selling_spec AS s
			INNER JOIN m_spec_group AS g
				ON
					s.m_spec_group_id = g.m_spec_group_id
					AND g.del_flg = 0
					AND g.display_flg = 0
			WHERE
				s.del_flg = 0
				AND s.spec_code IN (:spec_code)
			ORDER BY g.sort_order ASC
    	",

    	'GROUP_LABEL' => "
    		-- Get display label of [SPEC/OPTION]
			SELECT DISTINCT
				msg.m_spec_group_id
				,ct.ctg_name AS spec_group_label
				,msg.sort_order
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'spec'
			INNER JOIN m_spec_group AS msg
				ON
					msg.del_flg = 0
					AND msg.ctg_spec_id = c.ctg_id
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND msg.m_spec_group_id IN (:m_spec_group_id)-- là giá trị tương ứng 1~26 , o1, o2 của table m_selling_spec.m_spec_group_id
    	",
    	'OPTIONS_LIST_PARAM' => "
    		SELECT DISTINCT
				l.lang_code
				, c.ctg_id
				, p.product_id
				, m.m_model_id
				, '1,3' AS viewer_flg
			FROM m_lang AS l
			INNER JOIN product_trans AS pt
				ON pt.del_flg = 0
					AND pt.m_lang_id = l.m_lang_id
			INNER JOIN product AS p
				ON p.del_flg = 0
					AND p.product_id = pt.product_id
			INNER JOIN ctg_trans AS ct
				ON ct.del_flg = 0
					AND ct.m_lang_id = l.m_lang_id
					AND ct.ctg_id = p.ctg_prod_id
			INNER JOIN ctg AS c
				ON c.del_flg = 0
					AND c.ctg_id = ct.ctg_id
			INNER JOIN v_product_model_refer AS v
				ON v.product_id = p.product_id
			INNER JOIN m_model_trans AS mt
				ON mt.del_flg = 0
					AND mt.m_lang_id = l.m_lang_id
					AND mt.m_model_id = v.m_model_id
			INNER JOIN m_model AS m
				ON m.del_flg = 0
					AND m.m_model_id = mt.m_model_id
			WHERE l.del_flg = 0
			ORDER BY
				l.lang_code
				, c.ctg_id
				, p.product_id
				, m.m_model_id
    	",

    	'OPTIONS_GIESTA_LIST_PARAM' => "
    		SELECT DISTINCT
				l.lang_code
				, c.ctg_id
				, p.product_id
				, m.m_model_id
				, '3' AS viewer_flg
			FROM m_lang AS l
			INNER JOIN product_trans AS pt
				ON pt.del_flg = 0
					AND pt.m_lang_id = l.m_lang_id
			INNER JOIN product AS p
				ON p.del_flg = 0
					AND p.product_id = pt.product_id
			INNER JOIN ctg_trans AS ct
				ON ct.del_flg = 0
					AND ct.m_lang_id = l.m_lang_id
					AND ct.ctg_id = p.ctg_prod_id
			INNER JOIN ctg AS c
				ON c.del_flg = 0
					AND c.ctg_id = ct.ctg_id
			INNER JOIN v_product_giesta_model_refer AS v
				ON v.product_id = p.product_id
			INNER JOIN m_model_trans AS mt
				ON mt.del_flg = 0
					AND mt.m_lang_id = l.m_lang_id
					AND mt.m_model_id = v.m_model_id
			INNER JOIN m_model AS m
				ON m.del_flg = 0
					AND m.m_model_id = mt.m_model_id
			WHERE l.del_flg = 0
			ORDER BY
				l.lang_code
				, c.ctg_id
				, p.product_id
				, m.m_model_id
    	",

    	'OPTIONS_DATA' => "
    		SELECT DISTINCT
    			v.*
    		FROM v_option_refer AS v
    		WHERE  v.lang_code = COALESCE(:lang_code, 'en')
					AND v.ctg_id = :ctg_id
					AND v.product_id = :product_id
					AND v.m_model_id = :m_model_id
					-- PRODUCT
					AND v.p_viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
					-- MODEL
					AND v.m_viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
					AND v.hidden_storage_flg = 1
			ORDER BY v.selling_code ASC
    	",

    	'OPTIONS_GIESTA_DATA' => "
    		SELECT DISTINCT
    			v.*
    		FROM v_option_giesta_refer AS v
    		WHERE  v.lang_code = COALESCE(:lang_code, 'en')
					AND v.ctg_id = :ctg_id
					AND v.product_id = :product_id
					AND v.m_model_id = :m_model_id
    	",

    	'OPTIONS' => "
    		-- SELECT CONTROL SPEC-OPTION-PRICE
    		WITH tb_op_color AS (
				SELECT DISTINCT 
					o.product_id
					, o.m_color_id AS _option_color_id
					, c.color_code_price AS _option_color_name
					, o.option5
					, o.option10 
				FROM 
					m_option_selling_code o
				INNER JOIN m_color c 
					ON
						o.m_color_id = c.m_color_id 
						AND c.del_flg = 0
				WHERE 
					o.del_flg = 0 
					AND o.m_color_id IS NOT NULL 
					AND o.product_id IS NOT NULL 
					AND o.product_id = 10 -- Apply only for ATIS
			)
    		, tb AS (
				SELECT DISTINCT
					m.m_model_id
					, l.lang_code
					, c.ctg_id
					, p.product_id
					, p.viewer_flg AS p_viewer_flg
					, m.viewer_flg AS m_viewer_flg
					, COALESCE(mt1.model_name, mt.model_name) AS model_name_display
					, TRIM(CONCAT(COALESCE(pt.product_name, ''), ' ', COALESCE(mt1.model_name, mt.model_name))) AS series_name
					, pt.product_name
					, CASE
						WHEN p.product_id = 10 THEN CONCAT(clm.img_path,'/atis')
						WHEN p.product_id = 1 THEN CONCAT(clm.img_path,'/we_plus') -- Added by An Lu on 2024/06/14
						WHEN p.product_id = 2 THEN CONCAT(clm.img_path,'/we_70') -- Added by An Lu on 2024/06/14
						WHEN p.product_id = 3 THEN CONCAT(clm.img_path,'/we_40') -- Added by An Lu on 2024/06/14
						ELSE clm.img_path
					END AS img_path_result
					, LOWER(clm.img_name) AS img_name_result
					, colortr.m_color_id
					, colortr.color_name
					, color.color_code_price
					, ccp.img_path
					, LOWER(ccp.img_name) AS img_name
					, sc.selling_code
					, CASE
						WHEN m.m_model_id IN (54, 55) THEN sc.img_path
						ELSE NULL
					  END AS img_path_spec29 -- use for [Mulion/Transom] Model
					, CASE
						WHEN m.m_model_id IN (54, 55) THEN sc.img_name
						ELSE NULL
					  END AS img_name_spec29 -- use for [Mulion/Transom] Model
					, sc.option1
					, sc.option2
					, sc.option3
					, sc.option5 -- Add BP_O2OQ-6 MinhVnit 20200625
					, si_option5.img_path AS _option5_img_path -- Add BP_O2OQ-27 MinhVnit 20210819
					, si_option5.img_name AS _option5_img_name -- Add BP_O2OQ-27 MinhVnit 20210819
					, sc.option6 -- Add BP_O2OQ-6 MinhVnit 20200625
					, sc.option7 -- Add BP_O2OQ-27 MinhVnit 20210819
					, sc.option8 -- Add BP_O2OQ-27 MinhVnit 20210819
					, sc.option9 -- Add BP_O2OQ-29 MinhVnit 20211029
					, sc.option10 -- Add BP_O2OQ-29 MinhVnit 20211029
					, sc.option11 -- Add BP_O2OQ-29 MinhVnit 20211029
					, sc.option12 -- Added by Anlu AKT 20240209
					, sc.option13 -- Added by Anlu AKT 20240221
					, sc.spec1
					, sc.spec2
					, COALESCE(spec3_mapping.spec3, sc.spec3) AS spec3 -- Xủ lý trường hợp spec3 quyết định sau khi chọn height
					, sc.spec4
					, COALESCE(spec5_mapping.spec5, sc.spec5) AS spec5 -- Xủ lý trường hợp spec5 quyết định sau khi chọn height
					, sc.spec6
					, sc.spec7
					, sc.spec8
					, sc.spec9
					, sc.spec10
					, sc.spec11
					, sc.spec12
					, sc.spec13
					, sc.spec14
					, sc.spec15
					, sc.spec16
					, sc.spec17
					, sc.spec18
					, sc.spec19
					, sc.spec20
					, sc.spec21
					, sc.spec22
					, sc.spec23
					, sc.spec24
					, sc.spec25
					, sc.spec26
					, sc.spec27
					, sc.spec28
					, sc.spec29
					, sc.spec30
					, sc.spec31
					, sc.spec32 -- Add BP_O2OQ-6 MinhVnit 20200625
					, sc.spec33 -- Add BP_O2OQ-6 MinhVnit 20200625
					, sc.spec34 -- Add BP_O2OQ-6 MinhVnit 20200625
					, sc.spec35 -- Add BP_O2OQ-6 MinhVnit 20200710 
					, sc.spec36 -- Add BP_O2OQ-6 MinhVnit 20200710
					, sc.spec37 -- Add BP_O2OQ-9 MinhVnit 20200901
					, sc.spec38 -- Add BP_O2OQ-27 MinhVnit 20210819 
					, sc.spec39 -- Add BP_O2OQ-27 MinhVnit 20210819
					, sc.spec40 -- Add BP_O2OQ-27 MinhVnit 20210819
					, sc.spec41 -- Add BP_O2OQ-29 MinhVnit 20211103
					, tb_op_color._option_color_id -- Add BP_O2OQ-29 MinhVnit 20211002
					, tb_op_color._option_color_name -- Add BP_O2OQ-29 MinhVnit 20211002
					, price.width
					, price.height
					, price.amount
					, 0 AS hidden_storage_flg
				FROM m_lang AS l
				INNER JOIN ctg_trans AS ct
					ON
						l.m_lang_id = ct.m_lang_id
						AND ct.del_flg = 0
				INNER JOIN ctg AS c
					ON
						c.ctg_id = ct.ctg_id
						AND c.del_flg = 0
						AND c.ctg_type = 'prod'
				INNER JOIN product_trans AS pt
					ON
						l.m_lang_id = pt.m_lang_id
						AND pt.del_flg = 0
				INNER JOIN product AS p
					ON
						p.product_id = pt.product_id
						AND p.ctg_prod_id = c.ctg_id
						AND p.del_flg = 0
				INNER JOIN v_product_model_refer AS v
					ON
						v.product_id = p.product_id
				INNER JOIN m_model_trans AS mt
					ON
						mt.m_model_id = v.m_model_id
						AND mt.m_lang_id = l.m_lang_id
						AND mt.del_flg = 0
				INNER JOIN m_model AS m
					ON
						m.m_model_id = mt.m_model_id
						AND m.del_flg = 0
				LEFT JOIN m_model_trans AS mt1
					ON
						mt1.product_id = p.product_id
						AND mt1.m_lang_id = l.m_lang_id
						AND mt1.m_model_id = m.m_model_id
						AND mt1.del_flg = 0
				INNER JOIN m_color_ctg_prod AS ccp
					ON
						ccp.ctg_prod_id = c.ctg_id
						AND ccp.del_flg = 0
				INNER JOIN m_color_model AS clm
					ON
						clm.m_model_id = m.m_model_id
						AND clm.m_color_id = ccp.m_color_id
						AND clm.del_flg = 0
				INNER JOIN m_color_trans AS colortr
					ON
						colortr.m_color_id = clm.m_color_id
						AND colortr.m_lang_id = l.m_lang_id
						AND colortr.del_flg = 0
				INNER JOIN m_color AS color
					ON
						color.m_color_id = colortr.m_color_id
						AND color.del_flg = 0
				INNER JOIN m_model_spec AS ms
					ON
						ms.m_model_id = m.m_model_id
						AND ms.del_flg = 0
				INNER JOIN m_selling_code AS sc
					ON
						sc.m_selling_code_id = v.m_selling_code_id
						AND sc.product_id = v.product_id
						AND sc.del_flg = 0    -- Updated  by An Lu AKT on Feb 6th, 2024
				LEFT JOIN tb_op_color -- Add BP_O2OQ-29 MinhVnit 20211002
					ON
						sc.product_id = tb_op_color.product_id
						AND 
							(
								sc.option5 = tb_op_color.option5 
								OR sc.option10 = tb_op_color.option10
							)
				LEFT JOIN m_spec_image AS si_option5
					ON
						si_option5.del_flg = 0
						AND si_option5.product_id = sc.product_id
						AND si_option5.option5 = sc.option5 -- Use for BP_O2OQ-27 Handle option
				INNER JOIN v_product_price_refer AS price
					ON
						price.design = sc.selling_code
						AND (
								-- chỉ có GIESTA mới có value Special
								-- còn lại đều là blank
								(p.product_id IN (5) AND color.color_code_price = price.special) -- GIESTA
								OR (price.special IS NULL)
							)
				-- Xủ lý trường hợp spec3 quyết định sau khi chọn height
				INNER JOIN v_m_large_size AS spec3_mapping
					ON
						spec3_mapping.product_id = p.product_id
						AND spec3_mapping.m_model_id = m.m_model_id
						AND (spec3_mapping.spec3 IS NULL OR sc.spec3 = spec3_mapping.spec3)
						AND (spec3_mapping.min_height IS NULL OR spec3_mapping.min_height <= price.height)
						AND (spec3_mapping.max_height IS NULL OR spec3_mapping.max_height >= price.height)
				-- Xủ lý trường hợp spec5 quyết định sau khi chọn height
				INNER JOIN v_m_large_size AS spec5_mapping
					ON
						spec5_mapping.product_id = p.product_id
						AND spec5_mapping.m_model_id = m.m_model_id
						AND (spec5_mapping.spec5 IS NULL OR sc.spec5 = spec5_mapping.spec5)
						AND (spec5_mapping.min_height IS NULL OR spec5_mapping.min_height <= price.height)
						AND (spec5_mapping.max_height IS NULL OR spec5_mapping.max_height >= price.height)

				WHERE
					l.del_flg = 0
					AND l.lang_code = COALESCE(:lang_code, 'en')
					AND c.ctg_id = :ctg_id
					AND p.product_id = :product_id
					AND mt.product_id IS NULL
					AND m.m_model_id = :m_model_id
					
					-- Add BP_O2OQ-29 MinhVnit 20211101 ATIS do not display color_id = 3
					AND color.m_color_id != (IF( (p.product_id = 10 AND m.m_model_id IN (2,5,6,8,9,10,18,19,22,23,54,55)), 3, -999))
					
					-- Add BP_O2OQ-29 MinhVnit 20211102 Refer option_color_id with color_id ( Apply only for ATIS)
					AND color.m_color_id = (IF(tb_op_color._option_color_id IS NOT NULL, tb_op_color._option_color_id, color.m_color_id))
					
					-- AND color.m_color_id = :m_color_id
					-- AND sc.spec1 = :spec1
					-- AND sc.spec2 = :spec2
					-- ...
					-- AND price.width = :width
					-- AND price.height = :height
					-- AND sc.option1 = :option1
					-- AND sc.option2 = :option2
					-- ...

					-- PRODUCT
					AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
					-- MODEL
					AND m.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
				ORDER BY sc.selling_code ASC
			)
			SELECT
				dh.def_value3 AS louver_description_extra
				, CONCAT(
					COALESCE(tb.selling_code, '')
					-- color_code_price rule
					, CASE 
						WHEN tb.product_id IN (8) -- Carport
							THEN ''
						WHEN tb.product_id IN (9) AND (tb.spec35 IS NOT NULL OR tb.spec36 IS NOT NULL) -- Hanging door
							THEN ''
						ELSE
							COALESCE(tb.color_code_price, '')
					END
					-- Glass code rule
					, CASE
						WHEN tb.product_id IN (8) -- Carport
							THEN ''
						WHEN tb.product_id IN (9) AND (tb.spec35 IS NOT NULL OR tb.spec36 IS NOT NULL) -- Hanging door
							THEN ''
						WHEN tb.ctg_id IN (2,3) OR tb.m_model_id IN (54,55)
							THEN 'Z'
						ELSE 'A'
					END
					, CASE
						WHEN fence.def_value IS NOT NULL AND fence_spec.def_value1 = 'POLE' -- fence pole
							THEN '' -- Không hiển thị W
						WHEN gate.def_value IS NOT NULL AND gate_spec.def_value1 = 'GATE POLE' -- GATE POLE
							THEN '' -- Không hiển thị W
						WHEN -- Add BP_O2OQ-9 MinhVnit 20200903
							(
								tb.product_id IN (6) -- Exterior series
								AND tb.m_model_id IN (63, 64) -- New Swing gate(Single), New Swing gate(double)
								AND tb.spec27 IN ('27.2', '27.10') -- GATE POLE, DOOR STOP
							)
							THEN '' -- Không hiển thị W
						ELSE
							COALESCE(LPAD(tb.width,4,0), '')
					END
					, CASE
						WHEN dh1.def_value1 IS NOT NULL
							THEN COALESCE(LPAD(
								CEIL((tb.height/dh1.def_value1)/100) * 100 -- Convert 1622 -> 1700
							,4,0), '')
						ELSE
							COALESCE(LPAD(tb.height,4,0), '')
					END
				) AS order_no
				, dh1.def_value1 AS stack_number -- Xác định rule chia stack
				, CEIL((tb.height/dh1.def_value1)/100) * 100 AS stack_height -- Convert 1622 -> 1700
				, fence_spec.def_value1 AS fence_type
				, gate_spec.def_value1 AS gate_type
				, CASE
					WHEN panel.def_value IS NOT NULL AND panel_spec.def_value IS NOT NULL
						THEN 'EXTERIOR_PANEL'
					WHEN panel.def_value IS NOT NULL AND panel_spec.def_value IS NULL
						THEN 'EXTERIOR_POLE'
					ELSE
						NULL
				END AS exterior_panel_type
				, tb.*
			FROM tb
			LEFT JOIN m_define_hardcode AS dh
				ON
					dh.del_flg = 0
					AND dh.column_name = 'm_model_id'
					AND dh.def_name = 'louver_setting'
					AND dh.def_value =tb.m_model_id
					AND tb.width >= dh.def_value1
					AND tb.width <= dh.def_value2
			LEFT JOIN m_define_hardcode AS dh1
				ON
					dh1.del_flg = 0
					AND dh1.column_name = 'spec15'
					AND dh1.def_name = 'corner_fixed_stack'
					AND dh1.def_value = tb.spec15
			LEFT JOIN m_define_hardcode AS fence
				ON
					fence.del_flg = 0
					AND fence.column_name = 'm_model_id'
					AND fence.def_name = 'fence_setting'
					AND fence.def_value = tb.m_model_id
			LEFT JOIN m_define_hardcode AS fence_spec
				ON
					fence_spec.del_flg = 0
					AND fence_spec.column_name = 'spec27'
					AND fence_spec.def_name = 'fence_setting'
					AND fence_spec.def_value = tb.spec27
			LEFT JOIN m_define_hardcode AS gate
				ON
					gate.del_flg = 0
					AND gate.column_name = 'm_model_id'
					AND gate.def_name = 'gate_setting'
					AND gate.def_value = tb.m_model_id
			LEFT JOIN m_define_hardcode AS gate_spec
				ON
					gate_spec.del_flg = 0
					AND gate_spec.column_name = 'spec27'
					AND gate_spec.def_name = 'gate_setting'
					AND gate_spec.def_value = tb.spec27
			LEFT JOIN m_define_hardcode AS panel
				ON
					panel.del_flg = 0
					AND panel.column_name = 'ctg_id'
					AND panel.def_name = 'panel_setting_display_w_h'
					AND panel.def_value = tb.ctg_id
			LEFT JOIN m_define_hardcode AS panel_spec
				ON
					panel_spec.del_flg = 0
					AND panel_spec.column_name = 'spec27'
					AND panel_spec.def_name = 'panel_setting_display_w_h'
					AND panel_spec.def_value = tb.spec27
			ORDER BY tb.selling_code ASC
    	",

    	'CTG' => "
    		-- SELECT CTG
			SELECT DISTINCT
				ct.ctg_id
				, ct.ctg_name
				, c.slug_name
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
			ORDER BY c.sort_order ASC
    	",

    	'PRODUCTS_2' => "
    		-- SELECT PRODUCT of Exterior (use value of SPEC1)
			SELECT DISTINCT
				p.product_id
				, p.img_path
				, p.img_name
				, pt.product_name
				, pt.product_desc
				, ct.ctg_name
				, sc.spec1
				, sst.spec_name
				, ss.sort_order
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN (
					SELECT DISTINCT tm2.product_id, tm2.m_model_id
					FROM v_product_model_refer tm2
				)  AS v
				ON
					v.product_id = p.product_id
			INNER JOIN m_model_trans AS mt
				ON
					mt.m_model_id = v.m_model_id
					AND mt.m_lang_id = l.m_lang_id
					AND mt.del_flg = 0
			INNER JOIN m_model AS m
				ON
					m.m_model_id = mt.m_model_id
					AND m.del_flg = 0
			INNER JOIN m_color_model AS clm
				ON
					clm.m_model_id = m.m_model_id
					AND clm.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_color_id = clm.m_color_id
					AND colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_model_spec AS ms
				ON
					ms.m_model_id = m.m_model_id
					AND ms.del_flg = 0
			INNER JOIN (
					SELECT DISTINCT tmp1.product_id,tmp1.spec1
					FROM m_selling_code tmp1
					WHERE tmp1.del_flg = 0
				) AS sc
				ON
					sc.product_id = v.product_id
			INNER JOIN m_selling_spec AS ss
				ON
					ss.spec_code = sc.spec1
					AND ss.m_spec_group_id = 1
					AND ss.del_flg = 0
			INNER JOIN m_selling_spec_trans AS sst
				ON
					sst.del_flg = 0
					AND sst.m_lang_id = l.m_lang_id
					AND sst.spec_code = ss.spec_code
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				-- PRODUCT
				AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
				-- MODEL
				AND m.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
			ORDER BY p.sort_order ASC, ss.sort_order ASC
    	",

        'PRODUCTS' => "
            -- SELECT PRODUCTS
            SELECT DISTINCT
                p.product_id
                , p.img_path
                , p.img_name
                , pt.product_name
                , pt.product_desc
                , ct.ctg_name
                , p.readonly_flg
            FROM m_lang AS l
            INNER JOIN ctg_trans AS ct
                ON
                    l.m_lang_id = ct.m_lang_id
                    AND ct.del_flg = 0
            INNER JOIN ctg AS c
                ON
                    c.ctg_id = ct.ctg_id
                    AND c.del_flg = 0
                    AND c.ctg_type = 'prod'
            INNER JOIN product_trans AS pt
                ON
                    l.m_lang_id = pt.m_lang_id
                    AND pt.del_flg = 0
            INNER JOIN product AS p
                ON
                    p.product_id = pt.product_id
                    AND p.ctg_prod_id = c.ctg_id
                    AND p.del_flg = 0
                    AND p.readonly_flg = 0
            WHERE
                l.del_flg = 0
                AND l.lang_code = COALESCE(:lang_code, 'en')
                AND c.ctg_id = :ctg_id
                -- PRODUCT
                AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
            ORDER BY p.sort_order ASC
        ",

        'MODELS_2' => "
        	-- SELECT MODEL of Exterior (use value of SPEC1)
			SELECT DISTINCT
				m.m_model_id
				, p.product_id
				, clm.img_path
                , LOWER(clm.img_name) AS img_name
				, clm.m_color_id AS m_color_id_default
				, COALESCE(mt1.model_name, mt.model_name) AS model_name_display
				, pt.product_name
				, ct.ctg_name AS ctg_product
				, m.sort_order
				, sc.spec1
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN v_product_model_refer AS v
				ON
					v.product_id = p.product_id
			INNER JOIN m_model_trans AS mt
				ON
					mt.m_model_id = v.m_model_id
					AND mt.m_lang_id = l.m_lang_id
					AND mt.del_flg = 0
			INNER JOIN m_model AS m
				ON
					m.m_model_id = mt.m_model_id
					AND m.del_flg = 0
			LEFT JOIN m_model_trans AS mt1
				ON
					mt1.product_id = p.product_id
					AND mt1.m_lang_id = l.m_lang_id
					AND mt1.m_model_id = m.m_model_id
					AND mt1.del_flg = 0
			LEFT JOIN m_color_model AS clm
				ON
					clm.m_model_id = m.m_model_id
					AND clm.img_default_flg  = 1
					AND clm.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_color_id = clm.m_color_id
					AND colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_model_spec AS ms
				ON
					ms.m_model_id = m.m_model_id
					AND ms.del_flg = 0
			INNER JOIN m_selling_code AS sc
				ON
					sc.m_selling_code_id = v.m_selling_code_id
					AND sc.product_id = v.product_id
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND mt.product_id IS NULL
				AND sc.spec1 = :spec1
				-- PRODUCT
				AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
				-- MODEL
				AND m.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
			ORDER BY m.sort_order ASC
        ",

        'MODELS' => "
            -- SELECT MODEL
            SELECT DISTINCT
                m.m_model_id
                , p.product_id
                , CASE
					WHEN p.product_id = 10 THEN CONCAT(clm.img_path,'/atis')
                    WHEN p.product_id = 1 THEN CONCAT(clm.img_path,'/we_plus')
                    WHEN p.product_id = 2 THEN CONCAT(clm.img_path,'/we_70')
                    WHEN p.product_id = 3 THEN CONCAT(clm.img_path,'/we_40')
					ELSE clm.img_path
				END AS img_path
                , LOWER(clm.img_name) AS img_name
                , clm.m_color_id AS m_color_id_default
                , COALESCE(mt1.model_name, mt.model_name) AS model_name_display
                , pt.product_name
                , ct.ctg_name AS ctg_product
                , m.sort_order
                , sc.spec1
            FROM m_lang AS l
            INNER JOIN ctg_trans AS ct
                ON
                    l.m_lang_id = ct.m_lang_id
                    AND ct.del_flg = 0
            INNER JOIN ctg AS c
                ON
                    c.ctg_id = ct.ctg_id
                    AND c.del_flg = 0
                    AND c.ctg_type = 'prod'
            INNER JOIN product_trans AS pt
                ON
                    l.m_lang_id = pt.m_lang_id
                    AND pt.del_flg = 0
            INNER JOIN product AS p
                ON
                    p.product_id = pt.product_id
                    AND p.ctg_prod_id = c.ctg_id
                    AND p.del_flg = 0
                    AND p.readonly_flg = 0
            INNER JOIN v_product_model_refer AS v
                ON
                    v.product_id = p.product_id
            INNER JOIN m_model_trans AS mt
                ON
                    mt.m_model_id = v.m_model_id
                    AND mt.m_lang_id = l.m_lang_id
                    AND mt.del_flg = 0
            INNER JOIN m_model AS m
                ON
                    m.m_model_id = mt.m_model_id
                    AND m.del_flg = 0
            INNER JOIN m_selling_code AS sc
				ON
					sc.m_selling_code_id = v.m_selling_code_id
					AND sc.product_id = v.product_id
            LEFT JOIN m_model_trans AS mt1
				ON
					mt1.product_id = p.product_id
					AND mt1.m_lang_id = l.m_lang_id
					AND mt1.m_model_id = m.m_model_id
					AND mt1.del_flg = 0
			LEFT JOIN m_color_model AS clm
				ON
					clm.m_model_id = m.m_model_id
					AND IF(p.product_id = 10, clm.m_color_id = 2, clm.img_default_flg = 1) -- Edit If ATIS default image silver BP_O2OQ-29 MinhVnit 20211112
					AND clm.del_flg = 0
            WHERE
                l.del_flg = 0
                AND l.lang_code = COALESCE(:lang_code, 'en')
                AND c.ctg_id = :ctg_id
                AND p.product_id = :product_id
                AND mt.product_id IS NULL
                -- PRODUCT
                AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
                -- MODEL
                AND m.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
            ORDER BY m.sort_order ASC
        ",

        'CATEGORY' => "
            -- SELECT CTG
            SELECT DISTINCT
				ct.ctg_id
				, ct.ctg_name
				, c.slug_name
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
				AND c.slug_name = :ctg_slug
			ORDER BY c.sort_order ASC
        ",

        'CELLING_CODE_OPTION' => "
        	-- GET SELLING_CODE OF OPTIONS
        	SELECT DISTINCT
        		TRIM(COALESCE(CONCAT(COALESCE(ct.ctg_name, ''), ' ', sst_op3.spec_name), ct.ctg_name)) AS series_name,
        		CASE
        			WHEN op.option_ctg_spec_id IN (34, 77, 79) -- Insect screen + Flat sill attachment
        				THEN CONCAT(
        					COALESCE(REPLACE(op.selling_code, cc.special_character, cc.replace_code), op.selling_code)
        						, COALESCE(mc.color_code_price,
        								(SELECT mc_tmp.color_code_price FROM m_color mc_tmp WHERE mc_tmp.m_color_id = :m_color_id AND mc_tmp.del_flg = 0)
        							),
        						 -- Glass code rule
        						 'Z', COALESCE(LPAD(op_price.width,4,0), ''), COALESCE(LPAD(op_price.height,4,0), '')
        					)
        			ELSE
        				COALESCE(REPLACE(op.selling_code, cc.special_character, cc.replace_code), op.selling_code)
        		END AS order_no,
				-- mct.color_name,
				-- cc.special_character,
				-- cc.replace_code,
				COALESCE(REPLACE(op.selling_code, cc.special_character, cc.replace_code), op.selling_code) AS selling_code,
				-- op.*,
				COALESCE(op_price.amount, 0) AS amount -- option insect thì lấy trong bảng giá chính
				, r.number_of_option -- number_of_option = 1 hoặc NULL thì đều là giữ nguyên không dup option
        	FROM m_lang AS m
			INNER JOIN ctg_trans AS ct
				ON
					ct.m_lang_id = m.m_lang_id
				 	AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					ct.ctg_id = c.ctg_id
					AND c.ctg_type = 'spec'
					AND c.del_flg = 0
			INNER JOIN m_option_selling_code AS op
				ON
					op.option_ctg_spec_id = c.ctg_id
					AND op.del_flg = 0
			INNER JOIN m_selling_code AS sc
				ON
					(op.product_id IS NULL OR sc.product_id = op.product_id )
					AND (op.spec1 IS NULL OR sc.spec1 = op.spec1 )
					AND ( op.spec2 IS NULL OR sc.spec2 = op.spec2 )
					AND ( op.spec3 IS NULL OR sc.spec3 = op.spec3 )
					AND ( op.spec4 IS NULL OR sc.spec4 = op.spec4 )
					AND ( op.spec5 IS NULL OR sc.spec5 = op.spec5 )
					AND ( op.spec6 IS NULL OR sc.spec6 = op.spec6 )
					AND ( op.spec7 IS NULL OR sc.spec7 = op.spec7 )
					AND ( op.spec8 IS NULL OR sc.spec8 = op.spec8 )
					AND ( op.spec9 IS NULL OR sc.spec9 = op.spec9 )
					AND ( op.spec10 IS NULL OR sc.spec10 = op.spec10 )
					AND ( op.spec11 IS NULL OR sc.spec11 = op.spec11 )
					AND ( op.spec12 IS NULL OR sc.spec12 = op.spec12 )
					AND ( op.spec13 IS NULL OR sc.spec13 = op.spec13 )
					AND ( op.spec14 IS NULL OR sc.spec14 = op.spec14 )
					AND ( op.spec15 IS NULL OR sc.spec15 = op.spec15 )
					AND ( op.spec16 IS NULL OR sc.spec16 = op.spec16 )
					AND ( op.spec17 IS NULL OR sc.spec17 = op.spec17 )
					AND ( op.spec18 IS NULL OR sc.spec18 = op.spec18 )
					AND ( op.spec19 IS NULL OR sc.spec19 = op.spec19 )
					AND ( op.spec20 IS NULL OR sc.spec20 = op.spec20 )
					AND ( op.spec21 IS NULL OR sc.spec21 = op.spec21 )
					AND ( op.spec22 IS NULL OR sc.spec22 = op.spec22 )
					AND ( op.spec23 IS NULL OR sc.spec23 = op.spec23 )
					AND ( op.spec24 IS NULL OR sc.spec24 = op.spec24 )
					AND ( op.spec25 IS NULL OR sc.spec25 = op.spec25 )
					AND ( op.spec26 IS NULL OR sc.spec26 = op.spec26 )
					AND ( op.spec27 IS NULL OR sc.spec27 = op.spec27 )
					AND ( op.spec28 IS NULL OR sc.spec28 = op.spec28 )
					AND ( op.spec29 IS NULL OR sc.spec29 = op.spec29 )
					AND ( op.spec30 IS NULL OR sc.spec30 = op.spec30 )
					AND ( op.spec31 IS NULL OR sc.spec31 = op.spec31 )
					AND ( op.spec32 IS NULL OR sc.spec32 = op.spec32 ) -- Add BP_O2OQ-6 MinhVnit 20200625
					AND ( op.spec33 IS NULL OR sc.spec33 = op.spec33 ) -- Add BP_O2OQ-6 MinhVnit 20200625
					AND ( op.spec34 IS NULL OR sc.spec34 = op.spec34 ) -- Add BP_O2OQ-6 MinhVnit 20200625
					-- AND ( op.spec35 IS NULL OR sc.spec35 = op.spec35 ) -- Add BP_O2OQ-6 MinhVnit 20200710 Thêm cho đủ tụ vì trong table option chưa có thêm
					-- AND ( op.spec36 IS NULL OR sc.spec36 = op.spec36 ) -- Add BP_O2OQ-6 MinhVnit 20200710 Thêm cho đủ tụ vì trong table option chưa có thêm
					AND ( op.spec37 IS NULL OR sc.spec37 = op.spec37 ) -- Add BP_O2OQ-9 MinhVnit 20200901
					AND ( op.spec39 IS NULL OR sc.spec39 = op.spec39 ) -- Add BP_O2OQ-27 MinhVnit 20210907
					AND ( op.spec42 IS NULL OR sc.spec42 = op.spec42 ) -- Added by Anlu 20240213
					AND sc.del_flg = 0
			LEFT JOIN option_selling_code_price AS op_price
				ON
					op_price.design = op.selling_code
			LEFT JOIN m_color_trans AS mct
				ON
					mct.m_lang_id = m.m_lang_id
					AND mct.m_color_id = op.m_color_id
					AND mct.del_flg = 0
			LEFT JOIN m_color AS mc
				ON
					mc.del_flg = 0
					AND op.m_color_id = mc.m_color_id
			LEFT JOIN m_special_color_code AS cc
				ON
					cc.del_flg = 0
					AND op.selling_code LIKE BINARY CONCAT('%', cc.special_character, '%')
					AND cc.m_color_id = :m_color_id
			LEFT JOIN m_selling_spec AS ss_op3
				ON
					ss_op3.del_flg = 0
					AND ss_op3.m_spec_group_id = 'o3'
					AND ss_op3.spec_code = op.option3
			LEFT JOIN m_selling_spec_trans AS sst_op3
				ON
					sst_op3.del_flg = 0
					AND ss_op3.spec_code = sst_op3.spec_code
					AND sst_op3.m_lang_id = m.m_lang_id
			LEFT JOIN m_rail AS r
				ON
					r.del_flg = 0
					AND r.option3 = op.option3
					AND (r.min_width IS NULL OR r.min_width <= :width)
					AND (r.max_width IS NULL OR r.max_width >= :width)
					AND r.m_model_id = :m_model_id
			WHERE
				m.del_flg = 0
				AND m.lang_code = COALESCE(:lang_code, 'en')
				AND ( op.product_id IS NULL OR op.product_id = :product_id )
				AND (op.m_color_id IS NULL OR op.m_color_id = :m_color_id)
				AND (op_price.width IS NULL OR op_price.width = :width)
				AND (op_price.height IS NULL OR op_price.height = :height)
        ",

		'SELECT_MODEL_ITEM_DISPLAY' => "
			-- SELECT_MODEL_ITEM_DISPLAY
			SELECT DISTINCT
				idisp.m_model_id
				, it.item_display_name
				, idisp.spec1
				, idisp.spec2
				, idisp.spec3
				, idisp.spec4
				, idisp.spec5
				, idisp.spec6
				, idisp.spec7
				, idisp.spec8
				, idisp.spec9
				, idisp.spec10
				, idisp.spec11
				, idisp.spec12
				, idisp.spec13
				, idisp.spec14
				, idisp.spec15
				, idisp.spec16
				, idisp.spec17
				, idisp.spec18
				, idisp.spec19
				, idisp.spec20
				, idisp.spec21
				, idisp.spec22
				, idisp.spec23
				, idisp.spec24
				, idisp.spec25
				, idisp.spec26
				, idisp.spec27
				, idisp.spec28
				, idisp.spec29
				, idisp.spec30
				, idisp.spec31
				, idisp.spec32 -- Add BP_O2OQ-6 MinhVnit 20200625
				, idisp.spec33 -- Add BP_O2OQ-6 MinhVnit 20200625
				, idisp.spec34 -- Add BP_O2OQ-6 MinhVnit 20200625
				, idisp.spec35 -- Add BP_O2OQ-6 MinhVnit 20200710 
				, idisp.spec36 -- Add BP_O2OQ-6 MinhVnit 20200710 
				, idisp.spec37 -- Add BP_O2OQ-9 MinhVnit 20200901
				, idisp.spec38 -- Add BP_O2OQ-27 MinhVnit 20210823
				, idisp.spec39 -- Add BP_O2OQ-27 MinhVnit 20210823
				, idisp.spec40 -- Add BP_O2OQ-27 MinhVnit 20210823
				, idisp.spec41 -- Add BP_O2OQ-29 MinhVnit 20211103
			FROM m_lang AS l
			INNER JOIN m_model_item_trans AS it
				ON
					it.del_flg = 0
					AND it.m_lang_id = l.m_lang_id
			INNER JOIN m_model_item_display AS idisp
				ON
					idisp.del_flg = 0
					AND idisp.m_model_item_id = it.m_model_item_id
			INNER JOIN m_model_item AS i
				ON
					i.del_flg = 0
					AND i.m_model_item_id = idisp.m_model_item_id
			INNER JOIN v_product_model_refer AS v
					ON
						v.m_model_id = idisp.m_model_id
						
			INNER JOIN m_selling_code AS sc
					ON
						(v.product_id IS NULL OR sc.product_id = v.product_id)
						AND (idisp.spec1 IS NULL OR sc.spec1 = idisp.spec1 )
						AND (idisp.spec2 IS NULL OR sc.spec2 = idisp.spec2 )
						AND (idisp.spec3 IS NULL OR sc.spec3 = idisp.spec3 )
						AND (idisp.spec4 IS NULL OR sc.spec4 = idisp.spec4 )
						AND (idisp.spec5 IS NULL OR sc.spec5 = idisp.spec5 )
						AND (idisp.spec6 IS NULL OR sc.spec6 = idisp.spec6 )
						AND (idisp.spec7 IS NULL OR sc.spec7 = idisp.spec7 )
						AND (idisp.spec8 IS NULL OR sc.spec8 = idisp.spec8 )
						AND (idisp.spec9 IS NULL OR sc.spec9 = idisp.spec9 )
						AND (idisp.spec10 IS NULL OR sc.spec10 = idisp.spec10 )
						AND (idisp.spec11 IS NULL OR sc.spec11 = idisp.spec11 )
						AND (idisp.spec12 IS NULL OR sc.spec12 = idisp.spec12 )
						AND (idisp.spec13 IS NULL OR sc.spec13 = idisp.spec13 )
						AND (idisp.spec14 IS NULL OR sc.spec14 = idisp.spec14 )
						AND (idisp.spec15 IS NULL OR sc.spec15 = idisp.spec15 )
						AND (idisp.spec16 IS NULL OR sc.spec16 = idisp.spec16 )
						AND (idisp.spec17 IS NULL OR sc.spec17 = idisp.spec17 )
						AND (idisp.spec18 IS NULL OR sc.spec18 = idisp.spec18 )
						AND (idisp.spec19 IS NULL OR sc.spec19 = idisp.spec19 )
						AND (idisp.spec20 IS NULL OR sc.spec20 = idisp.spec20 )
						AND (idisp.spec21 IS NULL OR sc.spec21 = idisp.spec21 )
						AND (idisp.spec22 IS NULL OR sc.spec22 = idisp.spec22 )
						AND (idisp.spec23 IS NULL OR sc.spec23 = idisp.spec23 )
						AND (idisp.spec24 IS NULL OR sc.spec24 = idisp.spec24 )
						AND (idisp.spec25 IS NULL OR sc.spec25 = idisp.spec25 )
						AND (idisp.spec26 IS NULL OR sc.spec26 = idisp.spec26 )
						AND (idisp.spec27 IS NULL OR sc.spec27 = idisp.spec27 )
						AND (idisp.spec28 IS NULL OR sc.spec28 = idisp.spec28 )
						AND (idisp.spec29 IS NULL OR sc.spec29 = idisp.spec29 )
						AND (idisp.spec30 IS NULL OR sc.spec30 = idisp.spec30 )
						AND (idisp.spec31 IS NULL OR sc.spec31 = idisp.spec31 )
						AND (idisp.spec32 IS NULL OR sc.spec32 = idisp.spec32 )
						AND (idisp.spec33 IS NULL OR sc.spec33 = idisp.spec33 )
						AND (idisp.spec34 IS NULL OR sc.spec34 = idisp.spec34 )
						AND (idisp.spec35 IS NULL OR sc.spec35 = idisp.spec35 )
						AND (idisp.spec36 IS NULL OR sc.spec36 = idisp.spec36 )
						AND (idisp.spec37 IS NULL OR sc.spec37 = idisp.spec37 )
						AND (idisp.spec38 IS NULL OR sc.spec38 = idisp.spec38 )
						AND (idisp.spec39 IS NULL OR sc.spec39 = idisp.spec39 )
						AND (idisp.spec40 IS NULL OR sc.spec40 = idisp.spec40 )
						AND (idisp.spec41 IS NULL OR sc.spec41 = idisp.spec41 )
						AND (idisp.spec42 IS NULL OR sc.spec42 = idisp.spec42 )
						AND (idisp.spec43 IS NULL OR sc.spec43 = idisp.spec43 )
						AND (idisp.spec44 IS NULL OR sc.spec44 = idisp.spec44 )
						AND (idisp.spec45 IS NULL OR sc.spec45 = idisp.spec45 )
						AND (idisp.spec46 IS NULL OR sc.spec46 = idisp.spec46 )
						AND (idisp.spec47 IS NULL OR sc.spec47 = idisp.spec47 )
						AND (idisp.spec48 IS NULL OR sc.spec48 = idisp.spec48 )
						AND (idisp.spec49 IS NULL OR sc.spec49 = idisp.spec49 )
						AND (idisp.spec50 IS NULL OR sc.spec50 = idisp.spec50 )
						AND (idisp.spec51 IS NULL OR sc.spec51 = idisp.spec51 )
						AND (idisp.spec52 IS NULL OR sc.spec52 = idisp.spec52 )
						AND (idisp.spec53 IS NULL OR sc.spec53 = idisp.spec53 )
						AND (idisp.spec54 IS NULL OR sc.spec54 = idisp.spec54 )
						AND (idisp.spec55 IS NULL OR sc.spec55 = idisp.spec55 )
						AND (idisp.spec56 IS NULL OR sc.spec56 = idisp.spec56 )
						AND (idisp.spec57 IS NULL OR sc.spec57 = idisp.spec57 )
						AND (idisp.spec58 IS NULL OR sc.spec58 = idisp.spec58 )
						AND (idisp.spec59 IS NULL OR sc.spec59 = idisp.spec59 )
						AND (idisp.spec60 IS NULL OR sc.spec60 = idisp.spec60 )
						AND (idisp.spec61 IS NULL OR sc.spec61 = idisp.spec61 )
						AND (idisp.spec62 IS NULL OR sc.spec62 = idisp.spec62 )
						AND (idisp.spec63 IS NULL OR sc.spec63 = idisp.spec63 )
						AND (idisp.spec64 IS NULL OR sc.spec64 = idisp.spec64 )
						AND (idisp.spec65 IS NULL OR sc.spec65 = idisp.spec65 )
						AND (idisp.spec66 IS NULL OR sc.spec66 = idisp.spec66 )
						AND (idisp.spec67 IS NULL OR sc.spec67 = idisp.spec67 )
						AND (idisp.spec68 IS NULL OR sc.spec68 = idisp.spec68 )
						AND (idisp.spec69 IS NULL OR sc.spec69 = idisp.spec69 )
						AND (idisp.spec70 IS NULL OR sc.spec70 = idisp.spec70 )
						AND (idisp.spec71 IS NULL OR sc.spec71 = idisp.spec71 )
						AND (idisp.spec72 IS NULL OR sc.spec72 = idisp.spec72 )
						AND (idisp.spec73 IS NULL OR sc.spec73 = idisp.spec73 )
						AND (idisp.spec74 IS NULL OR sc.spec74 = idisp.spec74 )
						AND (idisp.spec75 IS NULL OR sc.spec75 = idisp.spec75 )
						AND (idisp.spec76 IS NULL OR sc.spec76 = idisp.spec76 )
						AND (idisp.spec77 IS NULL OR sc.spec77 = idisp.spec77 )
						AND (idisp.spec78 IS NULL OR sc.spec78 = idisp.spec78 )
						AND (idisp.spec79 IS NULL OR sc.spec79 = idisp.spec79 )
						AND (idisp.spec80 IS NULL OR sc.spec80 = idisp.spec80 )
						AND (idisp.spec81 IS NULL OR sc.spec81 = idisp.spec81 )
						AND (idisp.spec82 IS NULL OR sc.spec82 = idisp.spec82 )
						AND (idisp.spec83 IS NULL OR sc.spec83 = idisp.spec83 )
						AND (idisp.spec84 IS NULL OR sc.spec84 = idisp.spec84 )
						AND (idisp.spec85 IS NULL OR sc.spec85 = idisp.spec85 )
						AND (idisp.spec86 IS NULL OR sc.spec86 = idisp.spec86 )
						AND (idisp.spec87 IS NULL OR sc.spec87 = idisp.spec87 )
						AND (idisp.spec88 IS NULL OR sc.spec88 = idisp.spec88 )
						AND (idisp.spec89 IS NULL OR sc.spec89 = idisp.spec89 )
						AND (idisp.spec90 IS NULL OR sc.spec90 = idisp.spec90 )
						AND (idisp.spec91 IS NULL OR sc.spec91 = idisp.spec91 )
						AND (idisp.spec92 IS NULL OR sc.spec92 = idisp.spec92 )
						AND (idisp.spec93 IS NULL OR sc.spec93 = idisp.spec93 )
						AND (idisp.spec94 IS NULL OR sc.spec94 = idisp.spec94 )
						AND (idisp.spec95 IS NULL OR sc.spec95 = idisp.spec95 )
						AND (idisp.spec96 IS NULL OR sc.spec96 = idisp.spec96 )
						AND (idisp.spec97 IS NULL OR sc.spec97 = idisp.spec97 )
						AND (idisp.spec98 IS NULL OR sc.spec98 = idisp.spec98 )
						AND (idisp.spec99 IS NULL OR sc.spec99 = idisp.spec99 )
						AND (idisp.spec100 IS NULL OR sc.spec100 = idisp.spec100 )

						AND sc.del_flg = 0
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND idisp.m_model_id = :m_model_id
				AND v.product_id = :product_id
			ORDER BY i.sort_order ASC
		",

		//START SQL GIESTA

		'MODELS_GIESTA' => "
            -- MODELS_GIESTA
            SELECT DISTINCT
                m.m_model_id
                , p.product_id
                , clm.img_path
                , LOWER(clm.img_name) AS img_name
                , clm.m_color_id AS m_color_id_default
                , COALESCE(mt1.model_name, mt.model_name) AS model_name_display
                , pt.product_name
                , ct.ctg_name AS ctg_product
                , m.sort_order
            FROM m_lang AS l
            INNER JOIN ctg_trans AS ct
                ON
                    l.m_lang_id = ct.m_lang_id
                    AND ct.del_flg = 0
            INNER JOIN ctg AS c
                ON
                    c.ctg_id = ct.ctg_id
                    AND c.del_flg = 0
                    AND c.ctg_type = 'prod'
            INNER JOIN product_trans AS pt
                ON
                    l.m_lang_id = pt.m_lang_id
                    AND pt.del_flg = 0
            INNER JOIN product AS p
                ON
                    p.product_id = pt.product_id
                    AND p.ctg_prod_id = c.ctg_id
                    AND p.del_flg = 0
            INNER JOIN v_product_giesta_model_refer AS v
                ON
                    v.product_id = p.product_id
            INNER JOIN m_model_trans AS mt
                ON
                    mt.m_model_id = v.m_model_id
                    AND mt.m_lang_id = l.m_lang_id
                    AND mt.del_flg = 0
            INNER JOIN m_model AS m
                ON
                    m.m_model_id = mt.m_model_id
                    AND m.del_flg = 0
            LEFT JOIN m_model_trans AS mt1
				ON
					mt1.product_id = p.product_id
					AND mt1.m_lang_id = l.m_lang_id
					AND mt1.m_model_id = m.m_model_id
					AND mt1.del_flg = 0
			LEFT JOIN m_color_model AS clm
				ON
					clm.m_model_id = m.m_model_id
					AND clm.img_default_flg  = 1
					AND clm.del_flg = 0
            WHERE
                l.del_flg = 0
                AND l.lang_code = COALESCE(:lang_code, 'en')
                AND c.ctg_id = :ctg_id
                AND p.product_id = :product_id
                AND mt.product_id IS NULL
                -- PRODUCT
                AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
                -- MODEL
                AND m.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
            ORDER BY m.sort_order ASC
        ",

        'SELECT_GIESTA_MODEL_ITEM_DISPLAY' => "
			-- SELECT_MODEL_ITEM_DISPLAY
			SELECT DISTINCT
				idisp.m_model_id
				, it.item_display_name
				, idisp.spec51
				, idisp.spec52
				, idisp.spec53
				, idisp.spec54
				, idisp.spec55
				, idisp.spec56
				, idisp.spec57
			FROM m_lang AS l
			INNER JOIN m_model_item_trans AS it
				ON
					it.del_flg = 0
					AND it.m_lang_id = l.m_lang_id
			INNER JOIN m_model_item_display AS idisp
				ON
					idisp.del_flg = 0
					AND idisp.m_model_item_id = it.m_model_item_id
			INNER JOIN m_model_item AS i
				ON
					i.del_flg = 0
					AND i.m_model_item_id = idisp.m_model_item_id
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND idisp.m_model_id = :m_model_id
			ORDER BY i.sort_order ASC
		",

		"SELECT_MAIN_PANEL_GIESTA" => "
			-- SELECT_MAIN_PANEL_GIESTA
			SELECT DISTINCT
				m.m_model_id
				, l.lang_code
				, c.ctg_id
				, p.product_id
				, COALESCE(mt1.model_name, mt.model_name) AS model_name_display
				, TRIM(CONCAT(COALESCE(pt.product_name, ''), ' ', COALESCE(mt1.model_name, mt.model_name))) AS series_name
				-- Glass code rule
				, CONCAT(COALESCE(sc.selling_code, ''), COALESCE(color.color_code_price, ''), IF(ct.ctg_id IN (2,3),'Z','A'), COALESCE(LPAD(price.width,4,0), ''), COALESCE(LPAD(price.height,4,0), '')) AS order_no
				, pt.product_name
				, p.viewer_flg AS p_viewer_flg
				, m.viewer_flg AS m_viewer_flg
				, clm.img_path AS img_path_result
				, LOWER(clm.img_name) AS img_name_result
				, colortr.m_color_id
				, colortr.color_name
				, color.color_code_price
				, ccp.img_path
				, LOWER(ccp.img_name) AS img_name
				, sc.selling_code
				, sc.spec51
				, si.img_path AS img_path_spec51
				, si.img_name AS img_name_spec51
				, sc.spec53
				, sc.spec54
				, sc.spec55
				, sc.spec52
				, sc.spec56
				, sc.spec57
				, price.width
				, price.height
				, price.amount
				, 0 AS hidden_storage_flg
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN v_product_giesta_model_refer AS v
				ON
					v.product_id = p.product_id
			INNER JOIN m_model_trans AS mt
				ON
					mt.m_model_id = v.m_model_id
					AND mt.m_lang_id = l.m_lang_id
					AND mt.del_flg = 0
			INNER JOIN m_model AS m
				ON
					m.m_model_id = mt.m_model_id
					AND m.del_flg = 0
			LEFT JOIN m_model_trans AS mt1
				ON
					mt1.product_id = p.product_id
					AND mt1.m_lang_id = l.m_lang_id
					AND mt1.m_model_id = m.m_model_id
					AND mt1.del_flg = 0
			INNER JOIN m_color_ctg_prod AS ccp
				ON
					ccp.ctg_prod_id = c.ctg_id
					AND ccp.del_flg = 0
			INNER JOIN m_color_model AS clm
				ON
					clm.m_model_id = m.m_model_id
					AND clm.m_color_id = ccp.m_color_id
					AND clm.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_color_id = clm.m_color_id
					AND colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_model_spec AS ms
				ON
					ms.m_model_id = m.m_model_id
					AND ms.del_flg = 0
			INNER JOIN m_selling_code_giesta AS sc
				ON
					sc.m_selling_code_giesta_id = v.m_selling_code_giesta_id
					AND sc.product_id = v.product_id
					AND sc.ctg_part_id = 42 -- Main Panel
			INNER JOIN v_product_price_giesta_refer AS price
				ON
					price.design = sc.selling_code
					AND (
						-- chỉ có GIESTA mới có value Special
						-- còn lại đều là blank
						(
							p.product_id IN (5)
								AND (
									(price.special IS NULL AND color.color_code_price IN ('B', 'C', 'D', 'F'))
									OR color.color_code_price = price.special
								)
						) -- GIESTA
						-- OR (price.special IS NULL)
					)
			LEFT JOIN m_spec_image AS si
				ON
					si.del_flg = 0
					AND si.product_id = p.product_id
					AND si.spec51 = sc.spec51
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND mt.product_id IS NULL
				AND m.m_model_id = :m_model_id
				-- AND color.m_color_id = :main_color_id
				-- AND sc.spec51 = :spec51
				-- AND sc.spec52 = :spec52
				-- AND sc.spec53 = :spec53
				-- AND sc.spec54 = :spec54
				-- AND sc.spec55 = :spec55
				-- AND sc.spec56 = :spec56
				-- AND sc.spec57 = :spec57
				-- AND sc.option4 = :option4
				-- AND price.width = :width
				-- AND price.height = :height

				-- PRODUCT
				AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
				-- MODEL
				AND m.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
			ORDER BY sc.selling_code ASC
		",

		"SELECT_FRAME_GIESTA" => "
			-- SELECT_FRAME_GIESTA
			SELECT DISTINCT
				COALESCE(mt1.model_name, mt.model_name) AS model_name_display
				, TRIM(CONCAT(COALESCE(pt.product_name, ''), ' ', COALESCE(mt1.model_name, mt.model_name))) AS series_name
				-- Glass code rule
				, CONCAT(COALESCE(sc.selling_code, ''), COALESCE(color.color_code_price, ''), IF(ct.ctg_id IN (2,3),'Z','A'), COALESCE(LPAD(price.width,4,0), ''), COALESCE(LPAD(price.height,4,0), '')) AS order_no
				, pt.product_name
				, sc.selling_code
				, sc.spec51
				, sc.spec52
				, sc.spec53
				, sc.spec54
				, sc.spec55
				, sc.spec56
				, sc.spec57
				, price.width
				, price.height
				, price.amount
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN m_model_trans AS mt
				ON
					mt.m_lang_id = l.m_lang_id
					AND mt.del_flg = 0
			INNER JOIN m_model AS m
				ON
					m.m_model_id = mt.m_model_id
					AND m.del_flg = 0
			LEFT JOIN m_model_trans AS mt1
				ON
					mt1.product_id = p.product_id
					AND mt1.m_lang_id = l.m_lang_id
					AND mt1.m_model_id = m.m_model_id
					AND mt1.del_flg = 0
			INNER JOIN m_color_ctg_prod AS ccp
				ON
					ccp.ctg_prod_id = c.ctg_id
					AND ccp.del_flg = 0
			INNER JOIN m_color_model AS clm
				ON
					clm.m_model_id = m.m_model_id
					AND clm.m_color_id = ccp.m_color_id
					AND clm.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_color_id = clm.m_color_id
					AND colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_model_spec AS ms
				ON
					ms.m_model_id = m.m_model_id
					AND ms.del_flg = 0
			INNER JOIN m_selling_code_giesta AS sc
				ON
					sc.del_flg = 0
					AND sc.product_id = p.product_id
					AND sc.ctg_part_id = 45 -- Frame
			INNER JOIN v_product_price_giesta_refer AS price
				ON
					price.design = sc.selling_code
					AND (
						-- chỉ có GIESTA mới có value Special
						-- còn lại đều là blank
						(
							p.product_id IN (5)
								AND (
									(price.special IS NULL AND color.color_code_price IN ('B', 'C', 'D', 'F'))
									OR color.color_code_price = price.special
								)
						) -- GIESTA
						-- OR (price.special IS NULL)
					)
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND mt.product_id IS NULL
				AND m.m_model_id = :m_model_id
				AND color.m_color_id = :main_color_id
				AND ( sc.spec51 IS NULL OR sc.spec51 = COALESCE(:spec51, sc.spec51) )
				AND ( sc.spec52 IS NULL OR sc.spec52 = COALESCE(:spec52, sc.spec52) ) -- (Không lọc theo column này)
				AND ( sc.spec53 IS NULL OR sc.spec53 = COALESCE(:spec53, sc.spec53) )
				AND ( sc.spec54 IS NULL OR sc.spec54 = COALESCE(:spec54, sc.spec54) )
				AND ( sc.spec55 IS NULL OR sc.spec55 = COALESCE(:spec55, sc.spec55) )
				AND ( sc.spec56 IS NULL OR sc.spec56 = COALESCE(:spec56, sc.spec56) ) -- (Không lọc theo column này)
				AND ( sc.spec57 IS NULL OR sc.spec57 = COALESCE(:spec57, sc.spec57) )
				AND price.width = COALESCE(:width, price.width)
				AND price.height = COALESCE(:height, price.height)

				-- PRODUCT
				AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
				-- MODEL
				AND m.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
			ORDER BY sc.selling_code ASC
		",

		"SELECT_SIDE_PANEL_GIESTA" => "
			-- SELECT_SIDE_PANEL_GIESTA
			SELECT DISTINCT
				COALESCE(mt1.model_name, mt.model_name) AS model_name_display
				, TRIM(CONCAT(COALESCE(pt.product_name, ''), ' ', COALESCE(mt1.model_name, mt.model_name))) AS series_name
				-- Glass code rule
				, CONCAT(COALESCE(sc.selling_code, ''), COALESCE(color.color_code_price, ''), IF(ct.ctg_id IN (2,3),'Z','A'), COALESCE(LPAD(price.width,4,0), ''), COALESCE(LPAD(price.height,4,0), '')) AS order_no
				, pt.product_name
				, sc.selling_code
				, sc.spec51
				, sc.spec52
				, sc.spec53
				, sc.spec54
				, sc.spec55
				, sc.spec56
				, sc.spec57
				, price.width
				, price.height
				, price.amount
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN m_model_trans AS mt
				ON
					mt.m_lang_id = l.m_lang_id
					AND mt.del_flg = 0
			INNER JOIN m_model AS m
				ON
					m.m_model_id = mt.m_model_id
					AND m.del_flg = 0
			LEFT JOIN m_model_trans AS mt1
				ON
					mt1.product_id = p.product_id
					AND mt1.m_lang_id = l.m_lang_id
					AND mt1.m_model_id = m.m_model_id
					AND mt1.del_flg = 0
			INNER JOIN m_color_ctg_prod AS ccp
				ON
					ccp.ctg_prod_id = c.ctg_id
					AND ccp.del_flg = 0
			INNER JOIN m_color_model AS clm
				ON
					clm.m_model_id = m.m_model_id
					AND clm.m_color_id = ccp.m_color_id
					AND clm.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_color_id = clm.m_color_id
					AND colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_model_spec AS ms
				ON
					ms.m_model_id = m.m_model_id
					AND ms.del_flg = 0
			INNER JOIN m_selling_code_giesta AS sc
				ON
					sc.del_flg = 0
					AND sc.product_id = p.product_id
					AND sc.ctg_part_id = 43 -- Side panel
			INNER JOIN v_product_price_giesta_refer AS price
				ON
					price.design = sc.selling_code
					AND (
						-- chỉ có GIESTA mới có value Special
						-- còn lại đều là blank
						(
							p.product_id IN (5)
								AND (
									(price.special IS NULL AND color.color_code_price IN ('B', 'C', 'D', 'F'))
									OR color.color_code_price = price.special
								)
						) -- GIESTA
						-- OR (price.special IS NULL)
					)
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND mt.product_id IS NULL
				AND m.m_model_id = :m_model_id
				AND color.m_color_id = :main_color_id
				AND ( sc.spec51 IS NULL OR sc.spec51 = COALESCE(:spec51, sc.spec51) )
				AND ( sc.spec52 IS NULL OR sc.spec52 = COALESCE(:spec52, sc.spec52) ) -- (Không lọc theo column này)
				AND ( sc.spec53 IS NULL OR sc.spec53 = COALESCE(:spec53, sc.spec53) )
				AND ( sc.spec54 IS NULL OR sc.spec54 = COALESCE(:spec54, sc.spec54) )
				AND ( sc.spec55 IS NULL OR sc.spec55 = COALESCE(:spec55, sc.spec55) )
				AND ( sc.spec56 IS NULL OR sc.spec56 = COALESCE(:spec56, sc.spec56) ) -- (Không lọc theo column này)
				AND ( sc.spec57 IS NULL OR sc.spec57 = COALESCE(:spec57, sc.spec57) )
				AND price.width = COALESCE(:width, price.width)
				AND price.height = COALESCE(:height, price.height)

				-- PRODUCT
				AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
				-- MODEL
				AND m.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
			ORDER BY sc.selling_code ASC
		",

		"SELECT_SUB_PANEL_GIESTA" => "
			-- SELECT_SUB_PANEL_GIESTA
			SELECT DISTINCT
				COALESCE(mt1.model_name, mt.model_name) AS model_name_display
				, TRIM(CONCAT(COALESCE(pt.product_name, ''), ' ', COALESCE(mt1.model_name, mt.model_name))) AS series_name
				-- Glass code rule
				, CONCAT(COALESCE(sc.selling_code, ''), COALESCE(color.color_code_price, ''), IF(ct.ctg_id IN (2,3),'Z','A'), COALESCE(LPAD(price.width,4,0), ''), COALESCE(LPAD(price.height,4,0), '')) AS order_no
				, pt.product_name
				, sc.selling_code
				, sc.spec51
				, sc.spec52
				, sc.spec53
				, sc.spec54
				, sc.spec55
				, sc.spec56
				, sc.spec57
				, price.width
				, price.height
				, price.amount
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN v_product_giesta_model_refer AS v
				ON
					v.product_id = p.product_id
			INNER JOIN m_model_trans AS mt
				ON
					mt.m_model_id = v.m_model_id
					AND mt.m_lang_id = l.m_lang_id
					AND mt.del_flg = 0
			INNER JOIN m_model AS m
				ON
					m.m_model_id = mt.m_model_id
					AND m.del_flg = 0
			LEFT JOIN m_model_trans AS mt1
				ON
					mt1.product_id = p.product_id
					AND mt1.m_lang_id = l.m_lang_id
					AND mt1.m_model_id = m.m_model_id
					AND mt1.del_flg = 0
			INNER JOIN m_color_ctg_prod AS ccp
				ON
					ccp.ctg_prod_id = c.ctg_id
					AND ccp.del_flg = 0
			INNER JOIN m_color_model AS clm
				ON
					clm.m_model_id = m.m_model_id
					AND clm.m_color_id = ccp.m_color_id
					AND clm.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_color_id = clm.m_color_id
					AND colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_model_spec AS ms
				ON
					ms.m_model_id = m.m_model_id
					AND ms.del_flg = 0
			INNER JOIN m_selling_code_giesta AS sc
				ON
					sc.m_selling_code_giesta_id = v.m_selling_code_giesta_id
					AND sc.product_id = v.product_id
					AND sc.ctg_part_id = 44 -- Sub panel
			INNER JOIN v_product_price_giesta_refer AS price
				ON
					price.design = sc.selling_code
					AND (
						-- chỉ có GIESTA mới có value Special
						-- còn lại đều là blank
						(
							p.product_id IN (5)
								AND (
									(price.special IS NULL AND color.color_code_price IN ('B', 'C', 'D', 'F'))
									OR color.color_code_price = price.special
								)
						) -- GIESTA
						-- OR (price.special IS NULL)
					)
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND mt.product_id IS NULL
				AND m.m_model_id = :m_model_id
				AND color.m_color_id = :main_color_id
				AND ( sc.spec51 IS NULL OR sc.spec51 = COALESCE(:spec51, sc.spec51) )
				AND ( sc.spec52 IS NULL OR sc.spec52 = COALESCE(:spec52, sc.spec52) ) -- (Không lọc theo column này)
				AND ( sc.spec53 IS NULL OR sc.spec53 = COALESCE(:spec53, sc.spec53) )
				AND ( sc.spec54 IS NULL OR sc.spec54 = COALESCE(:spec54, sc.spec54) )
				AND ( sc.spec55 IS NULL OR sc.spec55 = COALESCE(:spec55, sc.spec55) )
				AND ( sc.spec56 IS NULL OR sc.spec56 = COALESCE(:spec56, sc.spec56) )
				AND ( sc.spec57 IS NULL OR sc.spec57 = COALESCE(:spec57, sc.spec57) )
				AND price.width = COALESCE(:width, price.width)
				AND price.height = COALESCE(:height, price.height)

				-- PRODUCT
				AND p.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
				-- MODEL
				AND m.viewer_flg IN (:viewer_flg) -- 3,1: TH login employee | 3: TH ko login employee
			ORDER BY sc.selling_code ASC
		",

		"SELECT_OPTION_HANDLE_GIESTA" => "
			-- SELECT_OPTION_HANDLE_GIESTA
			SELECT DISTINCT
				option_handle.selling_code
				, option_handle.description AS series_name
				, option_handle.selling_code AS order_no
				, p.product_id
				, pt.product_name
				, option_handle.m_color_id
				, colortr.color_name
				, ccp.img_path AS color_handle_img_path
				, ccp.img_name AS color_handle_img_name
				, color.color_code_price
				, option_handle.spec51
				, option_handle.spec52
				, option_handle.spec53
				, option_handle.spec54
				, option_handle.spec55
				, option_handle.spec56
				, option_handle.spec57
				, option_handle.option4
				, o4.spec_name AS option4_display
				, op_price.amount
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_color_ctg_prod AS ccp
				ON
					ccp.del_flg = 0
					AND ccp.m_color_id = color.m_color_id
					AND ccp.ctg_prod_id = 37 -- Handle
			INNER JOIN m_option_selling_code_giesta AS option_handle
				ON
					option_handle.del_flg = 0
					AND option_handle.option_ctg_spec_id = 37 -- Handle
					AND option_handle.m_color_id = color.m_color_id
					AND option_handle.product_id = p.product_id
			INNER JOIN option_selling_code_price AS op_price
				ON
					op_price.design = option_handle.selling_code
			INNER JOIN m_selling_spec_trans AS o4
				ON
					o4.del_flg = 0
					AND o4.m_lang_id = l.m_lang_id
					AND o4.spec_code = option_handle.option4
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND ( option_handle.spec51 IS NULL OR option_handle.spec51 = COALESCE(:spec51, option_handle.spec51) )
				AND ( option_handle.spec52 IS NULL OR option_handle.spec52 = COALESCE(:spec52, option_handle.spec52) )
				AND ( option_handle.spec53 IS NULL OR option_handle.spec53 = COALESCE(:spec53, option_handle.spec53) )
				AND ( option_handle.spec54 IS NULL OR option_handle.spec54 = COALESCE(:spec54, option_handle.spec54) )
				AND ( option_handle.spec55 IS NULL OR option_handle.spec55 = COALESCE(:spec55, option_handle.spec55) )
				AND ( option_handle.spec56 IS NULL OR option_handle.spec56 = COALESCE(:spec56, option_handle.spec56) )
				-- Do đi theo main nên không cần where theo spec57
			ORDER BY option_handle.selling_code ASC
		",

		"SELECT_OPTION_CYLINDER_S_TYPE_GIESTA" => "
			-- SELECT_OPTION_CYLINDER_S_TYPE_GIESTA
			SELECT DISTINCT
				option_cylinder_s_type.selling_code
				, option_cylinder_s_type.description AS series_name
				, option_cylinder_s_type.selling_code AS order_no
				, p.product_id
				, pt.product_name
				, option_cylinder_s_type.m_color_id
				, colortr.color_name
				, color.color_code_price
				, op_price.amount
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_option_selling_code_giesta AS option_cylinder_s_type
				ON
					option_cylinder_s_type.del_flg = 0
					AND option_cylinder_s_type.option_ctg_spec_id = 93 -- Special Processing
					-- AND option_cylinder_s_type.m_color_id = color.m_color_id
					AND (
							option_cylinder_s_type.m_color_id IS NULL -- TH Color trống là option Cylinder có ở toàn bộ color
							OR option_cylinder_s_type.m_color_id = color.m_color_id
						)
					AND option_cylinder_s_type.product_id = p.product_id
			INNER JOIN m_selling_code_giesta AS sc
				ON
					(option_cylinder_s_type.product_id IS NULL OR sc.product_id = option_cylinder_s_type.product_id )
					AND ( option_cylinder_s_type.spec51 IS NULL OR sc.spec51 = option_cylinder_s_type.spec51 )
					AND ( option_cylinder_s_type.spec52 IS NULL OR sc.spec52 = option_cylinder_s_type.spec52 )
					AND ( option_cylinder_s_type.spec53 IS NULL OR sc.spec53 = option_cylinder_s_type.spec53 )
					AND ( option_cylinder_s_type.spec54 IS NULL OR sc.spec54 = option_cylinder_s_type.spec54 )
					AND ( option_cylinder_s_type.spec55 IS NULL OR sc.spec55 = option_cylinder_s_type.spec55 )
					AND ( option_cylinder_s_type.spec56 IS NULL OR sc.spec56 = option_cylinder_s_type.spec56 )
					AND ( option_cylinder_s_type.spec57 IS NULL OR sc.spec57 = option_cylinder_s_type.spec57 )
					AND sc.del_flg = 0
			INNER JOIN option_selling_code_price AS op_price
				ON
					op_price.design = option_cylinder_s_type.selling_code
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND color.m_color_id = :handle_color_id
				AND  COALESCE(sc.spec51, '') = COALESCE(:spec51, sc.spec51, '')
				AND  COALESCE(sc.spec52, '') = COALESCE(:spec52, sc.spec52, '')
				AND  COALESCE(sc.spec53, '') = COALESCE(:spec53, sc.spec53, '')
				AND  COALESCE(sc.spec54, '') = COALESCE(:spec54, sc.spec54, '')
				AND  COALESCE(sc.spec55, '') = COALESCE(:spec55, sc.spec55, '')
				AND  COALESCE(sc.spec56, '') = COALESCE(:spec56, sc.spec56, '')
				-- Do đi theo main nên không cần where theo spec57
			ORDER BY option_cylinder_s_type.selling_code ASC
		",

		"SELECT_OPTION_SPECIAL_PROC_GIESTA" => "
			-- SELECT_OPTION_SPECIAL_PROC_GIESTA
			SELECT DISTINCT
				option_special_proc.selling_code
				, option_special_proc.description AS series_name
				, option_special_proc.selling_code AS order_no
				, p.product_id
				, pt.product_name
				, option_special_proc.m_color_id
				, colortr.color_name
				, color.color_code_price
				, op_price.amount
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_option_selling_code_giesta AS option_special_proc
				ON
					option_special_proc.del_flg = 0
					AND option_special_proc.option_ctg_spec_id = 92 -- Special Processing
					-- AND option_special_proc.m_color_id = color.m_color_id
					AND (
							option_special_proc.m_color_id IS NULL -- TH Color trống là option Cylinder có ở toàn bộ color
							OR option_special_proc.m_color_id = color.m_color_id
						)
					AND option_special_proc.product_id = p.product_id
			INNER JOIN m_selling_code_giesta AS sc
				ON
					(option_special_proc.product_id IS NULL OR sc.product_id = option_special_proc.product_id )
					AND ( option_special_proc.spec51 IS NULL OR sc.spec51 = option_special_proc.spec51 )
					AND ( option_special_proc.spec52 IS NULL OR sc.spec52 = option_special_proc.spec52 )
					AND ( option_special_proc.spec53 IS NULL OR sc.spec53 = option_special_proc.spec53 )
					AND ( option_special_proc.spec54 IS NULL OR sc.spec54 = option_special_proc.spec54 )
					AND ( option_special_proc.spec55 IS NULL OR sc.spec55 = option_special_proc.spec55 )
					AND ( option_special_proc.spec56 IS NULL OR sc.spec56 = option_special_proc.spec56 )
					AND ( option_special_proc.spec57 IS NULL OR sc.spec57 = option_special_proc.spec57 )
					AND sc.del_flg = 0
			INNER JOIN option_selling_code_price AS op_price
				ON
					op_price.design = option_special_proc.selling_code
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND color.m_color_id = :handle_color_id
				AND  COALESCE(sc.spec51, '') = COALESCE(:spec51, sc.spec51, '')
				AND  COALESCE(sc.spec52, '') = COALESCE(:spec52, sc.spec52, '')
				AND  COALESCE(sc.spec53, '') = COALESCE(:spec53, sc.spec53, '')
				AND  COALESCE(sc.spec54, '') = COALESCE(:spec54, sc.spec54, '')
				AND  COALESCE(sc.spec55, '') = COALESCE(:spec55, sc.spec55, '')
				AND  COALESCE(sc.spec56, '') = COALESCE(:spec56, sc.spec56, '')
				-- Do đi theo main nên không cần where theo spec57
			ORDER BY option_special_proc.selling_code ASC
		",

		"SELECT_OPTION_KEYS_SET_GIESTA" => "
			-- SELECT_OPTION_KEYS_SET_GIESTA
			SELECT DISTINCT
				option_keys_set.selling_code
				, option_keys_set.description AS series_name
				, option_keys_set.selling_code AS order_no
				, p.product_id
				, pt.product_name
				, option_keys_set.m_color_id
				, colortr.color_name
				, color.color_code_price
				, op_price.amount
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_option_selling_code_giesta AS option_keys_set
				ON
					option_keys_set.del_flg = 0
					AND option_keys_set.option_ctg_spec_id = 91 -- Familock Keys Set
					-- AND option_keys_set.m_color_id = color.m_color_id
					AND (
							option_keys_set.m_color_id IS NULL -- TH Color trống là option Cylinder có ở toàn bộ color
							OR option_keys_set.m_color_id = color.m_color_id
						)
					AND option_keys_set.product_id = p.product_id
			INNER JOIN m_selling_code_giesta AS sc
				ON
					(option_keys_set.product_id IS NULL OR sc.product_id = option_keys_set.product_id )
					AND ( option_keys_set.spec51 IS NULL OR sc.spec51 = option_keys_set.spec51 )
					AND ( option_keys_set.spec52 IS NULL OR sc.spec52 = option_keys_set.spec52 )
					AND ( option_keys_set.spec53 IS NULL OR sc.spec53 = option_keys_set.spec53 )
					AND ( option_keys_set.spec54 IS NULL OR sc.spec54 = option_keys_set.spec54 )
					AND ( option_keys_set.spec55 IS NULL OR sc.spec55 = option_keys_set.spec55 )
					AND ( option_keys_set.spec56 IS NULL OR sc.spec56 = option_keys_set.spec56 )
					AND ( option_keys_set.spec57 IS NULL OR sc.spec57 = option_keys_set.spec57 )
					AND sc.del_flg = 0
			INNER JOIN option_selling_code_price AS op_price
				ON
					op_price.design = option_keys_set.selling_code
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
			    AND color.m_color_id = :handle_color_id
				AND  COALESCE(sc.spec51, '') = COALESCE(:spec51, sc.spec51, '')
				AND  COALESCE(sc.spec52, '') = COALESCE(:spec52, sc.spec52, '')
				AND  COALESCE(sc.spec53, '') = COALESCE(:spec53, sc.spec53, '')
				AND  COALESCE(sc.spec54, '') = COALESCE(:spec54, sc.spec54, '')
				AND  COALESCE(sc.spec55, '') = COALESCE(:spec55, sc.spec55, '')
				AND  COALESCE(sc.spec56, '') = COALESCE(:spec56, sc.spec56, '')
				-- Do đi theo main nên không cần where theo spec57
			ORDER BY option_keys_set.selling_code ASC
		",

		"SELECT_OPTION_CYLINDER_GIESTA" => "
			-- SELECT_OPTION_CYLINDER_GIESTA
			SELECT DISTINCT
				option_cylinder.selling_code
				, option_cylinder.description AS series_name
				, option_cylinder.selling_code AS order_no
				, p.product_id
				, pt.product_name
				, option_cylinder.m_color_id
				, colortr.color_name
				, color.color_code_price
				, op_price.amount
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_option_selling_code_giesta AS option_cylinder
				ON
					option_cylinder.del_flg = 0
					AND option_cylinder.option_ctg_spec_id = 38 -- Cylinder
					AND option_cylinder.m_color_id = color.m_color_id
					AND (
							option_cylinder.m_color_id IS NULL -- TH Color trống là option Cylinder có ở toàn bộ color
							OR option_cylinder.m_color_id = color.m_color_id
						)
					AND option_cylinder.product_id = p.product_id
			INNER JOIN m_selling_code_giesta AS sc
				ON
					(option_cylinder.product_id IS NULL OR sc.product_id = option_cylinder.product_id )
					AND ( option_cylinder.spec51 IS NULL OR sc.spec51 = option_cylinder.spec51 )
					AND ( option_cylinder.spec52 IS NULL OR sc.spec52 = option_cylinder.spec52 )
					AND ( option_cylinder.spec53 IS NULL OR sc.spec53 = option_cylinder.spec53 )
					AND ( option_cylinder.spec54 IS NULL OR sc.spec54 = option_cylinder.spec54 )
					AND ( option_cylinder.spec55 IS NULL OR sc.spec55 = option_cylinder.spec55 )
					AND ( option_cylinder.spec56 IS NULL OR sc.spec56 = option_cylinder.spec56 )
					AND ( option_cylinder.spec57 IS NULL OR sc.spec57 = option_cylinder.spec57 )
					AND sc.del_flg = 0
			INNER JOIN option_selling_code_price AS op_price
				ON
					op_price.design = option_cylinder.selling_code
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND color.m_color_id = :handle_color_id
				AND  COALESCE(sc.spec51, '') = COALESCE(:spec51, sc.spec51, '')
				AND  COALESCE(sc.spec52, '') = COALESCE(:spec52, sc.spec52, '')
				AND  COALESCE(sc.spec53, '') = COALESCE(:spec53, sc.spec53, '')
				AND  COALESCE(sc.spec54, '') = COALESCE(:spec54, sc.spec54, '')
				AND  COALESCE(sc.spec55, '') = COALESCE(:spec55, sc.spec55, '')
				AND  COALESCE(sc.spec56, '') = COALESCE(:spec56, sc.spec56, '')
				-- Do đi theo main nên không cần where theo spec57
			ORDER BY option_cylinder.selling_code ASC
		",

		"SELECT_OPTION_DOOR_GUARD_GIESTA" => "
			-- SELECT_OPTION_DOOR_GUARD_GIESTA
			SELECT DISTINCT
				option_doorguard.selling_code
				, option_doorguard.description AS series_name
				, option_doorguard.selling_code AS order_no
				, p.product_id
				, pt.product_name
				, option_doorguard.m_color_id
				, colortr.color_name
				, color.color_code_price
				, op_price.amount
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_option_selling_code_giesta AS option_doorguard
				ON
					option_doorguard.del_flg = 0
					AND option_doorguard.option_ctg_spec_id = 39 -- Door guard
					AND (
							option_doorguard.m_color_id IS NULL -- TH Color trống là option Door guard có ở toàn bộ color
							OR option_doorguard.m_color_id = color.m_color_id
						)
					AND option_doorguard.product_id = p.product_id
			INNER JOIN m_selling_code_giesta AS sc
				ON
					(option_doorguard.product_id IS NULL OR sc.product_id = option_doorguard.product_id )
					AND ( option_doorguard.spec51 IS NULL OR sc.spec51 = option_doorguard.spec51 )
					AND ( option_doorguard.spec52 IS NULL OR sc.spec52 = option_doorguard.spec52 )
					AND ( option_doorguard.spec53 IS NULL OR sc.spec53 = option_doorguard.spec53 )
					AND ( option_doorguard.spec54 IS NULL OR sc.spec54 = option_doorguard.spec54 )
					AND ( option_doorguard.spec55 IS NULL OR sc.spec55 = option_doorguard.spec55 )
					AND ( option_doorguard.spec56 IS NULL OR sc.spec56 = option_doorguard.spec56 )
					AND ( option_doorguard.spec57 IS NULL OR sc.spec57 = option_doorguard.spec57 )
					AND sc.del_flg = 0
			INNER JOIN option_selling_code_price AS op_price
				ON
					op_price.design = option_doorguard.selling_code
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND color.m_color_id = :handle_color_id
				AND  COALESCE(sc.spec51, '') = COALESCE(:spec51, sc.spec51, '')
				AND  COALESCE(sc.spec52, '') = COALESCE(:spec52, sc.spec52, '')
				AND  COALESCE(sc.spec53, '') = COALESCE(:spec53, sc.spec53, '')
				AND  COALESCE(sc.spec54, '') = COALESCE(:spec54, sc.spec54, '')
				AND  COALESCE(sc.spec55, '') = COALESCE(:spec55, sc.spec55, '')
				AND  COALESCE(sc.spec56, '') = COALESCE(:spec56, sc.spec56, '')
				-- Do đi theo main nên không cần where theo spec57
			ORDER BY option_doorguard.selling_code ASC
		",

		"SELECT_OPTION_CLOSER_GIESTA" => "
			-- SELECT_OPTION_CLOSER_GIESTA
			SELECT DISTINCT
				option_closer.selling_code
				, option_closer.description AS series_name
				, option_closer.selling_code AS order_no
				, p.product_id
				, pt.product_name
				, option_closer.m_color_id
				, colortr.color_name
				, color.color_code_price
				, op_price.amount
			FROM m_lang AS l
			INNER JOIN ctg_trans AS ct
				ON
					l.m_lang_id = ct.m_lang_id
					AND ct.del_flg = 0
			INNER JOIN ctg AS c
				ON
					c.ctg_id = ct.ctg_id
					AND c.del_flg = 0
					AND c.ctg_type = 'prod'
			INNER JOIN product_trans AS pt
				ON
					l.m_lang_id = pt.m_lang_id
					AND pt.del_flg = 0
			INNER JOIN product AS p
				ON
					p.product_id = pt.product_id
					AND p.ctg_prod_id = c.ctg_id
					AND p.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			INNER JOIN m_option_selling_code_giesta AS option_closer
				ON
					option_closer.del_flg = 0
					AND option_closer.option_ctg_spec_id = 40 -- Closer
					AND (
							option_closer.m_color_id IS NULL -- TH Color trống là option Closer có ở toàn bộ color
							OR option_closer.m_color_id = color.m_color_id
						)
					AND option_closer.product_id = p.product_id
			INNER JOIN m_selling_code_giesta AS sc
				ON
					(option_closer.product_id IS NULL OR sc.product_id = option_closer.product_id )
					AND ( option_closer.spec51 IS NULL OR sc.spec51 = option_closer.spec51 )
					AND ( option_closer.spec52 IS NULL OR sc.spec52 = option_closer.spec52 )
					AND ( option_closer.spec53 IS NULL OR sc.spec53 = option_closer.spec53 )
					AND ( option_closer.spec54 IS NULL OR sc.spec54 = option_closer.spec54 )
					AND ( option_closer.spec55 IS NULL OR sc.spec55 = option_closer.spec55 )
					AND ( option_closer.spec56 IS NULL OR sc.spec56 = option_closer.spec56 )
					AND ( option_closer.spec57 IS NULL OR sc.spec57 = option_closer.spec57 )
					AND sc.del_flg = 0
			INNER JOIN option_selling_code_price AS op_price
				ON
					op_price.design = option_closer.selling_code
			INNER JOIN m_door_closer_color AS closercolor -- Map color tương ứng với bên color của Main panel
				ON
					closercolor.del_flg = 0
					AND closercolor.spec51 = option_closer.spec51
					AND closercolor.door_closer_color_id = option_closer.m_color_id
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND closercolor.panel_color_id = :main_color_id
				AND  COALESCE(sc.spec51, '') = COALESCE(:spec51, sc.spec51, '')
				AND  COALESCE(sc.spec52, '') = COALESCE(:spec52, sc.spec52, '')
				AND  COALESCE(sc.spec53, '') = COALESCE(:spec53, sc.spec53, '')
				AND  COALESCE(sc.spec54, '') = COALESCE(:spec54, sc.spec54, '')
				AND  COALESCE(sc.spec55, '') = COALESCE(:spec55, sc.spec55, '')
				AND  COALESCE(sc.spec56, '') = COALESCE(:spec56, sc.spec56, '')
				-- Do đi theo main nên không cần where theo spec57
			ORDER BY option_closer.selling_code ASC
		",

		//END SQL GIESTA

		//Add Start BP_O2OQ-7 hainp 20200710
		"MAX_DECIMAL_AMOUNT_SELLING_CODE_PRICE" => "
			SELECT MAX(max.max_amount_decimal) AS max_amount_decimal
			FROM
			(
				SELECT COALESCE(MAX(LENGTH(SUBSTR(t.str, t.dot_pos + 1))), 0) max_amount_decimal
				FROM
				(
					SELECT amount as str, LOCATE('.', amount) dot_pos
					FROM product_selling_code_price
				) t
				WHERE t.dot_pos > 0
				UNION ALL
				SELECT COALESCE(MAX(LENGTH(SUBSTR(t.str, t.dot_pos + 1))), 0) max_amount_decimal
				FROM
				(
					SELECT amount as str, LOCATE('.', amount) dot_pos
					FROM option_selling_code_price
				) t
				WHERE t.dot_pos > 0
			) max
		",
		//Add End BP_O2OQ-7 hainp 20200710
		
		//Add Start BP_O2OQ-25 antran 20210622
		"GET_SUBMENU" => "
			-- SELECT SUBMENU
            SELECT DISTINCT
                p.product_id
                , ps.spec_code
                , ps.link_text
                , ps.link_url
                , ps.description
            FROM m_lang AS l
            INNER JOIN ctg_trans AS ct
                ON
                    l.m_lang_id = ct.m_lang_id
                    AND ct.del_flg = 0
            INNER JOIN ctg AS c
                ON
                    c.ctg_id = ct.ctg_id
                    AND c.del_flg = 0
                    AND c.ctg_type = 'prod'
            INNER JOIN product_trans AS pt
                ON
                    l.m_lang_id = pt.m_lang_id
                    AND pt.del_flg = 0
            INNER JOIN product AS p
                ON
                    p.product_id = pt.product_id
                    AND p.ctg_prod_id = c.ctg_id
                    AND p.del_flg = 0
            INNER JOIN m_product_submenu ps
            	ON
            		ps.product_id = p.product_id
            		AND ps.del_flg = 0
            WHERE
                l.del_flg = 0
                AND l.lang_code = COALESCE(:lang_code, 'en')
                AND c.ctg_id = :ctg_id
                AND l.m_lang_id = ps.m_lang_id
            ORDER BY ps.sort_order ASC
		",
		//Add End BP_O2OQ-25 antran 20210622
    ]
];
