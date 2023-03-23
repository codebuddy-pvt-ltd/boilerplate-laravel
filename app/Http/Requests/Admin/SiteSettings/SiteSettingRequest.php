<?php

namespace App\Http\Requests\Admin\SiteSettings;

use Illuminate\Foundation\Http\FormRequest;

class SiteSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'admin_site_logo' => 'nullable',
            'admin_site_favicon' => 'nullable',
            'admin_primary_color' => 'required',
            'admin_secondary_color' => 'required',
            'admin_footer_text' => 'nullable',
        ];
    }
}
