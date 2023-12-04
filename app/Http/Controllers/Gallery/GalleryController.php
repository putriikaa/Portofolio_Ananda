<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Post;
use Illuminate\Support\Facades\File;


class GalleryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     //supaya login dulu baru dapat mengakses gallery portofolio
     public function __construct()
     {
         $this->middleware('auth');
     }
    public function index()
    {

        $data = array(
            'id' => "posts",
            'menu' => 'Gallery',
            'galleries' => Post::where('picture', '!=',
           '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
            );
            return view('gallery.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gallery.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     

             $folderRESIZE = public_path('public/storage/posts_image/resize');
            if (!File::isDirectory($folderRESIZE)) {
                File::makeDirectory($folderRESIZE, 0777, true, true);
            }

             // Save the original image
             $path = $request->file('picture')->storeAs('public/posts_image/asli', $filenameSimpan);
     
             // Create and save thumbnail
             $thumbnailPath = public_path("public/storage/posts_image/resize/{$filenameSimpan}");
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gallery = Post::find($id);
        return view('gallery.edit', compact('gallery'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
    
        $post = Post::find($id);
    
        if (!$post) {
            return redirect()->route('gallery.index')->with('error', 'Post tidak ditemukan.');
        }
    
        $post->title = $request->input('title');
        $post->description = $request->input('description');
    
        if ($request->hasFile('picture')) {
            // Upload gambar baru jika ada berkas yang diunggah
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('posts_image', $imageName);
    
            // Create and save thumbnail
            $thumbnailPath = public_path("public/storage/posts_image/resize/{$imageName}");
            $thumbnail = Image::make($image)->fit(400, 200);
            $thumbnail->save($thumbnailPath);
    
            $post->picture = $imageName;
        }
    
        $post->save();
    
        return redirect()->route('gallery.index')->with('success', 'Post berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $gallery = Post::find($id); // Menggunakan model Post
    
        if (!$gallery) {
            return redirect()->route('gallery.index')->with('error', 'Gambar tidak ditemukan.');
        }
    
        // Hapus gambar dari direktori jika diperlukan
    
        $gallery->delete();
    
        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil dihapus.');
    }
    
}
