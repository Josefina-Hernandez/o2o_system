<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            /*OauthClientsTableSeeder::class,
            PrefsTableSeeder::class,
            CitiesTableSeeder::class,

            ShopClassesTableSeeder::class,
            ShopsTableSeeder::class,
            UsersTableSeeder::class,

            StandardPhotosTableSeeder::class,
            PremiumPhotosTableSeeder::class,
            StandardNoticesTableSeeder::class,
            StaffsTableSeeder::class,
            EmergencyMessagesTableSeeder::class,
            BannersTableSeeder::class,*/
            MailaddressTableSeeder::class,

            ImportDataCheckProduct::class,
            ImportDatactg::class,
            importdata_m_color_trans::class,
            importdata_m_lang::class,
            importdata_m_model_trans::class,
            importdata_m_selling_spec::class,
            importdata_product::class,
            importdata_product_trans::class,
            importdata_m_color_ctg_prod::class,
            importdata_m_color::class,
            importdata_m_selling_spec_trans::class,
            Importdata_ctg_trans::class,
            importdata_m_color_model::class,
            importdata_m_model::class,
            importdata_m_model_spec::class,
            importdata_m_selling_code::class,
            importdata_m_option_selling_code::class,
            importdata_m_spec_group::class,
            importdata_m_special_color_code::class,
            importdata_m_model_item_trans::class,
            importdata_m_model_item_display::class,
            inportdata_m_model_item::class,
            importdata_m_door_closer_color::class,
            importdata_m_option_selling_code_giesta::class,
            importdata_m_selling_code_giesta::class,
            inportdata_m_large_size::class,
            importdata_m_spec_image::class,
            importdata_m_fence_base_recommend_wall::class,
            importdata_m_fence_base_recommend_base::class,
            importdata_m_fence_stright_joint_base::class,
            importdata_m_fence_stright_joint_wall::class,
            importdata_fence_qty_define::class,
            importdata_m_define_hardcode::class,
            importdata_m_rail::class,
            importdata_m_size_limit::class,

            CreateVProductModelReferTable::class,
            CreateVMLargeSizeTable::class,
            CreateVProductPriceReferTable::class,
            CreateVProductGiestaModelReferTable::class,
            CreateVProductPriceGiestaReferTable::class,
            m_product_submenu_table_seeder::class,
        ]);

        //Execute command "php artisan command:create-data-options-refer"
        Artisan::call('command:create-data-options-refer', array(), $this->command->getOutput());
    }
}
