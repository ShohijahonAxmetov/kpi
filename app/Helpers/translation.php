<?php

use App\Models\Translation;

function translation($key) {
    $lang = app()->getLocale();
    $current_lang_item = isset(Translation::where('key', $key)->pluck('val')->toArray()[0][$lang]) ? Translation::where('key', $key)->pluck('val')->toArray()[0][$lang] : null;

    if(!$current_lang_item) {
        $current_lang_item = isset(Translation::where('key', $key)->pluck('val')->toArray()[0]['ru']) ? Translation::where('key', $key)->pluck('val')->toArray()[0]['ru'] : null;
    }

    return $current_lang_item;
}
