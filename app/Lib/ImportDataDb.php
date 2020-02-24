<?php

namespace App\Lib;

class ImportDataDb
{
	public function export_txt($file, $txtmode = false) // $txtmode = true; delete txt_file before generate new file txt.
    {
        if (file_exists($file) === false) {
            return false;
        }
        
        $txt_file = $this->get_path_file_txt($file);

        if ($txtmode === true &&
        	file_exists($txt_file) === true
        ) {
        	unlink($txt_file);
        }

        $linux_cmd = "ssconvert -O 'separator=_\\t, eol=windows quote=' " . $file . ' ' . $txt_file;
        shell_exec($linux_cmd);
        if (file_exists($txt_file) === false) {
            return false;
        }

        return $txt_file;
    }
    
   public function export_txt_with_sheet_name($file, $name_sheet,$txtmode = false) // $txtmode = true; delete txt_file before generate new file txt.
    {
        if (file_exists($file) === false) {
            return false;
        }
        
        $txt_file = $this->get_path_file_txt($file);

        if ($txtmode === true &&
        	file_exists($txt_file) === true
        ) {
        	unlink($txt_file);
        }
        $linux_cmd = "ssconvert  -O  ' sheet=\"$name_sheet\" separator=_\\t, eol=windows quote=' " . $file . ' ' . $txt_file;
        shell_exec($linux_cmd);
        if (file_exists($txt_file) === false) {
            return false;
        }

        return $txt_file;
    }
    
