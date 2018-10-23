<?php

namespace Concrete\Package\Concrete5Docs\Controller\SinglePage;

use Concrete\Core\Page\Controller\PageController;
use Concrete\Core\Page\Type\Type;
use Core;

defined('C5_EXECUTE') or die("Access Denied.");

class Contribute extends PageController
{

    public function on_start()
    {
        parent::on_start();
        $this->token = Core::make('token');
        $this->error = Core::make('error');
        $this->set('form', Core::make("helper/form"));
        $this->requireAsset('core/app');
    }

    public function on_before_render()
    {
        $this->set('token', $this->token);
        $this->set('error', $this->error);
    }

    public function edit($cID = null)
    {
        $u = new \User();
        if (!$u->isRegistered()) {
            $this->render('/contribute/login');
            return;
        }
        $document = $this->getDocument($cID);
        if (!$document) {
            $this->replace('/page_forbidden');
        } else {
            $type = $document->getPageTypeObject();
            $this->set('pagetype', $type);
            $this->set('document', $document);
            switch($type->getPageTypeHandle()) {
                case 'developer_document':
                    $this->set('buttonTitle', t('Update'));
                    $this->set('pageTitle', t('Update Developer Document'));
                    $this->set('documentationType', 'developer_documentation');
                    break;
                case 'editor_document':
                    $this->set('buttonTitle', t('Update'));
                    $this->set('pageTitle', t('Update Editor Document'));
                    $this->set('documentationType', 'editor_documentation');
                    break;
                default:
                    $this->set('buttonTitle', t('Update'));
                    $this->set('pageTitle', t('Update Tutorial'));
                    $this->set('documentationType', 'tutorial');
                    break;
            }
            $p = new \Permissions();
            $this->set('canEditDocumentAuthor', $p->canEditDocumentAuthor());
            $ui = \UserInfo::getByID($document->getCollectionUserID());
            if (is_object($ui)) {
                $this->set('documentAuthor', $ui->getUserName());
            }
            $this->set('action', \URL::to('/contribute', 'save', $cID));
        }
    }

    protected function getDocument($cID)
    {
        $u = new \User();
        $c = \Page::getByID($cID);
        $document = false;
        if (is_object($c) && !$c->isError()) {
            $type = $c->getPageTypeObject();
            if (is_object($type) && in_array($type->getPageTypeHandle(), array('developer_document', 'editor_document', 'tutorial'))) {
                $cp = new \Permissions($c);
                if ($cp->canEditInDocumentationComposer()) {
                    $document = $c;
                }
            }
        }
        return $document;
    }

    public function view()
    {
        $u = new \User();
        if ($u->isRegistered()) {
            $this->render('/contribute/choose_type');
        } else {
            $this->render('/contribute/login');
        }
    }

    protected function getDocumentPageType($documentationType = null)
    {
        if (!$documentationType) {
            $documentationType = $this->request->request->get('documentation_type');
        }
        switch($documentationType) {
            case 'developer_documentation':
                $this->set('buttonTitle', t('Add Developer Document'));
                $this->set('pageTitle', t('Add Developer Documentation'));
                $pagetype = Type::getByHandle('developer_document');
                break;
            case 'editor_documentation':
                $this->set('buttonTitle', t('Add Editor Document'));
                $this->set('pageTitle', t('Add Editor Documentation'));
                $pagetype = Type::getByHandle('editor_document');
                break;
            default:
                $this->set('buttonTitle', t('Add Tutorial'));
                $this->set('pageTitle', t('Add Tutorial'));
                $pagetype = Type::getByHandle('tutorial');
                break;
        }
        return $pagetype;
    }

    public function choose_type($documentationType = null)
    {
        $u = new \User();
        if ($u->isRegistered()) {
            $this->set('action', \URL::to('/contribute', 'create'));
            $this->set('document', null);
            if (!$documentationType) {
                $documentationType = $this->request->request->get('documentation_type');
            }
            $pagetype = $this->getDocumentPageType($documentationType);
            $this->set('documentationType', $documentationType);
            switch($documentationType) {
                case 'editor_documentation':
                    $this->set('buttonTitle', t('Add Editor Document'));
                    $this->set('pageTitle', t('Add Editor Documentation'));
                    break;
                case 'developer_documentation':
                    $this->set('buttonTitle', t('Add Developer Document'));
                    $this->set('pageTitle', t('Add Developer Documentation'));
                    break;
                default:
                    $this->set('buttonTitle', t('Add Tutorial'));
                    $this->set('pageTitle', t('Add Tutorial'));
                    break;
            }
            $this->set('pagetype', $pagetype);
        } else {
           $this->render('/contribute/login');
        }
    }

