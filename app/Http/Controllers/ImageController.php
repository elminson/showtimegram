<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $path;

    public function __construct()
    {
        $this->path = "images";
    }

    public function index()
    {
        return view('welcome');
    }

    public function posts()
    {
        $posts = new Post();
        return response()->json($posts->paginate(2));
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $res = Post::where('id', $id)->delete();
        if ($res == 1) {
            return response()->json(['success' => 'You have successfully delete an image'], 200);
        } else {
            return response()->json(['error' => 'Can\'t delete the Image'], 500);
        }
    }


    public function store(Request $request)
    {

        if ($request->get('image')) {
            $image = $request->get('image');
            $image = $this->imageData($image);
            $username = $request->get('username');
            $caption = $request->get('caption');
            $name = time() . '.' . $image['type'];
            $image_name = $this->generateRandomString() . "_" . $name;
            //Bug find "Laravel : Unable to init from given binary data. #634"
            //\Image::make($request->get('image'))->save(public_path($this->path) . "/" . $image_name);

            file_put_contents(public_path($this->path) . "/" . $image_name, $image['data']);
            $post = new Post();
            $post->username = $username;
            $post->caption = $caption;
            $post->image_name = $this->path . "/" . $image_name;
            $post->save();

            return response()->json(['success' => 'You have successfully uploaded an image'], 200);
        } else {
            return response()->json(['error' => 'Image is not set'], 500);
        }

    }

    public function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function imageData($data)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }

            $data = base64_decode($data);

            if ($data === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        return ['type' => $type, 'data' => $data];
    }

}

