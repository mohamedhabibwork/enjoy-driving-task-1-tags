<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

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
}
