<?php

// format number Rp 11,000
if (!function_exists('formatRupiah')) {
    function formatRupiah($number)
    {
        return 'Rp ' . number_format($number, 0);
    }
}

// format number 11.000
if (!function_exists('formatNumber')) {
    function formatNumber($number)
    {
        return number_format($number, 0);
    }
}

// rupiah to number
if (!function_exists('rupiahToNumber')) {
    function rupiahToNumber($number)
    {
        return str_replace(',', '', str_replace('Rp ', '', $number));
    }
}


// fungsi tinymce,jika ada tag gambar maka didalam srce replace ../ env('BASE_URL')/
if (!function_exists('tinymceReplace')) {
    function tinymceReplace($content)
    {
        return preg_replace_callback('/src="([^"]+)"/', function ($matches) {
            $src = $matches[1];
            if (strpos($src, '../') === 0) {
                $src = env('APP_URL') . '/' . substr($src, 3);
            }
            return 'src="' . $src . '"';
        }, $content);
    }
}
