<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Tag;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $tags = $request->collect('tags');
        if ($tags->isEmpty()) {
            return to_route('tags.index')->with('error', 'Please select at least one tag.');
        }

        $resources = Resource::whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('tags.id', $tags->toArray());
        },'>=',$tags->count())->with('tags')->get();

        $relatedTags = $resources->flatMap(fn($resource) => $resource->tags->whereNotIn('id', $tags->toArray()))->unique('id')->values();
        $tags = Tag::all();
        return view('resources.index', compact('resources', 'tags', 'relatedTags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'tags' => 'required|array|min:1',
            'tags.*' => 'required|string',
        ]);

        $resource = new Resource([
            'name' => $validated['name'],
        ]);

        $resource->save();

        $resource->tags()->sync($validated['tags']);

        return back()->with('success', 'Resource saved!');
    }
}
//enjoy-driving-task-1-tags
