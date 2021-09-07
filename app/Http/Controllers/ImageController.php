<?php

namespace App\Http\Controllers;

use App\Repositories\ImagesReposotory;

class ImageController extends Controller
{
    public function index(ImagesReposotory $imagesReposotory)
    {
        $images = $imagesReposotory->getUserImage();
        return view('dashboard', compact('images'));
    }
}
