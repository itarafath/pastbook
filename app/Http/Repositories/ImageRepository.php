<?php

namespace App\Http\Repositories;

use App\Models\Image;

/**
 * Class ImageRepository
 *
 * @package \App\Http\Repositories
 */
class ImageRepository
{
    public function insert(array $images)
    {
        Image::query()->insert($images);
    }
}
