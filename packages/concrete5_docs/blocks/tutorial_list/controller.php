<?php

namespace Concrete\Package\Concrete5Docs\Block\TutorialList;

use Concrete\Attribute\Select\Option;
use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Multilingual\Page\PageList;
use PortlandLabs\Concrete5\Documentation\Tutorial\TutorialList;

class Controller extends BlockController
{
    protected $btCacheBlockRecord = true;
    protected $list;

    public function getBlockTypeName()
    {
        return t('Tutorial List');
    }

    public function on_start()
    {
        parent::on_start();
        $this->list = new TutorialList();
    }

    public function on_before_render()
    {
        parent::on_before_render();
        $results = $this->list->getPagination();
        $this->set('results', $results);

        // Set form elments in the page
        $audience = null;
        if (in_array($this->request->query->get('audience'), array('developers', 'designers', 'editors'))) {
            $audience = $this->request->query->get('audience');
            $audienceLabel = ucfirst($audience);
        } else {
            $audienceLabel = t('Audience');
        }
        $sort = 'newest';
        if (in_array($this->request->query->get('sort'), array('newest', 'popular', 'trending'))) {
            $sort = $this->request->query->get('sort');
        }
        $this->set('audience', $audience);
        $this->set('sort', $sort);
        $this->set('audienceLabel', $audienceLabel);
    }

    public function action_search($bID = false)
    {
        if ($this->request->query->has('search')) {
            $kw = $this->request->query->get('search');
            if (\Core::make('helper/validation/numbers')->integer($kw)) {
                $option = Option::getByID($kw);
                if (is_object($option)) {
                    $this->list->filterBySelectOption('questionOrTag', $option);
                }
            }
            if (!isset($option) || !is_object($option)) {
                $this->list->filterByKeywords($kw);
            }
        }
        if ($this->request->query->has('audience')) {
            $audience = $this->request->query->get('audience');
            $option = Option::getByValue($audience, CollectionKey::getByHandle('audience'));
            if (is_object($option)) {
                $this->list->filterBySelectOption('audience', $option);
            }
        }

        if ($this->request->query->has('sort')) {
            $sort = $this->request->query->get('sort');
            switch($sort) {
                case 'trending':
                    $this->list->sortByTrending();
                    break;
                case 'popular':
                    $this->list->sortByPopularityDescending();
                    break;
                default:
                    $this->list->sortByPublicDateDescending();
                    break;
            }
        }


    }

    public function getSearchURL($view, $variable, $value)
    {
        $url = $view->action('search');
        $url = $url->setQuery(\Concrete\Core\Url\Url::createFromServer($_SERVER)->getQuery());
        $query = $url->getQuery();
        $query[$variable] = $value;
        return $url->setQuery($query);
    }
}
