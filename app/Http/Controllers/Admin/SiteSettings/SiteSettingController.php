<?php

namespace App\Http\Controllers\Admin\SiteSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiteSettings\SiteSettingRequest;
use App\Services\Entities\SiteSetting\SiteSettingService;
use App\Services\Http\Response\APIResponse;

class SiteSettingController extends Controller
{
    public function index()
    {
        return view('admin.site-settings.index');
    }

    public function store(SiteSettingRequest $request, SiteSettingService $siteSettingService)
    {
        $siteSettingService->saveSettings($request);

        return APIResponse::build()
            ->status('success')
            ->message('Site settings updated!')
            ->messageDisplayDuration(1000)
            ->refresh()
            ->send();
    }
}