    protected function getTargetPageParentID($type)
    {
        $configuredTarget = $type->getPageTypePublishTargetObject();
        $cParentID = $configuredTarget->getPageTypePublishTargetConfiguredTargetParentPageID();
        if (!$cParentID) {
            $cParentID = $this->request->request->get('cParentID');
        }
        return $cParentID;
    }

    protected function validate($document = null)
    {
        $type = $this->getDocumentPageType();

        if ($document) {
            $cParentID = $document->getCollectionParentID();
        } else {
            $cParentID = $this->getTargetPageParentID($type);
        }
        $parent = \Page::getByID($cParentID);

        $validator = $type->getPageTypeValidatorObject();
        $template = $type->getPageTypeDefaultPageTemplateObject();
        $this->error->add($validator->validateCreateDraftRequest($template));
        $this->error->add($validator->validatePublishDraftRequest());
        /**
         * We don't use this standard validation when using the edit in composer
         */
        // $this->error->add($validator->validatePublishLocationRequest($parent));

        /*
         * Instead, we use this custom validation.
         */

        if (!is_object($parent) || $parent->isError()) {
            $this->error->add(t('You must choose a page to publish this page beneath.'));
        } else {
            $pt = new \Permissions($type);
            switch($type->getPageTypeHandle()) {
                case 'tutorial':
                    // tutorials can only be published beneath the tutorial node
                    if ($parent->getCollectionPath() != '/tutorials' ||
                        !$pt->canAddInDocumentationComposer()) {
                        $this->error->add(t('You do not have permission to publish a page in this location.'));
                    }
                    break;
                case 'document':
                    if ($parent->getPageTypeHandle() != 'section' ||
                        !$pt->canAddInDocumentationComposer()) {
                        $this->error->add(t('You do not have permission to publish a page in this location.'));
                    }
                    break;
            }
        }
    }

    public function save($cID = null)
    {
        $document = $this->getDocument($cID);
        if (!$document) {
            throw new \Exception(t('Access Denied.'));
        }

        if (!$this->token->validate('save')) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!$this->request->request->get('versionComment')) {
            $this->error->add(t('You must specify the changes you made in this document.'));
        }

        $this->validate($document);

        if (!$this->error->has()) {
            $type = $this->getDocumentPageType();
            $document = $document->getVersionToModify();
            $v = $document->getVersionObject();
            $comment = $this->request->request->get('versionComment');

            $p = new \Permissions();
            $updateAuthor = false;
            if ($p->canEditDocumentAuthor()) {
                if ($this->request->request->get('documentAuthor')) {
                    $originalAuthor = \UserInfo::getByID($document->getCollectionUserID());
                    $originalAuthorName = t('(Unknown)');
                    if (is_object($originalAuthor)) {
                        $originalAuthorName = $originalAuthor->getUserName();
                    }
                    $documentAuthor = \UserInfo::getByName($this->request->request->get('documentAuthor'));
                    if (is_object($documentAuthor) && $documentAuthor->getUserName() != $originalAuthorName) {
                        $comment .= t(' - Note: author changed from %s to %s', $originalAuthorName, $documentAuthor->getUserName());
                        $updateAuthor = true;
                    }
                }
            }

            $v->setComment($comment);
            $type->savePageTypeComposerForm($document);
            $type->publish($document);

            if ($updateAuthor) {
                $document->update(array('uID' => $documentAuthor->getUserID()));
            }

            $this->flash('success', t('Page updated! Your changes are under review.'));
            $this->redirect('/contributions');
        }
        $this->edit($cID);
    }

    public function create()
    {
        if (!$this->token->validate('save')) {
            $this->error->add($this->token->getErrorMessage());
        }

        $this->validate();

        if (!$this->error->has()) {
            $type = $this->getDocumentPageType();
            $template = $type->getPageTypeDefaultPageTemplateObject();
            $d = $type->createDraft($template);
            $cParentID = $this->getTargetPageParentID($type);
            $d->setPageDraftTargetParentPageID($cParentID);
            $type->savePageTypeComposerForm($d);
            $type->publish($d);

            $this->flash('success', t('Thanks for your contribution! We are reviewing it for accuracy.'));
            $this->redirect('/contributions');
        }
        $this->choose_type();
    }

}