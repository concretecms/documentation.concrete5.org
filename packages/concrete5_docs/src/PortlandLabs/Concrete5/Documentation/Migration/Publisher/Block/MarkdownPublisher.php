<?php

namespace PortlandLabs\Concrete5\Documentation\Migration\Publisher\Block;


use Concrete\Core\Backup\ContentImporter;
use Concrete\Core\Editor\LinkAbstractor;
use Concrete\Core\Legacy\BlockRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use Concrete\Core\Page\Page;
use Concrete\Core\Block\BlockType\BlockType;
// use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\PublisherInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class MarkdownPublisher //implements PublisherInterface
{

    public function publish(Batch $batch, $bt, Page $page, $area, BlockValue $value)
    {
        $data = $value->getRecords()->get(0)->getData();
        $inspector = \Core::make('migration/import/value_inspector', array($batch));
        $result = $inspector->inspect($data['content']);
        $text = $result->getReplacedContent();

        $text = preg_replace(
            array(
                '/{CCM:BASE_URL}/i'
            ),
            array(
                \Core::getApplicationURL(),
            ),
            $text
        );

        // now we add in support for the links
        $text = preg_replace_callback(
            '/{CCM:CID_([0-9]+)}/i',
            function ($matches) {
                $cID = $matches[1];
                if ($cID > 0) {
                    $c = Page::getByID($cID, 'ACTIVE');
                    return \Loader::helper("navigation")->getLinkToCollection($c);
                }
            },
            $text
        );

        // now we add in support for the links
        $text = preg_replace_callback(
            '/{CCM:FID_([0-9]+)}/i',
            function ($matches) {
                $fID = $matches[1];
                if ($fID > 0) {
                    $f = \File::getByID($fID);
                    return $f->getURL();
                }
            },
            $text
        );


        // now files we download
        $text = preg_replace_callback(
            '/{CCM:FID_DL_([0-9]+)}/i',
            function ($matches) {
                $fID = $matches[1];
                if ($fID > 0) {
                    return \URL::to('/download_file', 'view', $fID);
                }
            },
            $text
        );

        $data['content'] = $text;
        $b = $page->addBlock($bt, $area, $data);
        return $b;
    }

}
