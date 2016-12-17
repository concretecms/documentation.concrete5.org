<?php

namespace Concrete\Package\Concrete5Docs\Theme\Concrete5Docs;

class PageTheme extends \Concrete\Core\Page\Theme\Theme
{
    public function registerAssets()
    {
        $this->providesAsset('css', 'bootstrap/*');
        $this->providesAsset('javascript', 'bootstrap/*');
        $this->providesAsset('css', 'blocks/form');
        $this->providesAsset('css', 'blocks/social_links');
        $this->providesAsset('css', 'blocks/share_this_page');
        $this->providesAsset('css', 'blocks/feature');
        $this->providesAsset('css', 'blocks/testimonial');
        $this->providesAsset('css', 'blocks/date_navigation');
        $this->providesAsset('css', 'blocks/topic_list');
        $this->providesAsset('css', 'blocks/faq');
        $this->providesAsset('css', 'blocks/tags');
        $this->providesAsset('css', 'core/frontend/*');
        $this->providesAsset('css', 'blocks/feature/templates/hover_description');
        $this->requireAsset('css', 'font-awesome');
        $this->requireAsset('javascript', 'jquery');
        $this->requireAsset('javascript', 'picturefill');
        $this->requireAsset('javascript', 'core/frontend/parallax-image');
        $this->requireAsset('javascript-conditional', 'html5-shiv');
        $this->requireAsset('javascript-conditional', 'respond');
    }

    protected $pThemeGridFrameworkHandle = 'bootstrap3';

    public function getThemeName()
    {
        return t('concrete5 Docs');
    }

    public function getThemeDescription()
    {
        return t('concrete5 Docs.');
    }

    public function getThemeResponsiveImageMap()
    {
        return array(
            'large' => '900px',
            'medium' => '768px',
            'small' => '0',
        );
    }

    public function getThemeEditorClasses()
    {
        return array(
            array('title' => t('Header Variant Blue'), 'spanClass' => 'header-variant-blue', 'forceBlock' => 1),
            array('title' => t('Header Variant Purple'), 'spanClass' => 'header-variant-purple', 'forceBlock' => 1),
            array('title' => t('Stripe Content Cream'), 'menuClass' => 'menu-stripe-content-cream', 'spanClass' => 'stripe-content-cream', 'forceBlock' => -1)
        );
    }


}
