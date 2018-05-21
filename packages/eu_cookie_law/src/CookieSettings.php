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

use Concrete\Package\EuCookieLaw\Src\Helpers;
use Concrete\Package\EuCookieLaw\Src\Enumerations\Methods;
use Concrete\Package\EuCookieLaw\Src\Enumerations\Languages;
use Package;
use Loader;
use Page;

class CookieSettings
{
    private $package;

    public function __construct()
    {
        $this->package = Package::getByHandle('eu_cookie_law');
    }

    public function getPositions()
    {
        return array(
            "bottom" => t("Bottom"),
            "top" => t("Top")
        );
    }

    private function getPositionValues()
    {
        return Helpers::getKeys($this->getPositions());
    }

    private function getSetting($keyName, $defaultValue)
    {
        return $this->package->getConfig()->get($keyName, $defaultValue);
    }

    private function setSetting($keyName, $value)
    {
        return $this->package->getConfig()->save($keyName, $value);
    }

    public function getPosition()
    {
        return $this->getSetting("settings.position", "bottom");
    }

    public function setPosition($position)
    {
        if (in_array($position, $this->getPositionValues())) {
            return $this->setSetting("settings.position", $position);
        } else {
            return false;
        }
    }

    public function getPopupBackgroundColor()
    {
        return $this->getSetting("settings.popup_background_color", "#75ca2a");
    }

    public function setPopupBackgroundColor($color)
    {
        if (Helpers::isValidColor($color)) {
            return $this->setSetting("settings.popup_background_color", $color);
        } else {
            return false;
        }
    }

    public function getPopupTextColor()
    {
        return $this->getSetting("settings.popup_text_color", "#ffffff");
    }

    public function setPopupTextColor($color)
    {
        if (Helpers::isValidColor($color)) {
            return $this->setSetting("settings.popup_text_color", $color);
        } else {
            return false;
        }
    }

    public function getPrimaryButtonTextColor()
    {
        return $this->getSetting("settings.primary_button_text_color", "#75ca2a");
    }

    public function setPrimaryButtonTextColor($color)
    {
        if (Helpers::isValidColor($color)) {
            return $this->setSetting("settings.primary_button_text_color", $color);
        } else {
            return false;
        }
    }

    public function getPrimaryButtonBackgroundColor()
    {
        return $this->getSetting("settings.primary_button_background_color", "#ffffff");
    }

    public function setPrimaryButtonBackgroundColor($color)
    {
        if (Helpers::isValidColor($color)) {
            return $this->setSetting("settings.primary_button_background_color", $color);
        } else {
            return false;
        }
    }

    public function getPrimaryButtonBorderColor()
    {
        return $this->getSetting("settings.primary_button_border_color", "#ffffff");
    }

    public function setPrimaryButtonBorderColor($color)
    {
        if (Helpers::isValidColor($color)) {
            return $this->setSetting("settings.primary_button_border_color", $color);
        } else {
            return false;
        }
    }

    public function getSecondaryButtonTextColor()
    {
        return $this->getSetting("settings.secondary_button_text_color", "#ffffff");
    }

    public function setSecondaryButtonTextColor($color)
    {
        if (Helpers::isValidColor($color)) {
            return $this->setSetting("settings.secondary_button_text_color", $color);
        } else {
            return false;
        }
    }

    public function getSecondaryButtonBackgroundColor()
    {
        return $this->getSetting("settings.secondary_button_background_color", "#fb1515");
    }

    public function setSecondaryButtonBackgroundColor($color)
    {
        if (Helpers::isValidColor($color)) {
            return $this->setSetting("settings.secondary_button_background_color", $color);
        } else {
            return false;
        }
    }

    public function getSecondaryButtonBorderColor()
    {
        return $this->getSetting("settings.secondary_button_border_color", "#fb1515");
    }

    public function setSecondaryButtonBorderColor($color)
    {
        if (Helpers::isValidColor($color)) {
            return $this->setSetting("settings.secondary_button_border_color", $color);
        } else {
            return false;
        }
    }

    /**
     * @return integer
     */
    public function getPrivacyPageId()
    {
        return $this->getSetting("settings.privacy_page_id", 0);
    }

