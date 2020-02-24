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
            OauthClientsTableSeeder::class,
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
            BannersTableSeeder::class,
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
            importdata_m_spec_group::class,
            importdata_m_special_color_code::class,

            CreateVProductModelReferTable::class,
        ]);
    }
}
