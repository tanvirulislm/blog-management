<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function CreateTag(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:tags,name|max:50',
        ]);

        $tag = Tag::create(['name' => $request->name]);

        return response()->json($tag, 201);
    }

    public function GetTags()
    {
        $tags = Tag::all();

        return response()->json($tags);
    }
}
