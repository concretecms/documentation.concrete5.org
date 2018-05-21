<?php

/**
 * @project:   EU Cookie Law
 *
 * @author     Fabian Bitter (fabianbitter@protonmail.com)
 * @copyright  (C) 2017 Bitter Webentwicklung
 * @version    1.0.1.2
 */
defined('C5_EXECUTE') or die('Access denied');

Core::make('help')->display(t("If you need support please click <a href=\"%s\">here</a>.", "https://bitbucket.org/fabianbitter/eu_cookie_law/issues/new"));
