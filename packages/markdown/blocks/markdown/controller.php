<?
namespace Concrete\Package\Markdown\Block\Markdown;
use \Concrete\Core\Block\BlockController;
use \Concrete\Core\Editor\LinkAbstractor;
use \Michelf\MarkdownExtra as MarkdownExtra;
use \Response;
use Concrete\Core\File\Importer;
use Concrete\Core\File\Version;
use Symfony\Component\HttpFoundation\JsonResponse;


class Controller extends BlockController
{

    protected $btTable = 'btContentMarkdown';
    protected $btInterfaceWidth = "650";
    protected $btInterfaceHeight = "400";
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btCacheBlockOutputLifetime = 0; //until manually updated or cleared
    protected $btDefaultSet = 'basic';

    public function getBlockTypeDescription()
    {
        return t("Markdown Content.");
    }

    public function getBlockTypeName()
    {
        return t("Markdown");
    }

    function getContent()
    {
        return $this->content;
    }

    public function view()
    {
        $this->set('content', $this->getFormattedContent());
    }

    public function getFormattedContent()
    {
        $content = MarkdownExtra::defaultTransform($this->content);
        return $content;
    }

    public function getSearchableContent()
    {
        return $this->content;
    }

    public function export(\SimpleXMLElement $blockNode)
    {
        $data = $blockNode->addChild('data');
        $data->addAttribute('table', $this->btTable);
        $record = $data->addChild('record');
        $content = $this->content;

        $content = preg_replace_callback(
            '/\!\[(.*)\]\((.+)\)/i',
            function($filename) {
                return '![' . $filename[1] . ']({ccm:export:file:' . basename($filename[2]) . '})';
            },
            $content);


        $cnode = $record->addChild('content');
        $node = dom_import_simplexml($cnode);
        $no = $node->ownerDocument;
        $node->appendChild($no->createCDataSection($content));
    }

    public function add()
    {
        $this->requireAsset('bootstrap-markdown-editor');
    }

    public function action_preview()
    {
        $content = MarkdownExtra::defaultTransform(
            $this->request->request->get('content')
        );

        $r = new Response($content);
        return $r;

    }

    public function action_upload()
    {
        $fp = \FilePermissions::getGlobal();
        if (!$fp->canAddFiles()) {
            $r = new Response(t('Access Denied'));
            return $r;
        }

        $files = array();
        if (!empty($_FILES)) {
            foreach($_FILES as $file) {
                $i = new Importer();
                $r = $i->import($file['tmp_name'], $file['name']);
                if (!($r instanceof Version)) {
                    throw new \Exception($i->getErrorMessage($r));
                } else {
                    $files[] = $r->getURL();
                }
            }
        }

        $r = new JsonResponse($files);
        return $r;
    }

    public function composer()
    {
        $this->requireAsset('bootstrap-markdown-editor');
    }

    public function edit()
    {
        $this->requireAsset('bootstrap-markdown-editor');
    }

}
