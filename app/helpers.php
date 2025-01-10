<?php


if (!function_exists('fkr')) {
    function fkr($lang = 'ar', $class = null)
    {
        if ($lang == "ar") {
            $lang = "ar_SA";
        } elseif ($lang == "en") {
            $lang = "en_US";
        }

        $fkr = Faker\Factory::create($lang);
        if (!empty($class)) {
            $myclass = 'Faker\\Provider\en_US\\' . $class;
            $fkr->addProvider(new $myclass($fkr));
        }
        return $fkr;
    }
}





