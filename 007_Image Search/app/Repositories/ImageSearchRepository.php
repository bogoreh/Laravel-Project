<?php

namespace ImageSearch\Repositories;

use ImageSearch\Repositories\Interfaces\ImageSearchRepositoryInterface;

class ImageSearchRepository implements ImageSearchRepositoryInterface
{
    public function __construct() {
        
    }

    /**
    * Process image-search for a user with given parameters.
    *
    * @param int $userId
    * @param array $parameters
    * @return mixed
    */
    public function imageSearch(int $userId, array $parameters)
    {
        
    }

}
