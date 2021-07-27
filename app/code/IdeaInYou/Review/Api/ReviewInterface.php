<?php


namespace IdeaInYou\Review\Api;

interface ReviewInterface
{
    const TABLE_NAME = 'ideainyou_review';
    const ENTITY_ID = 'entity_id';
    const AUTHOR = 'author';

    public function getId();

    public function setId($id);

    public function getAuthor();

    public function setAuthor($author);

}
