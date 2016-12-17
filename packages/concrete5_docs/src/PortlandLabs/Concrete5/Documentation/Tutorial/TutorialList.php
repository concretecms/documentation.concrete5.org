<?php

namespace PortlandLabs\Concrete5\Documentation\Tutorial;

use Concrete\Attribute\Select\Option;
use Concrete\Core\Page\PageList;

class TutorialList extends PageList
{

    public function __construct()
    {
        parent::__construct();
        $this->filterByPageTypeHandle('tutorial');
        $this->ignorePermissions();
        $this->sortByPublicDateDescending();
    }

    public function sortByTrending()
    {
        $this->query->addSelect('(select count(btl.cID) from btLikesThisUserPages btl where btl.cID = p.cID
            and TIMESTAMPDIFF(DAY,lastTimeMarked,CURDATE()) <= 14) as likes');
        $this->query->orderBy('likes', 'desc');
    }

    public function sortByPopularityDescending()
    {
        $this->query->orderBy('ak_likes_this_page_count', 'desc');
    }

    public function filterBySelectOption($join, $option)
    {
        $this->query->leftJoin('cv', 'CollectionAttributeValues', $join,
            'cv.cID = ' . $join . '.cID and cv.cvID = ' . $join . '.cvID');
        $this->query->leftJoin($join, 'atSelectOptionsSelected', $join . 'Options', $join . '.avID = ' . $join . 'Options.avID');
        $this->query->andWhere($join . 'Options.avSelectOptionID = :avSelectOptionID');
        $this->query->setParameter('avSelectOptionID', $option->getSelectAttributeOptionID());
    }

}
