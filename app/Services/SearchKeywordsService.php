<?php

namespace App\Services;

use App\Models\Shop;
use Illuminate\Support\Facades\DB;

/**
 * 検索ワードをパースするためのクラス
 * 
 * //@TODO: 複数カラムを連結して住所を作成するため、複雑な処理になってしまった
 */
class SearchKeywordsService
{
    /**
     * 文字列を検索ワードとして分解し、返却する。
     * 
     * @param string $keywords 解釈する文字列
     * @return array 検索ワード
     */
    public function parse(string $keywords)
    {
        // 空白文字（\s + 全角スペース）を区切り文字として分割する
        return preg_split('/[\s　]+/u', $keywords, null, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * LIXIL管理画面の会員一覧画面で会員の検索を行う
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $options クエリパラメータで渡された検索条件
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function shopsAdmin($query, array $options)
    {
        // 都道府県と市区町村をショップにjoinする
        // concatは連結対象に1つでもnullのカラムが存在する場合、結果がnullになってしまうため、
        // ifnullでnullの場合に空文字を連結させるようにする
        $query->select(DB::raw('shops.*'))
        ->join('prefs', function ($join) {
            $join->on('shops.pref_id', '=', 'prefs.id')->whereNull('prefs.' . config('const.db.prefs.DELETED_AT'));
        })->join('cities', function ($join) {
            $join->on('shops.city_id', '=', 'cities.id')->whereNull('cities.' . config('const.db.cities.DELETED_AT'));
        });

        // クエリパラメータ名だけを取り出す
        $keys = array_keys($options);

        // 検索キーワード
        if (! in_array(config('const.form.common.SEARCH_KEYWORDS'), $keys, true)
            || $options[config('const.form.common.SEARCH_KEYWORDS')] === null) {
            // 検索キーワードがクエリパラメータに存在しないか、空の場合はキーワードマッチングを行わない。

        } else {
            // 検索キーワードが指定されている場合、空白文字で区切られたワードでAND検索する
            // 検索対象は法人名、法人名フリガナ、店名、店名フリガナ、住所（都道府県+市区町村+番地+ビル名）、電話番号
            $keywords = $this->parse($options[config('const.form.common.SEARCH_KEYWORDS')]);
            foreach ($keywords as $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('shops.' . config('const.db.shops.NAME'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.KANA'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.COMPANY_NAME'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.COMPANY_NAME_KANA'), 'LIKE', "%{$keyword}%")
                        ->orWhere('shops.' . config('const.db.shops.TEL'), 'LIKE', "%{$keyword}%")
                        ->orWhere(DB::raw('CONCAT(IFNULL(prefs. ' . config('const.db.prefs.NAME') . ", ''), IFNULL(cities." . config('const.db.cities.NAME') . ", ''), IFNULL(shops." . config('const.db.shops.STREET') . ", ''), IFNULL(shops." . config('const.db.shops.BUILDING') . ", ''))"), 'LIKE', "%{$keyword}%");
                });
            }
        }

        // プレミアム区分
        if (in_array(config('const.form.common.PREMIUM'), $keys, true)
            && $options[config('const.form.common.PREMIUM')] === config('const.form.common.CHECKED')) {
            $query->where('shops.' . config('const.db.shops.SHOP_CLASS_ID'), DB::raw(config('const.common.shops.classes.PREMIUM')));
        }

        // スタンダード区分
        if (in_array(config('const.form.common.STANDARD'), $keys, true)
            && $options[config('const.form.common.STANDARD')] === config('const.form.common.CHECKED')) {
            $query->where('shops.' . config('const.db.shops.SHOP_CLASS_ID'), DB::raw(config('const.common.shops.classes.STANDARD')));
        }

        return $query;
    }

    /**
     * フロントの加盟店一覧画面で加盟店の検索を行う
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $options クエリパラメータで渡された検索条件
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function shopsFrontKeyword($query, array $options)
    {
        // 都道府県と市区町村をショップにjoinする
        // concatは連結対象に1つでもnullのカラムが存在する場合、結果がnullになってしまうため、
        // ifnullでnullの場合に空文字を連結させるようにする
        $query->select(DB::raw('shops.*'))
        ->join('prefs', function ($join) {
            $join->on('shops.pref_id', '=', 'prefs.id')->whereNull('prefs.' . config('const.db.prefs.DELETED_AT'));
        })->join('cities', function ($join) {
            $join->on('shops.city_id', '=', 'cities.id')->whereNull('cities.' . config('const.db.cities.DELETED_AT'));
        });
        
        // クエリパラメータ名だけを取り出す
        $keys = array_keys($options);

        // 検索キーワード
        if (! in_array(config('const.form.common.SEARCH_KEYWORDS'), $keys, true)
            || $options[config('const.form.common.SEARCH_KEYWORDS')] === null) {
            // 検索キーワードがクエリパラメータに存在しないか、空の場合はキーワードマッチングを行わない。

        } else {
            // 検索キーワードが指定されている場合、空白文字で区切られたワードでAND検索する
            // 検索対象は法人名、法人名フリガナ、店名、店名フリガナ、代表者名、担当者名、郵便番号、住所（都道府県、市区町村、番地、ビル名をつなげて住所として扱う）、対応エリア、電話番号、FAX番号、取り扱い施工内容、資格、沿革、メッセージ、施工事例サマリ
            $keywords = $this->parse($options[config('const.form.common.SEARCH_KEYWORDS')]);
            foreach ($keywords as $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query
                        ->orWhere('shops.' . config('const.db.shops.COMPANY_NAME'), 'LIKE', "%{$keyword}%")
                        ->orWhere('shops.' . config('const.db.shops.COMPANY_NAME_KANA'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.NAME'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.KANA'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.PRESIDENT_NAME'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.PERSONNEL_NAME'), 'LIKE', "%{$keyword}%")
                        ->orWhere(DB::raw('CONCAT(IFNULL(shops.' . config('const.db.shops.ZIP1') . ", ''),  '-', IFNULL(shops." . config('const.db.shops.ZIP2') . ", ''))"), 'LIKE', "%{$keyword}%")
                        ->orWhere(DB::raw('CONCAT(IFNULL(prefs. ' . config('const.db.prefs.NAME') . ", ''), IFNULL(cities." . config('const.db.cities.NAME') . ", ''), IFNULL(shops." . config('const.db.shops.STREET') . ", ''), IFNULL(shops." . config('const.db.shops.BUILDING') . ", ''))"), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.SUPPORT_AREA'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.TEL'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.FAX'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.CERTIFICATE'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.COMPANY_HISTORY'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.MESSAGE'), 'LIKE', "%{$keyword}%")
                        ->orwhere('shops.' . config('const.db.shops.PHOTO_SUMMARY'), 'LIKE', "%{$keyword}%");
                });
            }
        }

        // 見積もりシミュレーション
        if (in_array(config('const.form.common.SIMULATE'), $keys, true)
            && $options[config('const.form.common.SIMULATE')] === config('const.form.common.CHECKED')) {
            $query->where('shops.' . config('const.db.shops.CAN_SIMULATE'), DB::raw(config('const.common.ENABLE')));
        }

        // 取扱施工内容
        $details = array_filter($options, function ($value, $key) {
            // キーが detail_{\d} で、かつ値が 'ON' のパラメータを抽出する
            return starts_with($key, config('const.form.common.DETAIL'))
                && ctype_digit(str_after($key, config('const.form.common.DETAIL') . '_'))
                && $value === config('const.form.common.CHECKED');
        }, ARRAY_FILTER_USE_BOTH);
        foreach ($details as $key => $value) {
            // キーからidを取り出す
            $detailId = str_after($key, config('const.form.common.DETAIL') . '_');

            // MySQLが5.7以上であればJSON_CONTAINS()が、
            // laravelが5.6以上であればwhereJsonContains()が使えるが、
            // MySQLとlaravelが共にjson_containsを使えない環境を想定し、regexpで検索する
            $query->where(config('const.db.shops.SUPPORT_DETAIL_LIST'), 'regexp', '"' . $detailId . '"');
        }

        return $query;
    }

    /**
     * フロントの加盟店一覧画面でスタンダード事例の検索を行う
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $options クエリパラメータで渡された検索条件
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function standardPhotosFront($query, array $options)
    {
        // クエリパラメータ名だけを取り出す
        $keys = array_keys($options);

        // 検索キーワード
        if (! in_array(config('const.form.common.SEARCH_KEYWORDS'), $keys, true)
            || $options[config('const.form.common.SEARCH_KEYWORDS')] === null) {
            // 検索キーワードがクエリパラメータに存在しないか、空の場合はキーワードマッチングを行わない。

        } else {
            // 検索キーワードが指定されている場合、空白文字で区切られたワードでAND検索する
            // 検索対象は概要のみ
            $keywords = $this->parse($options[config('const.form.common.SEARCH_KEYWORDS')]);
            foreach ($keywords as $keyword) {
                $query->where(config('const.db.standard_photos.SUMMARY'), 'LIKE', "%{$keyword}%");
            }
        }

        // お客様の声
        if (in_array(config('const.form.common.VOICE'), $keys, true)
            && $options[config('const.form.common.VOICE')] === config('const.form.common.CHECKED')) {
            $query->hasVoice();
        }

        return $query;
    }

    /**
     * フロントの加盟店一覧画面でプレミアム事例の検索を行う
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $options クエリパラメータで渡された検索条件
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function premiumPhotosFront($query, array $options)
    {
        // クエリパラメータ名だけを取り出す
        $keys = array_keys($options);

        // 検索キーワード
        if (! in_array(config('const.form.common.SEARCH_KEYWORDS'), $keys, true)
            || $options[config('const.form.common.SEARCH_KEYWORDS')] === null) {
            // 検索キーワードがクエリパラメータに存在しないか、空の場合はキーワードマッチングを行わない。

        } else {
            // 検索キーワードが指定されている場合、空白文字で区切られたワードでAND検索する
            // 検索対象は概要のみ
            $keywords = $this->parse($options[config('const.form.common.SEARCH_KEYWORDS')]);
            foreach ($keywords as $keyword) {
                $query->where(config('const.db.premium_photos.SUMMARY'), 'LIKE', "%{$keyword}%");
            }
        }

        // お客様の声
        if (in_array(config('const.form.common.VOICE'), $keys, true)
            && $options[config('const.form.common.VOICE')] === config('const.form.common.CHECKED')) {
            $query->hasVoice();
        }

        return $query;
    }

    /**
     * フロントの加盟店一覧画面で事例の検索を行う
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $options クエリパラメータで渡された検索条件
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function standardPhotosFrontShopStandard($query, array $options)
    {
        // クエリパラメータ名だけを取り出す
        $keys = array_keys($options);

        // 検索キーワード
        if (! in_array(config('const.form.common.SEARCH_KEYWORDS'), $keys, true)
            || $options[config('const.form.common.SEARCH_KEYWORDS')] === null) {
            // 検索キーワードがクエリパラメータに存在しないか、空の場合はキーワードマッチングを行わない。

        } else {
            // 検索キーワードが指定されている場合、空白文字で区切られたワードでAND検索する
            // 検索対象はタイトル、概要、本文、施工前テキスト、施工後テキスト、お客様の声テキスト（お客様の声掲載フラグが有効になっている場合）
            $keywords = $this->parse($options[config('const.form.common.SEARCH_KEYWORDS')]);
            foreach ($keywords as $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query
                        ->orWhere(config('const.db.standard_photos.TITLE'), 'LIKE', "%{$keyword}%")
                        ->orWhere(config('const.db.standard_photos.SUMMARY'), 'LIKE', "%{$keyword}%")
                        ->orWhere(config('const.db.standard_photos.MAIN_TEXT'), 'LIKE', "%{$keyword}%")
                        ->orWhere(config('const.db.standard_photos.BEFORE_TEXT'), 'LIKE', "%{$keyword}%")
                        ->orWhere(config('const.db.standard_photos.AFTER_TEXT'), 'LIKE', "%{$keyword}%")
                        ->orWhere(function ($query) use ($keyword) {
                            $query
                                ->hasVoice()
                                ->where(function ($query) use ($keyword) {
                                    $query
                                        ->where(config('const.db.standard_photos.CUSTOMER_TEXT'), 'LIKE', "%{$keyword}%")
                                        ->orWhere(config('const.db.standard_photos.CUSTOMER_TEXT_2'), 'LIKE', "%{$keyword}%");
                                });
                        });
                });
            }
        }

        return $query;
    }
}
