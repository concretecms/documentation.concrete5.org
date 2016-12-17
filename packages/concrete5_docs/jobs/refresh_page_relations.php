<?php
namespace Concrete\Package\Concrete5Docs\Job;

use Concrete\Core\Page\Type\Type;
use Concrete\Package\Concrete5Docs\Page\Relater;
use Loader;
use Concrete\Core\Job\QueueableJob;
use Concrete\Core\Page\Page;
use \ZendQueue\Queue as ZendQueue;
use \ZendQueue\Message as ZendQueueMessage;

class RefreshPageRelations extends QueueableJob
{

    public $jNotUninstallable = 1;
    public $jSupportsQueue = true;

    protected $indexedSearch;

    public function getJobName()
    {
        return t("Refresh Page Relations");
    }

    public function getJobDescription()
    {
        return t("Goes through all documentation and tutorial pages and relates them to other pages by tag.");
    }


    public function start(ZendQueue $q)
    {
        $db = Loader::db();
        $documentation = Type::getByHandle('document');
        $tutorial = Type::getByHandle('tutorial');

        $r = $db->Execute('select cID from Pages where (ptID = ? or ptID = ?) and cIsTemplate = 0 and cIsActive = 1',
            array($documentation->getPageTypeID(), $tutorial->getPageTypeID())
        );
        while ($row = $r->FetchRow()) {
            $q->send($row['cID']);
        }
    }

    public function finish(ZendQueue $q)
    {
        $db = Loader::db();
        $query = $db->getEntityManager()->createQuery("SELECT COUNT(r) FROM \PortlandLabs\Concrete5\Documentation\Entity\RelatedPage r");
        $total = $query->getSingleScalarResult();
        return t('Index updated. %s pages related.', $total);
    }

    public function processQueueItem(ZendQueueMessage $msg)
    {
        $c = Page::getByID($msg->body, 'ACTIVE');
        $manager = \Database::connection()->getEntityManager();
        $relater = new Relater($manager, $c);
        $relater->clearRelations();
        $relations = $relater->determineRelations();
        foreach($relations as $relation) {
            $manager->persist($relation);
        }
        $manager->flush();
    }
}