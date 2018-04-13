<?php

namespace App\Http\Controllers;

use App\Http\Requests\Link\CreateLink;
use App\Http\Requests\Link\EditLink;
use Illuminate\Http\Request;
use App\Entity\Link;
use Illuminate\Support\Facades\Auth;
use Gate;
use App\UseCases\LinkService;
use Illuminate\Support\Facades\File;

class LinkController extends Controller
{
    private $linkservice;

    public function __construct(LinkService $linkservice)
    {
        $this->linkservice = $linkservice;
    }

    public function gallery(Request $request)
    {

        if (Auth::user()) {
            $imageLink = Link::where(function ($query) {
                $query->where('private', '=', false)
                    ->orWhere('user_id', '=', Auth::user()->id);
            })->whereNotNull('image')->paginate(5);
        } else {
            $imageLink = Link::whereNotNull('image')->where('private', '=', false)->paginate(5);
        }

        if (Gate::allows('list-private-links')) {
            $imageLink = Link::whereNotNull('image')->paginate(5);
        }

        if ($request->ajax()) {
            return view('links.pregallery', ['imageLink' => $imageLink])->render();
        }

        return view('links.gallery', compact('imageLink'));
    }

    public function index()
    {
        $links = Link::where('user_id', '=', Auth::user()->id)->paginate(3);
        return view('links.index', compact('links'));
    }

    public function create()
    {
        return view('links.create');
    }

    public function store(CreateLink $request)
    {
        $data = $request->all();
        $path = public_path() . '/images';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = '(' . uniqid() . ')' . $image->getClientOriginalName();
            $image->move($path, $data['image']);
        }
        $data['user_id'] = auth()->user()->id;

        $link = Link::create($data);
        return redirect()->route('list_links')->with('success', 'Link was created');
    }

    public function show(Link $link)
    {
        return view('links.show', compact('link'));
    }

    public function edit(Link $link)
    {
        return view('links.edit', compact('link'));
    }

    public function update(Link $link, EditLink $request)
    {

        $data = $request->all();
        $path = public_path() . '/images/';
        if ($request->hasFile('image')) {
            if (File::exists($path . $link->image)) { // unlink or remove previous image from folder
                unlink($path . $link->image);
            }
            $image = $request->file('image');
            $data['image'] = '(' . uniqid() . ')' . $image->getClientOriginalName();
            $image->move($path, $data['image']);
        }
        $data['user_id'] = auth()->user()->id;

        $link->fill($data)->save();
        return redirect()->route('show_link', ['id' => $link->id])->with('success', 'Link was updated');
    }

    public function destroy(Link $link)
    {
        $this->linkservice->destroy($link);
        return redirect()->route('main')->with('delete', 'Link was deleted');
    }
}
