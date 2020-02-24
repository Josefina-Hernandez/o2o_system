<?php
return [
    'select' => [
    	'SPEC_GROUP' => "
    		SELECT m_spec_group_id, MIN(sort_order) AS sort_order
			FROM `m_selling_spec`
			GROUP BY m_spec_group_id
			ORDER BY sort_order, CAST(m_spec_group_id as int)
    	",

    	'COLORS' => "
    		SELECT DISTINCT
				color.m_color_id
				, colortr.color_name
				, ccp.img_path
				, ccp.img_name
				, color.sort_order
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
			INNER JOIN m_color_ctg_prod AS ccp
				ON
					ccp.ctg_prod_id = c.ctg_id
					AND ccp.del_flg = 0
			INNER JOIN m_color_trans AS colortr
				ON
					colortr.m_color_id = ccp.m_color_id
					AND colortr.m_lang_id = l.m_lang_id
					AND colortr.del_flg = 0
			INNER JOIN m_color AS color
				ON
					color.m_color_id = colortr.m_color_id
					AND color.del_flg = 0
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND m.m_model_id = :m_model_id
				-- PRODUCT
				AND p.viewer_flg IN (3,1) -- TH login employee
				AND p.viewer_flg IN (3) -- TH KHÔNG login employee
				-- MODEL
				AND m.viewer_flg IN (3,1) -- TH login employee
				AND m.viewer_flg IN (3) -- TH KHÔNG login employee
			ORDER BY color.sort_order ASC
    	",

    	'OPTIONS' => "
    		-- SELECT CONTROL SPEC-OPTION-PRICE
			SELECT DISTINCT
				m.m_model_id
				, pt.product_name
				, clm.img_path AS img_path_result
				, clm.img_name AS img_name_result
				, colortr.color_name
				, sc.*
				, price.*
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
			INNER JOIN m_selling_code AS sc
				ON
					(ms.product_id IS NULL OR sc.product_id = ms.product_id)
					AND (ms.spec1 IS NULL OR sc.spec1 = ms.spec1 )
					AND ( ms.spec2 IS NULL OR sc.spec2 = ms.spec2 )
					AND ( ms.spec3 IS NULL OR sc.spec3 = ms.spec3 )
					AND ( ms.spec4 IS NULL OR sc.spec4 = ms.spec4 )
					AND ( ms.spec5 IS NULL OR sc.spec5 = ms.spec5 )
					AND ( ms.spec6 IS NULL OR sc.spec6 = ms.spec6 )
					AND ( ms.spec7 IS NULL OR sc.spec7 = ms.spec7 )
					AND ( ms.spec8 IS NULL OR sc.spec8 = ms.spec8 )
					AND ( ms.spec9 IS NULL OR sc.spec9 = ms.spec9 )
					AND ( ms.spec10 IS NULL OR sc.spec10 = ms.spec10 )
					AND ( ms.spec11 IS NULL OR sc.spec11 = ms.spec11 )
					AND ( ms.spec12 IS NULL OR sc.spec12 = ms.spec12 )
					AND sc.del_flg = 0
					AND p.product_id = sc.product_id
			INNER JOIN product_selling_code_price AS price
				ON
					price.design = sc.selling_code
					AND ( 
							-- Cho row product
							(color.color_code_price IN ('B', 'C', 'D', 'F') AND price.special IS NULL) OR (color.color_code_price = price.special) 
							-- Cho row option
							OR (price.width IS NULL AND price.height IS NULL)  
						)
			WHERE
				l.del_flg = 0
				AND l.lang_code = COALESCE(:lang_code, 'en')
				AND c.ctg_id = :ctg_id
				AND p.product_id = :product_id
				AND m.m_model_id = :m_model_id
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
				AND p.viewer_flg IN (3,1) -- TH login employee
				AND p.viewer_flg IN (3) -- TH KHÔNG login employee
				-- MODEL
				AND m.viewer_flg IN (3,1) -- TH login employee
				AND m.viewer_flg IN (3) -- TH KHÔNG login employee
			ORDER BY sc.selling_code ASC
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
				AND p.viewer_flg IN (3,1) -- TH login employee
				AND p.viewer_flg IN (3) -- TH KHÔNG login employee
			ORDER BY c.sort_order ASC
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
                AND c.ctg_id = :ctg_id
                -- PRODUCT
                AND p.viewer_flg IN (3,1) -- TH login employee
                -- AND p.viewer_flg IN (3) -- TH KHÔNG login employee
            ORDER BY p.sort_order ASC
        ",

        'MODELS' => "
            -- SELECT MODEL
            WITH tb AS (
                SELECT DISTINCT
                    m.m_model_id
                    , p.product_id
                    , mt.product_id AS product_id_setting
                    , m.img_path
                    , m.img_name
                    , mt.model_name
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
                WHERE
                    l.del_flg = 0
                    AND l.lang_code = COALESCE(:lang_code, 'en')
                    AND c.ctg_id = :ctg_id
                    AND p.product_id = :product_id
                    -- PRODUCT
                    AND p.viewer_flg IN (3,1) -- TH login employee
                    AND p.viewer_flg IN (3) -- TH KHÔNG login employee
                    -- MODEL
                    AND m.viewer_flg IN (3,1) -- TH login employee
                    AND m.viewer_flg IN (3) -- TH KHÔNG login employee
                ORDER BY m.sort_order ASC
            )
            , tb_index AS (
                SELECT
                    ROW_NUMBER() OVER (PARTITION BY m_model_id ORDER BY m_model_id) AS row_num
                    , tb.*
                FROM tb
                GROUP BY tb.m_model_id
                    , tb.product_id
                    , tb.product_id_setting
                    , tb.img_path
                    , tb.img_name
                    , tb.model_name
                    , tb.product_name
                    , tb.ctg_product
                    , tb.sort_order
            )
            SELECT a1.*, COALESCE(a2.model_name, a1.model_name) AS model_name_display
            FROM tb_index as a1
            LEFT JOIN tb_index AS a2
                ON
                    a1.m_model_id = a2.m_model_id
                    AND a1.product_id = a2.product_id
                    AND a1.row_num = a2.row_num - 1
            WHERE
                1 = 1
                AND ((a1.product_id_setting IS NOT NULL AND a2.model_name IS NOT NULL) OR (a1.product_id_setting IS NULL AND a1.row_num = 1))
                ORDER BY sort_order ASC
        ",

        'CATEGORY' => "
            -- SELECT CTG
			SELECT
				ct.ctg_id
				, ct.ctg_name
				, c.slug_name
			FROM ctg_trans as ct
            INNER JOIN ctg AS c
                ON
                    c.ctg_id = ct.ctg_id
                    AND c.del_flg = 0
                    AND c.ctg_type = 'prod'
			WHERE
				c.slug_name = :ctg_slug
          
        ",
    ]
];