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
        return view('APIGallery.index', compact('datas'));
    }
    public function create()
    {
        return view('APIGallery.create');
    }
   /**
* @OA\Post(
* path="/api/storeGallery",
* tags={"upload gallery"},
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
*            ),
*            @OA\Property(
*                property="description",
*                type="string",
*                description="Gallery description",
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
*    response="200",
*    description="Gallery created successfully",
* ),
* )
*/


public function storeGallery(Request $request)
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


        $folderRESIZE = public_path('storage/posts_image/');
       if (!File::isDirectory($folderRESIZE)) {
           File::makeDirectory($folderRESIZE, 0777, true, true);
       }

        // Save the original image
        $path = $request->file('picture')->storeAs('posts_image/', $filenameSimpan);

        // Create and save thumbnail
        $thumbnailPath = public_path("storage/posts_image/{$filenameSimpan}");
        $thumbnail = Image::make($image)->fit(400,200);
        $thumbnail->save($thumbnailPath);
    }

    $post = new Post;
    $post->picture = $filenameSimpan;
    $post->title = $request->input('title');
    $post->description = $request->input('description');
    $post->save();

    return redirect()->route('resultGallery')->with('success', 'Berhasil menambahkan data baru');
}

// /**
//  * @OA\Post(
//  *     path="/api/deleteGallery/{id}",
//  *     tags={"Hapus Gambar Upload"},
//  *     summary="Hapus Upload",
//  *     description="Hapus gambar yang telah diupload",
//  *     operationId="hapusUpload",
//  *     @OA\Parameter(
//  *         name="id",
//  *         description="id upload",
//  *         required=true,
//  *         in="path",
//  *         @OA\Schema(
//  *             type="string"
//  *         )
//  *     ),
//  *     @OA\Response(
//  *         response="default",
//  *         description="successful operation"
//  *     )
//  * )
//  */
} 
