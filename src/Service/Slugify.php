<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input) : string
    {
        $punctuation = array("?",",",";",".",":","!","'");
        $slug = trim($input);
        $slug = str_replace(" ", "-", $slug);
        $slug = str_replace($punctuation, "", $slug);
        if (strpos($slug,"--")) {
            while (strpos($slug,"--")) {
                $slug = str_replace("--", "-", $slug);
            }
        }

        return strtolower($slug);
    }

}