<?php

namespace Concrete\Package\Concrete5Docs\Block\TutorialRelatedList;

use Concrete\Attribute\Select\Option;
use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Page\Page;
use PortlandLabs\Concrete5\Documentation\Tutorial\TutorialList;

class Controller extends BlockController
{
    const AUDIENCE_ALL = 'all';
    const AUDIENCE_DEVELOPERS = 'developers';
    const AUDIENCE_DESIGNERS = 'designers';
    const AUDIENCE_EDITORS = 'editors';

    const SORT_BY_DATE = 'newest';
    const SORT_BY_TREND = 'trending';
    const SORT_BY_LIKES = 'likes';

    protected $btInterfaceWidth = 500;
    protected $btInterfaceHeight = 340;
    protected $btTable = 'btTutorialRelatedList';
    protected $list;

    public function getBlockTypeName()
    {
        return t('Related Tutorials List');
    }

    public function getBlockTypeDescription()
    {
        return t("Displays a list of pages related to the parent page.");
    }

    public function on_start()
    {
        parent::on_start();
        $this->list = new TutorialList();
    }

    public function on_before_render()
    {
        parent::on_before_render();

        if ($this->filteredByTags) {
            $tags = Page::getCurrentPage()->getAttribute('tags');
            if ($tags) {
                foreach ($tags as $tag) {
                    $this->list->filterByAttribute('tags', $tag);
                }
            }
        }

        if ($this->sortByTrending) {
            $this->list->sortByTrending();
        }

        if ($this->sortByLikes) {
            $this->list->sortByPopularityDescending();
        }

        if ($this->sortByPostedDate) {
            $this->list->sortByPublicDateDescending();
        }

        if ($this->filteredAudienceDevelopers) {
            $this->list->filterBySelectOption('audience', $this->getOption(self::AUDIENCE_DEVELOPERS));
        }

        if ($this->filteredAudienceEditors) {
            $this->list->filterBySelectOption('audience', $this->getOption(self::AUDIENCE_EDITORS));
        }

        if ($this->filteredAudienceDesigners) {
            $this->list->filterBySelectOption('audience', $this->getOption(self::AUDIENCE_DESIGNERS));
        }

        $results = $this->list->getPagination();

        if ($this->maxNumber) {
            $results->setMaxPerPage($this->maxNumber);
        } else {
            $results->setMaxPerPage(6);
        }

        $this->set('results', $results);
    }

    public function add()
    {
        $this->edit();
    }

    public function edit()
    {
        $this->set('all', self::AUDIENCE_ALL);
        $this->set('editors', self::AUDIENCE_EDITORS);
        $this->set('developers', self::AUDIENCE_DEVELOPERS);
        $this->set('designers', self::AUDIENCE_DESIGNERS);

        $this->set('newest', self::SORT_BY_DATE);
        $this->set('trend', self::SORT_BY_TREND);
        $this->set('likes', self::SORT_BY_LIKES);
    }

    public function view()
    {

    }

    public function save($data)
    {
        $data['title'] = (string)$data['title'];

        $data['maxNumber'] = (int)$data['maxNumber'];
        
        $data['filteredAudienceAll'] = $data['filteredAudienceOption'] === self::AUDIENCE_ALL ? 1 : 0;
        $data['filteredAudienceDevelopers'] = $data['filteredAudienceOption'] === self::AUDIENCE_DEVELOPERS ? 1 : 0;
        $data['filteredAudienceDesigners'] = $data['filteredAudienceOption'] === self::AUDIENCE_DESIGNERS ? 1 : 0;
        $data['filteredAudienceEditors'] = $data['filteredAudienceOption'] === self::AUDIENCE_EDITORS ? 1 : 0;

        $data['sortByTrending'] = $data['sortByOptions'] === self::SORT_BY_TREND ? 1 : 0;
        $data['sortByLikes'] = $data['sortByOptions'] === self::SORT_BY_LIKES ? 1 : 0;
        $data['sortByPostedDate'] = $data['sortByOptions'] === self::SORT_BY_DATE ? 1 : 0;

        parent::save($data);
    }

    private function getOption($value)
    {
        return Option::getByValue($value,
            CollectionKey::getByHandle('audience'));
    }
}
