<?php

namespace App\Services\Entities\SiteSetting;

use App\Http\Requests\Admin\SiteSettings\SiteSettingRequest;
use App\Models\SiteSetting;
use App\Services\Model\Traits\CrudService;

class SiteSettingService
{
    use CrudService;

    public function saveSettings(SiteSettingRequest $siteSettingRequest)
    {
        $data = $siteSettingRequest->validated();

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate([
                'key' => $key,
            ], [
                'value' => $value,
            ]);
        }
    }

    public function getValuesByKeys($keys)
    {
        $data = [];

        if (is_array($keys)) {
            $resultArr = SiteSetting::whereIn('key', $keys)->pluck('value', 'key')->toArray();

            foreach ($keys as $key) {
                $data[$key] = in_array($key, array_keys($resultArr))
                    ? $resultArr[$key] : null;
            }
        } else {
            $siteSetting = SiteSetting::firstWhere(['key' => $keys]);
            $data = [$keys => $siteSetting->value];
        }

        return $data;
    }
}
