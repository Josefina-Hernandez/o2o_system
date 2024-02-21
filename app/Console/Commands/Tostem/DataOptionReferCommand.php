<?php

namespace App\Console\Commands\Tostem;

use Illuminate\Console\Command;
use DB;

class DataOptionReferCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create-data-options-refer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->processDataOption();
        $this->processDataOptionGiesta();
    }

    public function processDataOption() {

    	$this->info('Start import data normal. ');

    	$argOptionParams = DB::Select(config('sql_building.select.OPTIONS_LIST_PARAM'));
    	$table = 'v_option_refer';

    	$progressBar = $this->output->createProgressBar(count($argOptionParams));
    	$progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%');

        if(count($argOptionParams) > 0) {

        	$progressBar->start();

        	foreach($argOptionParams as $index => $value) {
        		$params = [
					'lang_code'  => $value->lang_code,
					'ctg_id'     => $value->ctg_id,
					'product_id' => $value->product_id,
					'm_model_id' => $value->m_model_id,
				];

				$sql = str_replace('(:viewer_flg)', '('. $value->viewer_flg .')', config('sql_building.select.OPTIONS'));
				foreach ($params as $keyParam => $param) {
					if($keyParam == 'lang_code') {
						$sql = str_replace(':'.$keyParam, "'".$param."'", $sql);
					} else {
						$sql = str_replace(':'.$keyParam, $param, $sql);
					}
				}

				try {

					if($index == 0) {
						$sqlCreate = "CREATE OR REPLACE TABLE $table ($sql)";
						//Tạo table
						DB::statement(str_replace('ORDER BY tb.selling_code ASC', ' WHERE 1=2 ORDER BY tb.selling_code ASC', $sqlCreate));
						$this->output->newLine();
						$this->output->write("<info> Create table done. </info>");
						//Tạo khoá chính
						DB::statement("ALTER TABLE $table ADD v_option_refer_id INT PRIMARY KEY AUTO_INCREMENT");
						$this->output->newLine();
						$this->output->write("<info> Create primary key done. </info>");
						//Tạo index
						$sqlIndex = "ALTER TABLE $table ADD KEY `index_v_option_refer` (`lang_code`,`ctg_id`,`product_id`,`m_model_id`,`p_viewer_flg`,`m_viewer_flg`) ";
						DB::statement($sqlIndex);
						$this->output->newLine();
						$this->output->write("<info> Create index done. </info>");
					}

					$sqlInsert = "INSERT INTO $table(
						louver_description_extra,
						order_no,
						stack_number,
						stack_height,
						fence_type,
						gate_type,
						exterior_panel_type,
						m_model_id,
						lang_code,
						ctg_id,
						product_id,
						p_viewer_flg,
						m_viewer_flg,
						model_name_display,
						series_name,
						product_name,
						img_path_result,
						img_name_result,
						m_color_id,
						color_name,
						color_code_price,
						img_path,
						img_name,
						selling_code,
						img_path_spec29,
						img_name_spec29,
						option1,
						option2,
						option3,
						option5, -- Add BP_O2OQ-6 MinhVnit 20200625 
						_option5_img_path, -- Add BP_O2OQ-27 MinhVnit 20210819
						_option5_img_name, -- Add BP_O2OQ-27 MinhVnit 20210819
						option6, -- Add BP_O2OQ-6 MinhVnit 20200625 
						option7, -- Add BP_O2OQ-27 MinhVnit 20210819
						option8, -- Add BP_O2OQ-27 MinhVnit 20210819
						option9, -- Add BP_O2OQ-29 MinhVnit 20211029
						option10, -- Add BP_O2OQ-29 MinhVnit 20211029
						option11, -- Add BP_O2OQ-29 MinhVnit 20211029
						option12, -- Added by Anlu AKT 20240209
						option13, -- Added by Anlu AKT 20240221
						spec1,
						spec2,
						spec3,
						spec4,
						spec5,
						spec6,
						spec7,
						spec8,
						spec9,
						spec10,
						spec11,
						spec12,
						spec13,
						spec14,
						spec15,
						spec16,
						spec17,
						spec18,
						spec19,
						spec20,
						spec21,
						spec22,
						spec23,
						spec24,
						spec25,
						spec26,
						spec27,
						spec28,
						spec29,
						spec30,
						spec31,
						spec32, -- Add BP_O2OQ-6 MinhVnit 20200625 
						spec33, -- Add BP_O2OQ-6 MinhVnit 20200625 
						spec34, -- Add BP_O2OQ-6 MinhVnit 20200625 
						spec35, -- Add BP_O2OQ-6 MinhVnit 20200710
						spec36, -- Add BP_O2OQ-6 MinhVnit 20200710 
						spec37, -- Add BP_O2OQ-9 MinhVnit 20200901 
						spec38, -- Add BP_O2OQ-27 MinhVnit 20210819 
						spec39, -- Add BP_O2OQ-27 MinhVnit 20210819
						spec40, -- Add BP_O2OQ-27 MinhVnit 20210819
						spec41, -- Add BP_O2OQ-29 MinhVnit 20211103
						_option_color_id, -- Add BP_O2OQ-29 MinhVnit 20211102
						_option_color_name, -- Add BP_O2OQ-29 MinhVnit 20211102
						width,
						height,
						amount,
						hidden_storage_flg
					) $sql";

					DB::statement($sqlInsert);
					$this->output->newLine();
					$this->output->write("<info> Insert $index done. </info>");

					DB::statement("
						UPDATE v_option_refer
						SET hidden_storage_flg = 1
						WHERE
							lang_code = :lang_code
							AND ctg_id = :ctg_id
							AND product_id = :product_id
							AND m_model_id = :m_model_id
							AND hidden_storage_flg = 0
					", $params);
					$this->output->newLine();
					$this->output->write("<info> Update hidden_storage_flg done. </info>");

					$progressBar->advance();

				} catch (Exception $e) {
					$this->info('Error:');
					$this->info($params);
				}
        	}

        	$progressBar->finish();

        } else {
        	$this->info('OPTIONS_LIST_PARAM empty.');
        }
    }

    public function processDataOptionGiesta() {
    	$this->output->newLine();
    	$this->info('Start import for GIESTA. ');

    	$argOptionParams = DB::Select(config('sql_building.select.OPTIONS_GIESTA_LIST_PARAM'));
    	$table = 'v_option_giesta_refer';

    	$progressBar = $this->output->createProgressBar(count($argOptionParams));
    	$progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%');

        if(count($argOptionParams) > 0) {

        	$progressBar->start();

        	foreach($argOptionParams as $index => $value) {

        		$params = [
					'lang_code'  => $value->lang_code,
					'ctg_id'     => $value->ctg_id,
					'product_id' => $value->product_id,
					'm_model_id' => $value->m_model_id,
				];

				$sql = str_replace('(:viewer_flg)', '('. $value->viewer_flg .')', config('sql_building.select.SELECT_MAIN_PANEL_GIESTA'));

				foreach ($params as $keyParam => $param) {
					if($keyParam == 'lang_code') {
						$sql = str_replace(':'.$keyParam, "'".$param."'", $sql);
					} else {
						$sql = str_replace(':'.$keyParam, $param, $sql);
					}
				}

				try {

					if($index == 0) {
						$sqlCreate = "CREATE OR REPLACE TABLE $table ($sql)";
						//Tạo table
						DB::statement(str_replace('ORDER BY sc.selling_code ASC', ' AND 1=2 ORDER BY sc.selling_code ASC', $sqlCreate));
						$this->output->newLine();
						$this->output->write("<info> Create table done. </info>");
						//Tạo khoá chính
						DB::statement("ALTER TABLE $table ADD v_option_giesta_refer_id INT PRIMARY KEY AUTO_INCREMENT");
						$this->output->newLine();
						$this->output->write("<info> Create primary key done. </info>");
						//Tạo index
						$sqlIndex = "ALTER TABLE $table ADD KEY `index_v_option_refer` (`lang_code`,`ctg_id`,`product_id`,`m_model_id`,`p_viewer_flg`,`m_viewer_flg`) ";
						DB::statement($sqlIndex);
						$this->output->newLine();
						$this->output->write("<info> Create index done. </info>");
					}

					$sqlInsert = "INSERT INTO $table(
						m_model_id,
						lang_code,
						ctg_id,
						product_id,
						model_name_display,
						series_name,
						order_no,
						product_name,
						p_viewer_flg,
						m_viewer_flg,
						img_path_result,
						img_name_result,
						m_color_id,
						color_name,
						color_code_price,
						img_path,
						img_name,
						selling_code,
						spec51,
						img_path_spec51,
						img_name_spec51,
						spec53,
						spec54,
						spec55,
						spec52,
						spec56,
						spec57,
						width,
						height,
						amount,
						hidden_storage_flg
					) $sql";

					DB::statement($sqlInsert);
					$this->output->newLine();
					$this->output->write("<info> Insert $index done. </info>");
					DB::statement("
						UPDATE $table
						SET hidden_storage_flg = 1
						WHERE
							lang_code = :lang_code
							AND ctg_id = :ctg_id
							AND product_id = :product_id
							AND m_model_id = :m_model_id
							AND hidden_storage_flg = 0
					", $params);
					$this->output->newLine();
					$this->output->write("<info> Update hidden_storage_flg done. </info>");
					$progressBar->advance();

				} catch (Exception $e) {
					$this->info('Error:');
					$this->info($params);
				}
        	}
			$progressBar->finish();
        } else {
        	$this->info('OPTIONS_GIESTA_LIST_PARAM empty.');
        }
    }
}
