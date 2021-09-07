<?php

namespace App\Repositories;


use App\Models\Image;

/**
 * Class ImagesReposotiry
 *
 * @package \App\Repositories
 */
interface IImage
{
    public function __construct(Image $image);

    public function insert(array $images);
}
