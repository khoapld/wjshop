<?php

use Fuel\Core\Config;

class Uri extends \Fuel\Core\Uri
{

    public function __construct($uri = NULL)
    {
        parent::__construct($uri);
        $this->detect_language();
    }

    public function detect_language()
    {
        if (!count($this->segments)) {
            return false;
        }

        $first = $this->segments[0];
        $locales = Config::get('locales');

        if (array_key_exists($first, $locales)) {
            array_shift($this->segments);
            $this->uri = implode('/', $this->segments);

            Config::set('language', $first);
            Config::set('locale', $locales[$first]);
        }
    }

    public static function generate($uri = null, $variables = array(), $get_variables = array(), $secure = null)
    {
        $language = Config::get('language');

        if (!empty($uri)) {
            $language .= '/';
        }

        return Uri::create($language . $uri, $variables, $get_variables, $secure);
    }

}
