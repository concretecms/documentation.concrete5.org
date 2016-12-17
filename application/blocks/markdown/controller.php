<?
namespace Application\Block\Markdown;

use Concrete\Core\Block\Block;
use Concrete\Core\Page\Type\Type;
use Concrete\Package\Markdown\Block\Markdown\Controller as BlockController;

class Controller extends BlockController
{

    public function validateComposerAddBlockPassThruAction(Type $type)
    {
        $pp = new \Permissions($type);
        return $pp->canAddInDocumentationComposer();
    }

    public function validateComposerEditBlockPassThruAction(Block $b)
    {
        $c = $b->getBlockCollectionObject();
        $cp = new \Permissions($c);
        return $cp->canEditInDocumentationComposer();
    }

}