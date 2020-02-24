<?php

namespace App\Services;

use App\Facades\MadoLog;

/**
 * CSVの読み込み処理を提供するクラス
 */
class CsvService
{
    /**
     * 区切り文字
     * 
     * @var string
     */
    private $delimiter = ',';

    /**
     * 囲み文字
     * 
     * @var string
     */
    private $enclosure = "\"";

    /**
     * エスケープ文字
     * 
     * @var string
     */
    private $escape = "\\";

    /**
     * Windows環境かどうか
     * 
     * @var bool
     */
    private $isWindows;

    function __construct()
    {
        $this->isWindows = strpos(PHP_OS, 'WIN') === 0;
    }

    /**
     * CSVファイルを読み取り、イテレータを受け取る
     * 
     * @param $csvfile
     * @return array
     */
    public function readCsv($csvfile)
    {
        // ファイル存在確認
        if (! file_exists($csvfile)) return false;

        $csvData = file_get_contents($csvfile);

        if ($this->isWindows) {
            // SJISで処理する
            
            // Windows環境ではsetlocaleにUTF8を指定することができない
            // https://docs.microsoft.com/en-us/cpp/c-runtime-library/reference/setlocale-wsetlocale?view=vs-2019
            setlocale(LC_ALL, 'C');

        } else {
            // UTF-8で処理する
            setlocale(LC_ALL, 'ja_JP.UTF-8');
            $csvData = $this->convertToUTF8($csvData);
        }

        // 改行コードを \n に統一する
        $csvData = $this->convertLineFeed($csvData, "\r\n");

        // CSVファイルの内容をパースする
        return $this->getIterator($csvData);
    }

    /**
     * 与えられた文字列の文字コードをUTF-8に変換する
     * 変換に成功すれば変換後の文字列を、失敗すればnullを返す
     *
     * @param $str
     * @return null|string|string[]
     * @throws \Exception
     */
    public function convertToUTF8($str)
    {
        $fileStr = mb_substr($str, 0, 512);
        $encode = $this->detectEncoding($fileStr);
        if ($encode != 'UTF-8') {
            $str = mb_convert_encoding($str, 'UTF-8', $encode);
        }

        // UTF-8への変換が成功したかどうかを確かめる
        $utf8Pattern = '/(?:'
            . '[\x00-\x7f]'
            . '|[\xc2-\xdf][\x80-\xbf]'
            . '|\xe0[\xa0-\xbf][\x80-\xbf]'
            . '|[\xe1-\xec][\x80-\xbf][\x80-\xbf]'
            . '|\xed[\x80-\x9f][\x80-\xbf]'
            . '|[\xee-\xef][\x80-\xbf][\x80-\xbf]'
            . '|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]'
            . '|[\xf1-\xf3][\x80-\xbf][\x80-\xbf][\x80-\xbf]'
            . '|\xf4[\x80-\x8f][\x80-\xbf][\x80-\xbf]'
            . ')/';
        $result = preg_replace($utf8Pattern, '', mb_substr($str, 0, 512));
        if ($result !== '') {
            // 変換に失敗している
            MadoLog::error('Xf002 文字コードの変換に失敗しました。');
            throw new \Exception('文字コードの変換に失敗しました。');
        }

        return $str;
    }

    /**
     * 1次配列の要素全てをUTF-8に変換する
     * 
     * @param array
     * @return array
     */
    public function convertLineToUTF8(array $line)
    {
        return $this->isWindows
            ? array_map(function ($line) {
                return $this->convertToUTF8($line);
            }, $line)
            : $line;
    }

    /**
     * 与えられた文字列の文字コードを判定する
     *
     * @param $str
     * @return mixed
     * @throws \Exception
     */
    public function detectEncoding($str)
    {
        $encoding = ['UTF-8', 'SJIS-win', 'SJIS', 'EUC-JP', 'ASCII', 'JIS'];
        foreach ($encoding as $encode) {
            if (mb_convert_encoding($str, $encode, $encode) == $str) {
                // 変換後の文字列と変換前の文字列が等しければ、実質的に文字コードの変換が発生していない。
                // つまり、変換に用いた文字コードの文字列である
                return $encode;
            }
        }

        MadoLog::error('Xf003 文字コードの判定ができませんでした。');
        throw new \Exception('文字コードの判定ができませんでした。');
    }

    /**
     * 改行コードを変換する
     *
     * @param $str
     * @param string $to
     * @return null|string|string[]
     */
    public function convertLineFeed($str, $to = "\n")
    {
        if (empty($str)) {
            return '';
        }
        return strtr($str, ["\r\n" => $to, "\r" => $to, "\n" => $to]);
    }

    /**
     * CSVファイルを解釈し、配列で返す
     * 
     * 大きいサイズのCSVファイルを扱う場合、サーバのメモリ容量を上げる必要がある
     * 
     * @param string CSV文字列
     * @return array
     */
    public function toArray(string $str)
    {
        // CSVファイルを読み込んだイテレータの取得
        $file = $this->getIterator($str);

        $result = [];
        foreach ($file as $line) {
            $result[] = $this->convertLineToUTF8($line);
        }

        return $result;
    }

    /**
     * 整形したCSV文字列を一時ファイルに保存し、イテレータに読み込ませる
     * 
     * @param string CSV文字列
     * @return \SplTempFileObject
     */
    public function getIterator(string $str)
    {
        $file = new \SplTempFileObject(0);
        $file->fwrite($str);
        $file->rewind();

        // フラグ等の設定
        $file->setFlags(
            \SplFileObject::READ_CSV
            | \SplFileObject::READ_AHEAD
            | \SplFileObject::SKIP_EMPTY
            | \SplFileObject::DROP_NEW_LINE
        );
        $file->setCsvControl(
            $this->delimiter,
            $this->enclosure,
            $this->escape
        );

        return $file;
    }
}
