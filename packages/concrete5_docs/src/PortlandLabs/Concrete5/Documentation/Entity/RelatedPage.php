<?php

namespace PortlandLabs\Concrete5\Documentation\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="DocumentationRelatedPages", indexes={
 * @ORM\Index(name="page_id", columns={"page_id"})
 * })
 */
class RelatedPage
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"unsigned": true})
     */
    protected $page_id;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"unsigned": true})
     */
    protected $related_page_id;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"unsigned": true})
     */
    protected $relation_score;

    /**
     * @return mixed
     */
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * @param mixed $page_id
     */
    public function setPageId($page_id)
    {
        $this->page_id = $page_id;
    }

    /**
     * @return mixed
     */
    public function getRelatedPageId()
    {
        return $this->related_page_id;
    }

    /**
     * @param mixed $related_page_id
     */
    public function setRelatedPageId($related_page_id)
    {
        $this->related_page_id = $related_page_id;
    }

    /**
     * @return mixed
     */
    public function getRelationScore()
    {
        return $this->relation_score;
    }

    /**
     * @param mixed $relation_score
     */
    public function setRelationScore($relation_score)
    {
        $this->relation_score = $relation_score;
    }



}
