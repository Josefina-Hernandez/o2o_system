<?php

namespace App\Repositories;
use App\Http\Controllers\Tostem\Front\QuotationController;

class HelpersFront
{

    public static function image ($name_img) {
        if ($name_img == '') {
            return url('/tostem/img/icon/icon-no-image.svg');
        }
        $imageFileType = ['JPEG','jpeg','JPG','jpg', 'PNG', 'png', 'svg', 'SVG'];
        foreach ($imageFileType as $fileType) {
            if (file_exists(public_path() . '/tostem/img/' . $name_img . $fileType)) {
                return url('/tostem/img/' . $name_img . $fileType);
            }
        }
        $patch_img = url('/tostem/img/icon/icon-no-image.svg');
        return $patch_img;

    }


    public static function breadcrumbs () {
        $quotation = new QuotationController();
        $categories = collect(\DB::Select($quotation->sql_Select_Ctg, ['lang_code' => $quotation->lang_code]));

        $html = '';
        foreach ($categories as $category) {
            $html .= "<li class=''><a href=".route('tostem.front.quotation_system.product', $category->slug_name)." data-id='$category->ctg_id'>$category->ctg_name</a></li>";
        }
        return $html;
    }

}