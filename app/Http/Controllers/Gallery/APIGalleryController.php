<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class APIGalleryController extends Controller
{
        /**
    * @OA\Get(
        * path="/api/apigallery",
        * tags={"Get Gallery Portofolio"},
        * summary="Gallery Ananda Kusuma Putri",
        * description="Data Gallery",
        * operationId="GetGallery",
    * @OA\Response(
            * response="default",
            * description="successful operation"
        * )
    * )
    */

    public function getGallery()
    {
        $post = Post::all();
        return response()->json(["data" => $post]);
    }

    public function index(){
        $response = Http::get('http://127.0.0.1:9000/api/apigallery');
        $datas = $response->object()->data;
        return view('gallery.index', compact('datas'));
    }
   /**
* @OA\Post(
* path="/api/apigallery",
* tags={"gallery"},
* summary="Create a new gallery",
* description="Create a new gallery with title, description, and optional image upload.",
* operationId="createGallery",
* @OA\RequestBody(
*    required=true,
*    description="Gallery details",
*    @OA\MediaType(
*        mediaType="multipart/form-data",
*        @OA\Schema(
*            @OA\Property(
*                property="title",
*                type="string",
*                description="Gallery title",
*                example="My Gallery"
*            ),
*            @OA\Property(
*                property="description",
*                type="string",
*                description="Gallery description",
*                example="A beautiful gallery"
*            ),
*            @OA\Property(
*                property="picture",
*                type="string",
*                format="binary",
*                description="Image file"
*            ),
*        ),
*    ),
* ),
* @OA\Response(
*    response="201",
*    description="Gallery created successfully",
* ),
* )
*/


public function store(Request $request)
{
    $this->validate($request, [
        'title' => 'required|max:255',
        'description' => 'required',
        'picture' => 'image|nullable|max:1999'
    ]);

    $filenameSimpan = 'noimage.png';

    if ($request->hasFile('picture')) {
        $image = $request->file('picture');
        $basename = uniqid() . time();
        $filenameSimpan = "{$basename}.{$image->getClientOriginalExtension()}";


        $folderRESIZE = public_path('storage/posts_image/resize');
       if (!File::isDirectory($folderRESIZE)) {
           File::makeDirectory($folderRESIZE, 0777, true, true);
       }

        // Save the original image
        $path = $request->file('picture')->storeAs('posts_image/asli', $filenameSimpan);

        // Create and save thumbnail
        $thumbnailPath = public_path("storage/posts_image/resize/{$filenameSimpan}");
        $thumbnail = Image::make($image)->fit(400,200);
        $thumbnail->save($thumbnailPath);
    }

    $post = new Post;
    $post->picture = $filenameSimpan;
    $post->title = $request->input('title');
    $post->description = $request->input('description');
    $post->save();

    return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
}

} 
