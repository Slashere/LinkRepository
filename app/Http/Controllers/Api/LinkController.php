<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Link\ApiCreateLink;
use App\Http\Requests\Link\ApiEditLink;
use App\Entity\Link;
use App\Entity\User;
use Gate;
use App\UseCases\LinkService;
use App\Http\Controllers\Controller;
use Response;
use Validator;
use Auth;


class LinkController extends Controller
{
    private $linkservice;

    public function __construct(LinkService $linkservice)
    {
        $this->linkservice = $linkservice;
    }

    public function index()
    {
        $allLinks = $this->linkservice->getAllLinks();
        return response()->json(['response' => 'success', 'all links' => $allLinks]);
    }

    public function showMyLinks()
    {
        $user = Auth::user();
        dd($user);
        $allMyLinks = $this->linkservice->getMyLinks();
        return response()->json(['response' => 'success', 'my links' => $allMyLinks]);
    }

    public function show(Link $link)
    {
        $showLink = $this->linkservice->getApiLink($link);
        return response()->json(['response' => 'success', 'show' => $showLink]);
    }

    public function store(ApiCreateLink $request)
    {
        $createdLink = $this->linkservice->create($request);
        return response()->json(['response' => 'success', 'created' => $createdLink]);
    }

    public function update(Link $link, ApiEditLink $request)
    {
        $updatedLink = $this->linkservice->update($link, $request);
        return response()->json(['response' => 'success', 'updated' => $updatedLink]);
    }

    public function destroy(Link $link)
    {
        $this->linkservice->delete($link);
        return response()->json(['response' => 'success', 'deleted' => $link]);
    }
}