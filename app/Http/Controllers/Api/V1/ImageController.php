<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    //


    public function upload(Request $request) {
    $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
    $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
    $request->file('image')->move(public_path('images/products'), $imageName);
    return response()->json(['message' => 'Imagen subida', 'path' => '/images/products/' . $imageName]);

    }
    
}
