<?php

namespace App\Repositories;

use App\Models\Image;

/**
 * Class ImagesReposotiry
 *
 * @package \App\Repositories
 */
class ImagesReposotory implements IImage
{

    /**
     * @var \App\Models\Image
     */
    private $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function insert(array $images)
    {
        $rows = [];
        foreach ($images as $image) {
            $data['url'] = $image['url'];
            $data['alt'] = $image['alt'];
            $data['user_id'] = auth()->id();
            array_push($rows, $data);
        }
        $this->image->insert($rows);
    }

    public function getUserImage()
    {
        return $this->image->where('user_id', auth()->id())->get();
    }

}
