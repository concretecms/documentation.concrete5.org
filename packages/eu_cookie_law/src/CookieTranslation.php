<?php

/**
 * Project: EU Cookie Law Add-On
 *
 * @copyright 2017 Fabian Bitter
 * @author Fabian Bitter (f.bitter@bitter-webentwicklung.de)
 * @version 1.0.1.2
 */

namespace Concrete\Package\EuCookieLaw\Src;

defined('C5_EXECUTE') or die('Access denied');

use Concrete\Package\EuCookieLaw\Src\Enumerations\Languages;
use Concrete\Package\EuCookieLaw\Src\CookieSettings;
use MoReader\Reader;
use Request;

class CookieTranslation
{
    private static $instance = null;
    private $customTextElements = array();

    /**
     * @return CookieTranslation
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->loadLanguageFile();
    }

    public function loadLanguageFile()
    {
        $this->customTextElements = array();
        
        $moFile = DIR_PACKAGES . "/eu_cookie_law/languages/" . $this->getLocale() . "/LC_MESSAGES/messages.mo";

        if (file_exists($moFile)) {
            $parser = new Reader;

            $this->customTextElements = $parser->load($moFile);
        }
    }

    /**
     *
     * @return array
     */
    private function getSupportedLocales()
    {
        return array("ar_SA", "en_US", "de_DE", "bg_BG", "hr_HR", "cs_CZ", "da_DK", "nl_NL", "et_EE", "fi_FL", "fr_FR", "el_GR", "hu_HU", "en_IE", "et_IT", "lv_LV", "lt_LT", "mt_MT", "pl_PL", "pt_PT", "ro_RO", "sk_SK", "sl_SI", "es_ES", "sv_FI");
    }

    /**
     *
     * @param string $locale
     * @return boolean
     */
    private function isValidLocale($locale)
    {
        return in_array($locale, $this->getSupportedLocales());
    }

    private function getDefaultLocale()
    {
        return "en_US";
    }

    /**
     *
     * @return array
     */
    private function getUsersPreferedLocale()
    {
        /**
         * Credits to Jesse Skinner for this algorithm
         *
         * http://www.thefutureoftheweb.com/blog/use-accept-language-header
         */
        if (Request::getInstance()->server->get("HTTP_ACCEPT_LANGUAGE") !== null) {
            $langs = array();

            $lang_parse = array();
            
            // break up string into pieces (languages and q factors)
            preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', Request::getInstance()->server->get("HTTP_ACCEPT_LANGUAGE"), $lang_parse);

            if (count($lang_parse[1])) {
                // create a list like "en" => 0.8
                $langs = array_combine($lang_parse[1], $lang_parse[4]);

                foreach ($langs as $lang => $val) {
                    if ($val === '') {
                        $langs[$lang] = 1;
                    }
                }

                // sort list based on value
                arsort($langs, SORT_NUMERIC);
            }
        }

        return $langs;
    }

    /**
     *
     * @param string $locale
     *
     * @return boolean
     */
    private function isShortLocale($locale)
    {
        return (strlen($locale) === 2);
    }

    /**
     *
     * @param string $shortLocale
     *
     * @return string
     */
    private function getLongLocale($shortLocale)
    {
        switch ($shortLocale) {
            case "en": return "en_US";
            case "de": return "de_DE";
            case "bg": return "bg_BG";
            case "hr": return "hr_HR";
            case "cs": return "cs_CZ";
            case "da": return "da_DK";
            case "nl": return "nl_NL";
            case "et": return "et_EE";
            case "fi": return "fi_FL";
            case "fr": return "fr_FR";
            case "el": return "el_GR";
            case "hu": return "hu_HU";
            case "it": return "et_IT";
            case "lv": return "lv_LV";
            case "lt": return "lt_LT";
            case "mt": return "mt_MT";
            case "pl": return "pl_PL";
            case "pt": return "pt_PT";
            case "ro": return "ro_RO";
            case "sk": return "sk_SK";
            case "sl": return "sl_SI";
            case "es": return "es_ES";
            case "sv": return "sv_FI";
            case "ar": return "ar_SA";
            default: return false;
        }
    }

    /**
     *
     * @param string $locale
     * @return boolean
     */
    private function isValidShortLocale($locale)
    {
        return $this->getLongLocale($locale) !== false;
    }

    /**
     *
     * @param string $locale
     *
     * @return boolean
     */
    private function isLongLocale($locale)
    {
        return (strlen($locale) === 5);
    }
    
    /**
     *
     * @param string $locale
     *
     * @return string
     */
    private function beautifyLocale($locale)
    {
        if ($this->isShortLocale($locale)) {
            return strtolower($locale);
        } elseif ($this->isLongLocale($locale)) {
            return strtolower(substr($locale, 0, 2)) . "_" . strtoupper(substr($locale, 3, 2));
        } else {
            return "";
        }
    }

    public function getLocale()
    {
        $settings = new CookieSettings;
      
        if ($settings->getLanguage() == Languages::AUTO) {
            if (is_array($this->getUsersPreferedLocale())) {
                foreach ($this->getUsersPreferedLocale() as $locale => $priority) {
                    $locale = $this->beautifyLocale($locale);

                    if ($this->isValidLocale($locale)) {
                        return $locale;
                    } elseif ($this->isValidShortLocale($locale)) {
                        return $this->getLongLocale($locale);
                    }

                    unset($priority);
                }
            }

            return $this->getDefaultLocale();
        } else {
            return $settings->getLanguage();
        }
    }

    /**
     *
     * @param string $orginalString
     *
     * @return string
     */
    public function getTranslation($orginalString)
    {
        $text = $orginalString;

        if (is_array($this->customTextElements)) {
            if (isset($this->customTextElements[$orginalString])) {
                $text = $this->customTextElements[$orginalString];
            }
        }

        $args = func_get_args();

        array_shift($args);

        return vsprintf($text, $args);
    }
}
