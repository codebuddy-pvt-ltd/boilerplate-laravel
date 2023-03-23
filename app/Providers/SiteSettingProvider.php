<?php

namespace App\Providers;

use App\Services\Entities\SiteSetting\SiteSettingService;
use Illuminate\Support\ServiceProvider;

class SiteSettingProvider extends ServiceProvider
{
    /** @var SiteSettingService */
    public $siteSettingService;

    public function __construct()
    {
        $this->siteSettingService = resolve(SiteSettingService::class);
    }

    public function boot()
    {
        $siteSettings = $this->siteSettingService->getValuesByKeys(array_keys(config('site-settings')));

        foreach ($siteSettings as $key => $value) {
            $prefix = 'site_setting_';
            view()->share($prefix . $key, $value);
        }
    }
}
