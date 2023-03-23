<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

if (!function_exists('isProductionEnv')) {
    function isProductionEnv(): bool
    {
        return in_array(strtolower(config('app.env')), [
            'live',
            'prod',
            'production',
        ]);
    }
}

if (!function_exists('isStagingEnv')) {
    function isStagingEnv(): bool
    {
        return in_array(strtolower(config('app.env')), [
            'stage',
            'staging',
        ]);
    }
}

if (!function_exists('isDevelopmentEnv')) {
    function isDevelopmentEnv(): bool
    {
        return in_array(strtolower(config('app.env')), [
            'dev',
            'development',
        ]);
    }
}

if (!function_exists('isLocalEnv')) {
    function isLocalEnv(): bool
    {
        return in_array(strtolower(config('app.env')), [
            'local',
        ]);
    }
}

if (!function_exists('isTestingEnv')) {
    function isTestingEnv(): bool
    {
        return in_array(strtolower(config('app.env')), [
            'test',
            'testing',
        ]);
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile(?UploadedFile $file, string $folder, string $fileName = null): ?string
    {
        if (!$file) {
            return null;
        }

        $disk = storageDisk();

        if ($fileName) {
            return $file->storeAs($folder, $fileName, $disk);
        } else {
            return $file->store($folder, $disk);
        }
    }
}

if (!function_exists('storageDisk')) {
    function storageDisk(): string
    {
        return isProductionEnv() ? 's3' : 'local';
    }
}

if (!function_exists('publicFileUrl')) {
    function publicFileUrl(?string $file): ?string
    {
        if (empty($file)) {
            return null;
        }

        $disk = storageDisk();
        $path = Storage::disk($disk);
        if ($disk === 's3') {
            $expiry = now()->addWeek();

            return $path->temporaryUrl($file, $expiry);
        } else {
            return $path->url($file);
        }
    }
}

if (!function_exists('removeFile')) {
    function removeFile(?string $path): ?bool
    {
        if (empty($path)) {
            return null;
        }

        $disk = storageDisk();

        return Storage::disk($disk)->delete($path);
    }
}

if (!function_exists('isRequestForAPI')) {
    function isRequestForAPI(): bool
    {
        return request()->is('api*');
    }
}

if (!function_exists('getAdminSiteLogo')) {
    function getAdminSiteLogo($adminSiteLogo): string
    {
        if (publicFileUrl($adminSiteLogo)) {
            return publicFileUrl($adminSiteLogo);
        } else {
            return asset('admin/assets/images/logo.svg');
        }
    }
}

if (!function_exists('getAdminSiteFavicon')) {
    function getAdminSiteFavicon($adminSiteFavicon): string
    {
        if (publicFileUrl($adminSiteFavicon)) {
            return publicFileUrl($adminSiteFavicon);
        } else {
            return asset('admin/assets/images/favicon.svg');
        }
    }
}
