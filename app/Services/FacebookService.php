<?php

namespace App\Services;

use Carbon\Carbon;
use Facebook\Facebook;
use Facebook\GraphNodes\GraphEdge;
use Facebook\GraphNodes\GraphNode;

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
        $sdk_query = $this->fb->get("me/albums", $token);

        return $sdk_query->getGraphEdge();
    }
}
