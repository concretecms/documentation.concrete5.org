<?php
namespace Concrete\Package\Concrete5Docs\Block\LatestVideo;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Express\EntryList;
use Express;

class Controller extends BlockController
{

    protected $btInterfaceWidth = 380;
    protected $btInterfaceHeight = 250;
    protected $btTable = 'btLatestVideo';

    const AUDIENCE_ALL = 'all';
    const AUDIENCE_DEVELOPERS = 'Developers';
    const AUDIENCE_DESIGNERS = 'Designers';
    const AUDIENCE_EDITORS = 'Editors';


    public function getBlockTypeName()
    {
        return t('Latest Video Block');
    }

    public function getBlockTypeDescription()
    {
        return t('Displays the latest video from selected audience');
    }

    public function on_before_render()
    {
        parent::on_before_render();

        $entity = Express::getObjectByHandle('youtubevideo');
        /** @var \Concrete\Core\Express\EntryList $list */
        $list = new EntryList($entity);

        if ($this->filteredAudienceDevelopers){
            $list->filterByVideoAudience(self::AUDIENCE_DEVELOPERS);
        } elseif ($this->filteredAudienceEditors) {
            $list->filterByVideoAudience(self::AUDIENCE_EDITORS);
        } elseif ($this->filteredAudienceDesigners) {
            $list->filterByVideoAudience(self::AUDIENCE_DESIGNERS);
        } 
        
        $list->sortByDateAddedDescending();
        $list->getQueryObject()->setMaxResults(1);

        $videos = $list->getResults();

        $videoObj = $videos[0];
    
        $this->set('videoObj', $videoObj);
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
    }

    public function view()
    {

    }

    public function save($data)
    {
        $data['filteredAudienceAll'] = $data['filteredAudienceOption'] === self::AUDIENCE_ALL ? 1 : 0;
        $data['filteredAudienceDevelopers'] = $data['filteredAudienceOption'] === self::AUDIENCE_DEVELOPERS ? 1 : 0;
        $data['filteredAudienceDesigners'] = $data['filteredAudienceOption'] === self::AUDIENCE_DESIGNERS ? 1 : 0;
        $data['filteredAudienceEditors'] = $data['filteredAudienceOption'] === self::AUDIENCE_EDITORS ? 1 : 0;

        parent::save($data);
    }
}

