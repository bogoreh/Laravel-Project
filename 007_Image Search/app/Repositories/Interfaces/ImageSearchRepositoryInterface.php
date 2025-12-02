<?php

namespace ImageSearch\Repositories\Interfaces;

interface ImageSearchRepositoryInterface
{
    public function imageSearch(int $userId, array $parameters);
}
