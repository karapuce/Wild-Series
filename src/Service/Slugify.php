<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input) : string
    {
        $punctuation = array("?",",",";",".",":","!","'","--","---");
        $slug = trim($input);
        $slug = str_replace(" ", "-", $slug);
        $slug = str_replace($punctuation, "", $slug);

        $specialchar = [
            'à','á','â','ã','ä',
            'ç','ñ','ý','ÿ',
            'è','é','ê','ë',
            'ì','í','î','ï',
            'ò','ó','ô','õ','ö',
            'ù','ú','û','ü'
        ];

        $specialReplace = [
            'a','a','a','a','a',
            'c','n','y','y',
            'e','e','e','e',
            'i','i','i','i',
            'o','o','o','o','o',
            'u','u','u','u',
        ];

        $slug = str_replace($specialchar, $specialReplace, $slug);

        return strtolower($slug);
    }

}