    public function export_txt_flow_list_sheet($file, $index_sheet,$txtmode = false) // $txtmode = true; delete txt_file before generate new file txt.
    {
        if (file_exists($file) === false) {
            return false;
        }
        
        $txt_file = $this->get_path_file_txt($file);
        
        if ($txtmode === true &&
        	file_exists($txt_file) === true
        ) {
        	unlink($txt_file);
        }

        $linux_cmd = "ssconvert -S --export-type=Gnumeric_stf:stf_assistant  -O ' separator=_\\t, eol=windows quote=' " . $file . ' ' . $txt_file;
        shell_exec($linux_cmd);
        $txt_file = $txt_file.'.'.$index_sheet;
        if (file_exists($txt_file) === false) {
            return false;
        }

        return $txt_file;
    }
    
    
    
    
    public function get_path_file_txt($excel_file)
    {
        if (file_exists($excel_file) === false) {
            return '';
        }

        $file_name = pathinfo($excel_file, PATHINFO_FILENAME);
        $txt_file = pathinfo($excel_file, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . $file_name . '.txt';

        return $txt_file;
    }

    public function extract_data_from_txt($txtfile, $index_column, $index_data)
    {
        $data = file_get_contents($txtfile);

        $data_array = array_filter(explode("\r\n", $data));
        $data_txt = array_map(function ($row) {
            return explode("_\\t,", $row);
        }, $data_array);
        
        $count_column = 0;
        if (count($data_txt) > 0) {
            $count_column = count($data_txt[0]);
        } else {
            return;
        }

        foreach ($data_txt as $k => $row_txt) {
            if (count($row_txt) != $count_column) {
                unset($data_txt[$k]);
            }
        }

        $result = [];
        $columns = [];
        $datas = [];
        foreach ($data_txt as $k => $data) {
            if ($index_column == $k) {
                $columns = $data;
                continue;
            }

            if ($k < $index_data) {
                continue;
            }

            $datas[] = $data;
        }

        $result['columns'] = $columns;
        $result['datas'] = $datas;
        
        return $result;
    }

    public function generate_columndb_value($datas, $columns)
    {
        $count_column = count($columns);

        $result = [];
        foreach ($datas as $data) {
            $data_trim = [];
            foreach ($data as $key => $value) {
                $data_trim[] = trim($value);
            }

            $count_data = count($data_trim);
            if ($count_data === $count_column) {
                $result[] = array_combine($columns, $data_trim);
            } else {
                for ($i = 0; $i < $count_data - $count_column; $i++) { 
                    unset($data_trim[$count_data - $i - 1]);
                }

                $result[] = array_combine($columns, $data_trim);
            }
        }

        return $result;
    }

    public function insert_db($table, $data_insert)
    {
    	try {
            \DB::connection(config('settings.connect_db2'))->beginTransaction();

            if (count($data_insert) > 1000) {
                $data_chunk = array_chunk($data_insert, 1000);

                foreach ($data_chunk as $data) {
                    \DB::connection(config('settings.connect_db2'))->table($table)->insert($data);
                }
            } else {
                \DB::connection(config('settings.connect_db2'))->table($table)->insert($data_insert);
            }

            \DB::connection(config('settings.connect_db2'))->commit();

            return true;
        } catch (\Exception $e) {
            \DB::connection(config('settings.connect_db2'))->rollback();

            \Log::info(json_encode($e->getMessage()));

            return false;
        }
    }

    public function truncate_db($table)
    {
        try {
            \DB::connection(config('settings.connect_db2'))->statement('SET FOREIGN_KEY_CHECKS=0;');
            \DB::connection(config('settings.connect_db2'))->table($table)->truncate();
        } catch (Exception $e) {
            \DB::connection(config('settings.connect_db2'))->statement('SET FOREIGN_KEY_CHECKS=1;');
            
            return false;
        }

        \DB::connection(config('settings.connect_db2'))->statement('SET FOREIGN_KEY_CHECKS=1;');
        return true;
    }

    public function check_spec_content($data_insert, $spec_content, $specs)
    {
        $arr_error = [];

        foreach ($data_insert as $k => $data) {
            foreach ($specs as $spec) {
                if (
                    $data[$spec] !== '' &&
                    !in_array($data[$spec], $spec_content[$spec])
                ) {
                    
                    if (
                        isset($arr_error[$spec]) &&
                        in_array($data[$spec], $arr_error[$spec])
                    ) {
                        continue;
                    }

                    $arr_error[$spec][] = $data[$spec];
                }
            }
        }

        return $arr_error;
    }

    public function check_spec_content_model_no($data_insert)
    {
        $model_no = \DB::connection(config('settings.connect_db2'))->table('m_spec_content')->where('m_spec_id', 'model_no')->pluck('spec_content')->all();
        
        $arr_error = [];
        foreach ($data_insert as $k => $data) {
            if (
                isset($data['model_no']) &&
                !in_array($data['model_no'], $model_no)
            ) {
                $arr_error[] = $data['model_no'];
            }            
        }

        return array_unique($arr_error);
    }

    public function remove_line_break_specvalue(&$spec_content)
    {
        foreach ($spec_content as $key => $arr) {
            if ('spec0002' == $key) {
                foreach ($arr as $spec_key => $spec) {
                    $spec_content[$key][$spec_key] = preg_replace("/\r|\n|\r\n/", "", $spec);//REPLACE(v2.spec0002, '\r\n', '')
                }
            }
        }
    }

    public function check_spec_content_product_image_mapping($data_insert, $spec_content, $specs)
    {
        $arr_error = [];

        $spec_mapping = $this->get_product_spec_image_mapping();

        foreach ($data_insert as $k => $data) {
            foreach ($specs as $spec) {
                if (
                    $data[$spec] !== '' &&
                    !in_array($data[$spec], $spec_content[$spec])
                ) {
                    if (
                        $spec == 'spec0002' &&
                        in_array($data[$spec], $spec_mapping)
                    ) {
                        continue;
                    }

                    if (
                        isset($arr_error[$spec]) &&
                        in_array($data[$spec], $arr_error[$spec])
                    ) {
                        continue;
                    }

                    $arr_error[$spec][] = $data[$spec];
                }
            }
        }

        return $arr_error;
    }

    public function get_spec_content($specs)
    {
        $arr_data = [];
        foreach ($specs as $spec) {
            $arr_data[$spec] = \DB::connection(config('settings.connect_db2'))->table('m_spec_content')->where('m_spec_id', $spec)->pluck('spec_content')->all();
        }

        return $arr_data;
    }

    public function get_product_spec_image_mapping()
    {
        $result = [];
        $result = \DB::connection(config('settings.connect_db2'))->table('t_product_spec_image_mapping')->pluck('t_product_spec_image')->all();

        return $result;
    }

    public function seeder_data($txt_file, $column_db, $table)
    {
        if (file_exists($txt_file) === true) {
            $datas = $this->extract_data_from_txt($txt_file, 0, 1);
            $data_insert = $this->generate_columndb_value($datas['datas'], $column_db);

            if ($this->insert_db($table, $data_insert) === true) {
                return "Seeder table: $table success!" . PHP_EOL;
            } else {
                return "Seeder table: $table fail, please check log file!" . PHP_EOL;
            }
        } else {
            return "Seeder table: $table fail, file " . basename($txt_file) . " not exists!" . PHP_EOL;
        }
    }
}

