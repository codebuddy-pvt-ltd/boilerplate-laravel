<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteSetting::truncate();
        SiteSetting::insert([
            [
                'key' => config('site-settings.admin_primary_color.key'),
                'value' => config('site-settings.admin_primary_color.default'),
            ],
            [
                'key' => config('site-settings.admin_secondary_color.key'),
                'value' => config('site-settings.admin_secondary_color.default'),
            ],
            [
                'key' => config('site-settings.admin_site_favicon.key'),
                'value' => config('site-settings.admin_site_favicon.default'),
            ],
            [
                'key' => config('site-settings.admin_site_logo.key'),
                'value' => config('site-settings.admin_site_logo.default'),
            ],
            [
                'key' => config('site-settings.admin_footer_text.key'),
                'value' => config('site-settings.admin_footer_text.default'),
            ],
        ]);
    }
}
