<?php

namespace App\Services;

use Carbon\Carbon;
use Facebook\Facebook;

/**
 * Class FacebookService
 *
 * @package \App\Services
 */
class FacebookService
{
    /**
     * @var \Facebook\Facebook
     */
    private $fb;

    /**
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function __construct()
    {
        $this->fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.10',
        ]);
    }

    public function getImages($token)
    {

        $since = Carbon::parse('01-01-2018')->timestamp;
        $until = Carbon::now()->timestamp;

        // we can not retrieve the images without business verification
        // https://developers.facebook.com/docs/permissions/reference/user_photos
        $sdk_query = $this->fb->get("me/albums", $token);

        return $sdk_query->getGraphEdge();
    }

    public function getDummyImages()
    {
        return [
            ['url' => 'https://cdn.pixabay.com/photo/2021/08/30/16/28/dewdrops-6586339_960_720.jpg', 'alt' => 'Dewdrops, Cobweb, Water Pearls, Morning Dew, Nature'],
            ['url' => 'https://cdn.pixabay.com/photo/2016/01/05/13/58/apple-1122537_960_720.jpg', 'alt' => 'Apple, Water Droplets, Fruit, Moist, Dew, Dewdrops'],
            ['url' => 'https://cdn.pixabay.com/photo/2014/09/14/18/04/dandelion-445228_960_720.jpg', 'alt' => 'Dandelion, Seeds, Dew, Dewdrops, Droplets, Weed, Plant'],
            ['url' => 'https://cdn.pixabay.com/photo/2014/09/27/17/35/dandelion-463928_960_720.jpg', 'alt' => 'Dandelion, Heaven, Flower, Nature, Seeds, Plant, Spring'],
            ['url' => 'https://cdn.pixabay.com/photo/2013/11/28/10/36/road-220058_960_720.jpg', 'alt' => 'Road, Pavement, Landscape, Roadway, Drive, Route, Way'],
            ['url' => 'https://cdn.pixabay.com/photo/2014/09/07/21/52/city-438393_960_720.jpg', 'alt' => 'City, Street, People, Urban, Crowd, Citizens, Persons'],
            ['url' => 'https://cdn.pixabay.com/photo/2014/07/01/12/35/taxi-381233_960_720.jpg', 'alt' => 'Taxi, Road, Traffic, Cab, Vehicles, Yellow Taxis'],
            ['url' => 'https://cdn.pixabay.com/photo/2015/06/19/21/24/avenue-815297_960_720.jpg', 'alt' => 'Avenue, Trees, Path, Sunbeams, Sunrays, Woods'],
            ['url' => 'https://cdn.pixabay.com/photo/2015/03/03/05/56/avenue-656969_960_720.jpg', 'alt' => 'Avenue, Trees, Road, Tree Lined, Woodlands, Path'],
        ];
    }
}
