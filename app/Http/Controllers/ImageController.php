<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    protected $path;

    protected $paginate;

    public function __construct()
    {
        $this->path = "images";
        $this->paginate = 2;
    }

    public function index()
    {
        return view('welcome');
    }

    public function newDesign(Request $request)
    {
        $posts = new Post();
        $data = $posts->paginate($this->paginate);
        return view('new_design', ['data' => $data]);
    }

    public function postImage(Request $request)
    {
        $method = $request->method();
        if ($method == 'POST') {
            //var_dump($request->image);
            $image = $request->get('image');
            $username = $request->get('username');
            $caption = $request->get('caption');
            $name = time() . '.' . $request->image->getClientOriginalExtension();
            $image_name = $this->generateRandomString() . "_" . $name;
            $request->image->move(public_path($this->path) . "/", $image_name);
            $post = new Post();
            $post->username = $username;
            $post->caption = $caption;
            $post->image_name = $this->path . "/" . $image_name;
            $post->save();
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Post was successfully added!');
            return redirect('newdesign');//->with('success', 'Image posted!');
        } else {
            return view('new_design_form');
        }
    }


    public function posts()
    {
        $posts = new Post();
        return response()->json($posts->paginate($this->paginate));

    }

    public function destroy(Request $request, $idimage = null)
    {
        $id = $request->get('id') ?? $idimage;
        $res = Post::where('id', $id)->pluck('image_name');
        // We can move the image to a temp folder and delete after 10 days.
        Storage::delete('public/images/' . $res);
        $res = Post::where('id', $id)->delete();
        if ($idimage == null) {
            if ($res == 1) {
                return response()->json(['success' => 'You have successfully delete an image'], 200);
            } else {
                return response()->json(['error' => 'Can\'t delete the Image'], 500);
            }
        } else {
            $message = 'Can\'t delete the Image';
            if ($res == 1) {
                $message = 'You have successfully delete an image';
            }
            $request->session()->flash('message.level', 'warning');
            $request->session()->flash('message.content', $message);
            return redirect('newdesign')->with('success', $message);
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
