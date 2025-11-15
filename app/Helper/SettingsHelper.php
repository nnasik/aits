<?php

use App\Models\Setting;

if (!function_exists('system_setting')) {
    function system_setting($key, $default = null)
    {
        return Setting::where('key', $key)->value('value') ?? $default;
    }
}
