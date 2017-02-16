<?php

namespace Concrete\Package\Concrete5Docs\Block\TutorialSearch;

use Concrete\Attribute\Select\Option;
use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Page\PageList;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller extends BlockController
{
    protected $btCacheBlockRecord = true;

    public function getBlockTypeName()
    {
        return t('Tutorial Search');
    }

    public function view()
    {
        $placeholders = array(
            t('How do you log emails?'),
            t('How do you build a theme?'),
            t('How can I customize my theme\'s colors?'),
            t('How can I add a block type?'),
            t('How can I control who can see my site?'),
            t('Can I lock down certain parts of my site?'),
            t('How can I extend the functionality of my concrete5 site?'),
            t('Can I blog with concrete5?'),
            t('Where can I install concrete5?')
        );
        shuffle($placeholders);
        $placeholder = $placeholders[0];
        $this->set('placeholder', $placeholder);
        $this->requireAsset('select2');
        $this->requireAsset('javascript', 'underscore');

        if ($this->request->query->has('search')) {
            $kw = $this->request->query->get('search');
            if (\Core::make('helper/validation/numbers')->integer($kw)) {
                $option = Option::getByID($kw);
                if (is_object($option)) {
                    $list = $option->getOptionList();
                    if (is_object($list)) {
                        $settings = \Database::connection()->getEntityManager()
                            ->getRepository('Concrete\Core\Entity\Attribute\Key\Settings\SelectSettings')
                            ->findOneByList($list);
                        if (is_object($settings)) {
                            $key = $settings->getAttributeKey();
                        }
                    }
                    if (isset($key) && is_object($key)) {
                        switch($key->getAttributeKeyHandle()) {
                            case 'questions_answered':
                                $o = new \stdClass;
                                $o->type = 'question';
                                $o->text = h($option->getSelectAttributeOptionValue());
                                $o->id = $option->getSelectAttributeOptionID();
                                break;
                            case 'tags':
                                $o = new \stdClass;
                                $o->type = 'tag';
                                $o->text = h($option->getSelectAttributeOptionValue());
                                $o->id = $option->getSelectAttributeOptionID();
                                break;
                        }
                    }
                }
            }
            if (!is_object($o)) {
                $o = new \stdClass;
                $o->type = 'query';
                $o->text = h($kw);
                $o->id = $o->text;
            }
            $this->set('selection', $o);
        }

        $audience = null;
        if (in_array($this->request->query->get('audience'), array('developers', 'designers', 'editors'))) {
            $audience = $this->request->query->get('audience');
        }
        $this->set('audience', $audience);

    }

    public function action_load_questions($bID = false)
    {
        if ($this->bID == $bID) {
            $ak = CollectionKey::getByHandle('questions_answered');
            $options = array();
            foreach($ak->getController()->getOptions('%' . $_GET['q'] . '%') as $option) {
                $o = new \stdClass;
                $o->id = $option->getSelectAttributeOptionID();
                $o->type = 'question';
                $o->text = $option->getSelectAttributeOptionValue();
                $options[] = $o;
            }
            $ak = CollectionKey::getByHandle('tags');
            foreach($ak->getController()->getOptions('%' . $_GET['q'] . '%') as $option) {
                $o = new \stdClass;
                $o->id = $option->getSelectAttributeOptionID();
                $o->type = 'tag';
                $o->text = $option->getSelectAttributeOptionValue();
                $options[] = $o;
            }
        }
        return new JsonResponse($options);
    }

}
