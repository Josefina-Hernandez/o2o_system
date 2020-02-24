<?php

namespace App\Lib;

class CSV
{
    const CSV_LOG = 'CSV_LOG';

    private $delimiter = ',';
    private $enclosure = '"';
    private $header = '';
    private $encoding_from = 'UTF-8';
    private $encoding_to = 'SJIS-WIN';

    public function export_csv($file_path, $data, array $arr_header)
    {
        if ($this->validate_data_export($data) === false) {
            \Debug::log(self::CSV_LOG, 'Data export csv is invalid!');
 
            return false;
        }
        if (count($arr_header) > 0) {
            $this->set_header($arr_header);
        }

        if (strlen($this->header) > 0 && file_exists($file_path) === false) {
            file_put_contents($file_path, $this->header);
        }

        if (count($data) > 0) {
            $result = $this->format_data_csv($data);
            if (file_exists($file_path) === false) {
                file_put_contents($file_path, $result);
            } else {
                $result = "\r\n" . $result;
                file_put_contents($file_path, $result, FILE_APPEND);
            }
        }

        return true;
    }

    private function validate_data_export(array $data)
    {
        if (!is_array($data)) {
            return false;
        }

        $count_sub_array = 0;
        foreach ($data as $row) {
            if (is_array($row)) {
                foreach ($row as $r) {
                    if (is_array($r)) {
                        return false;
                    }
                }

                $count_sub_array++;
            }
        }

        if ($count_sub_array != count($data) && $count_sub_array != 0) {
            return false;
        }

        return true;
    }

    private function format_data_csv($data)
    {
        $csv_data = [];
        foreach ($data as $row) {
            if (is_array($row) === false) {
                break;
            }

            $row = array_map([$this, 'add_enclosure'], $row);
            $row = implode($this->delimiter, $row);
            $csv_data[] = mb_convert_encoding($row, $this->encoding_to, $this->encoding_from);
        }

        if (count($csv_data) > 0) {
            $csv_data = implode("\r\n", $csv_data);
        } else {
            $row = array_map([$this, 'add_enclosure'], $data);
            $row = implode($this->delimiter, $row);
            $csv_data = mb_convert_encoding($row, $this->encoding_to, $this->encoding_from);
        }

        return $csv_data;
    }

    private function set_header(array $headers)
    {
        $headers = array_map([$this, 'add_enclosure'], $headers);
        $this->header = implode($this->delimiter, $headers);
    }

    private function add_enclosure($data)
    {
        if (empty($data)) {
            return;
        }

        return $this->enclosure . $data . $this->enclosure;
    }

    private function set_delemiter($delimiter)
    {
        if (strlen($delimiter) === 1) {
            $this->delimiter = $delimiter;
        } else {
            \Debug::log(self::CSV_LOG, 'Set delemiter csv fail!');
        }
    }

    public function set_enclosure($enclosure)
    {
        if (strlen($enclosure) === 1) {
            $this->enclosure = $enclosure;
        } else {
            \Debug::log(self::CSV_LOG, 'Set enclosure csv fail!');
        }
    }

    public function set_encoding_to($encode)
    {
        if (strlen($encode) > 0) {
            $this->encoding_to = $encode;
        }
    }

    /**
     * get data from csv file
     * @param  string $filename file csv
     * @param  string $delimitor
     * @return array|boolean
     */
    public function seedFromCSV($filename, $delimitor = ",")
    {
        if(!file_exists($filename) || !is_readable($filename))
        {
            return false;
        }
 
        $header = NULL;
        $data = [];
 
        if(($handle = fopen($filename, 'r')) !== false)
        {
            while(($row = fgetcsv($handle, 0, $delimitor)) !== false)
            {
                if(!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
 
        return $data;
    }
}
