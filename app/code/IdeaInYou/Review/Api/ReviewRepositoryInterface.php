<?php

namespace IdeaInYou\Review\Api;

use IdeaInYou\Review\Model\Review;

interface ReviewRepositoryInterface
{
    public function getById($id);

    public function save(Review $review);

    public function delete(Review $review);

    public function deleteById($id);
}
