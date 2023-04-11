<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Resource;
use App\Models\Tag;
use App\Models\Taggable;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::whereHas('resources')->get();
        return view('tags.index', compact('tags'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $tag = new Tag([
            'name' => $request->get('name'),
        ]);
        $tag->save();
        return redirect(route('tags.index'))->with('success', 'Tag saved!');
    }

    /**
     * @param Request $request
     */
    public function search(Request $request)
    {
        $tagsIds = $request->collect('tags')->unique();
        if ($tagsIds->isEmpty()) {
            return to_route('tags.index')->with('error', 'Please select at least one tag.');
        }
        $query = Tag::select('id')->whereIn('id', $tagsIds);
        $query = Taggable::select('taggable_id')->whereIn('tag_id', $query);
        $query = Taggable::select('tag_id')->whereIn('taggable_id', $query);
        $relatedTags = Tag::whereIn('id', $query)->get();

        $resources = Resource::whereHas('tags', fn($query) => $query->whereIn('tags.id', $tagsIds))
            ->with('tags')
            ->addSelect(DB::raw('1 as type'),'id','name')
            ->union(
                Post::whereHas('tags', fn($query) => $query->whereIn('tags.id', $tagsIds))
                    ->with('tags')
                    ->addSelect(DB::raw('2 as type'),'id','name')
            )
            ->get();

        return view('tags.search', compact('relatedTags', 'resources'));
    }
}
