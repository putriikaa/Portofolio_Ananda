<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Hash;
use Intervention\Image\Facades\Image;
class ResizeController extends Controller
{

    public function index()
    {
        $data_users =  User::all();
        return view('post.users', compact('data_users'));
    }

    public function destroy($id) {
        $users = User::find($id);
    
        if (!$users) {
            return redirect()->route('users')->with('error', 'User not found');
        }
    
        $photo = $users->photo;
    
        $originalPath = public_path('storage/photos/original/' . $photo);
        if (File::exists($originalPath)) {
            File::delete($originalPath);
        }
    
        $thumbnailPath = public_path('storage/photos/thumbnail/' . $photo);
        if (File::exists($thumbnailPath)) {
            File::delete($thumbnailPath);
        }
    
         $squarePath = public_path('storage/photos/square/' . $photo);
         if (File::exists($squarePath)) {
             File::delete($squarePath);
         }
    
         $users->delete();
     
         return redirect()->back()->withSuccess('You have successfully deleted data!');
     }
     

    public function edit($id)
    {
        $users = User::find($id);
        $name = $users->name;
        $email = $users->email;
        $photo = $users->photo;
        return view('post.edit', compact('name', 'email', 'photo', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max: 250 |unique:users,email,' .$id,
            'photo' => 'image|nullable|max:1999',
        ]);

        $folderPathOriginal = public_path('storage/photos/original');
            $folderPathThumbnail = public_path('storage/photos/thumbnail');
            $folderPathSquare = public_path('storage/photos/square');

            if (!File::isDirectory($folderPathOriginal)) {
                File::makeDirectory($folderPathOriginal, 0777, true, true);
            }
            if (!File::isDirectory($folderPathThumbnail)) {
                File::makeDirectory($folderPathThumbnail, 0777, true, true);
            }
            if (!File::isDirectory($folderPathSquare)) {
                File::makeDirectory($folderPathSquare, 0777, true, true);
            }
       
        $users = User::find($id);
        if ($request->hasFile('photo')) {
            $photoPath = public_path('photos/original'. $users->photo);
            if (File::exists($photoPath)) 
            {
                File::delete($photoPath);
            }
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('photo')->storeAs('photos/original',$filenameSimpan);

            $users->photo = $filenameSimpan;
            $users->name = $request->input('name');
            $users->email = $request->input('email');
            $users->update();
        } else {
        }

        return redirect()->route('users')
            ->with('success', 'User photo is updated successfully.');
    }


    public function resizeForm($id)
    {
        $users = User::find($id);
        if (!$users) {
            return redirect('/users')->with('error', 'User not found.');
        }
        $userId = $users->id;
        return view('post.resize', compact('users', 'userId'));
    }
    
    
    public function resizeImage(Request $request, User $users)
    {
        $this->validate($request, [
            'size' => 'required|in:thumbnail,square',
            'photo' => 'required|string',
        ]);
        $size = $request->input('size');
        
        if (Storage::exists('photos/original/' . $users->photo)) {
            $originalImagePath = public_path('storage/photos/original/' . $users->photo);
        
            if ($size === 'thumbnail') {
                $resizedImage = Image::make($originalImagePath);
                $resizedImage->fit(160, 90);
                $resizedImage->save(public_path('storage/photos/thumbnail/' . $users->photo));
            } elseif ($size === 'square') {
                $resizedImage = Image::make($originalImagePath);
                $resizedImage->fit(100, 100);
                $resizedImage->save(public_path('storage/photos/square/' . $users->photo));
            }
        }
        return view('post.resize', compact('users'))->with('success', 'User photo is resized successfully.');
    }

}