    /**
     * @param integer $pageId
     *
     * @return boolean
     */
    public function setPrivacyPageId($pageId)
    {
        if (Helpers::isValidPageId($pageId)) {
            return $this->setSetting("settings.privacy_page_id", $pageId);
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getPrivacyPageUrl()
    {
        if (Helpers::isValidPageId($this->getPrivacyPageId())) {
            $navHelper = Loader::helper('navigation');

            return $navHelper::getLinkToCollection(Page::getById($this->getPrivacyPageId()));
        }
    }


    /**
     * @param array $arrSettings
     *
     * @return boolean
     */
    public function apply($arrSettings)
    {
        if (is_array($arrSettings)) {
            if (isset($arrSettings["primaryButtonBackgroundColor"])) {
                $this->setPrimaryButtonBackgroundColor($arrSettings["primaryButtonBackgroundColor"]);
            }

            if (isset($arrSettings["primaryButtonBorderColor"])) {
                $this->setPrimaryButtonBorderColor($arrSettings["primaryButtonBorderColor"]);
            }

            if (isset($arrSettings["primaryButtonTextColor"])) {
                $this->setPrimaryButtonTextColor($arrSettings["primaryButtonTextColor"]);
            }
            
            if (isset($arrSettings["secondaryButtonBackgroundColor"])) {
                $this->setSecondaryButtonBackgroundColor($arrSettings["secondaryButtonBackgroundColor"]);
            }

            if (isset($arrSettings["secondaryButtonBorderColor"])) {
                $this->setSecondaryButtonBorderColor($arrSettings["secondaryButtonBorderColor"]);
            }

            if (isset($arrSettings["secondaryButtonTextColor"])) {
                $this->setSecondaryButtonTextColor($arrSettings["secondaryButtonTextColor"]);
            }

            if (isset($arrSettings["privacyPageId"])) {
                $this->setPrivacyPageId($arrSettings["privacyPageId"]);
            }

            if (isset($arrSettings["popupBackgroundColor"])) {
                $this->setPopupBackgroundColor($arrSettings["popupBackgroundColor"]);
            }

            if (isset($arrSettings["popupTextColor"])) {
                $this->setPopupTextColor($arrSettings["popupTextColor"]);
            }

            if (isset($arrSettings["position"])) {
                $this->setPosition($arrSettings["position"]);
            }

            if (isset($arrSettings["method"])) {
                $this->setMethod($arrSettings["method"]);
            }

            if (isset($arrSettings["language"])) {
                $this->setLanguage($arrSettings["language"]);
            }

            if (isset($arrSettings["customText"])) {
                $this->setCustomText($arrSettings["customText"]);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return boolean
     */
    public function reset()
    {
        $this->setPrimaryButtonBackgroundColor("#ffffff");
        $this->setPrimaryButtonBorderColor("#ffffff");
        $this->setPrimaryButtonTextColor("#75ca2a");
        $this->setSecondaryButtonBackgroundColor("#fb1515");
        $this->setSecondaryButtonBorderColor("#fb1515");
        $this->setSecondaryButtonTextColor("#ffffff");
        $this->setPrivacyPageId(0);
        $this->setPopupBackgroundColor("#75ca2a");
        $this->setPopupTextColor("#ffffff");
        $this->setPosition("bottom");

        return true;
    }

    public function getLanguage()
    {
        return $this->getSetting("settings.language", Languages::AUTO);
    }

    public function getLanguages()
    {
        $languages = array();
      
        $languages[Languages::AUTO] = t("Auto");
        $languages[Languages::AR_SA] = t("ar_SA");
        $languages[Languages::CS_CZ] = t("cs_CZ");
        $languages[Languages::DA_DK] = t("da_DK");
        $languages[Languages::DE_DE] = t("de_DE");
        $languages[Languages::EL_GR] = t("el_GR");
        $languages[Languages::EN_IE] = t("en_IE");
        $languages[Languages::EN_US] = t("en_US");
        $languages[Languages::ES_ES] = t("es_ES");
        $languages[Languages::ET_EE] = t("et_EE");
        $languages[Languages::ET_IT] = t("et_IT");
        $languages[Languages::FI_FL] = t("fi_FL");
        $languages[Languages::FR_FR] = t("fr_FR");
        $languages[Languages::HR_HR] = t("hr_HR");
        $languages[Languages::HU_HR] = t("hu_HR");
        $languages[Languages::IT_LT] = t("it_LT");
        $languages[Languages::LV_LV] = t("lv_LV");
        $languages[Languages::MT_MT] = t("mt_MT");
        $languages[Languages::NL_NL] = t("nl_NL");
        $languages[Languages::PL_PL] = t("pl_PL");
        $languages[Languages::PT_PT] = t("pt_PT");
        $languages[Languages::RO_RO] = t("ro_RO");
        $languages[Languages::SK_SK] = t("sk_SK");
        $languages[Languages::SI_SI] = t("si_SI");
        $languages[Languages::SV_FI] = t("sv_FI");
      
        return $languages;
    }
  
    public function setLanguage($language)
    {
        return $this->setSetting("settings.language", $language);
    }

    public function getMethod()
    {
        return $this->getSetting("settings.method", Methods::OPTIN);
    }

    public function setMethod($method)
    {
        return $this->setSetting("settings.method", $method);
    }
  
    public function getMethods()
    {
        $methods = array();
      
        $methods[Methods::AUTO] = t("Auto");
        $methods[Methods::OPTIN] = t("Opt In");
        $methods[Methods::OPTOUT] = t("Opt Out");
        $methods[Methods::NOTICE] = t("Notice");
      
        return $methods;
    }

    public function getCustomText()
    {
        return $this->getSetting("settings.custom_text", "");
    }

    public function setCustomText($customText)
    {
        return $this->setSetting("settings.custom_text", $customText);
    }
}
