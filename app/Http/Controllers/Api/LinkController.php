<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Link\CreateLink;
use App\Http\Requests\Link\EditLink;
use Illuminate\Http\Request;
use App\Entity\Link;
use Gate;
use App\UseCases\LinkService;
use App\Http\Controllers\Controller;
use Validator;

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
        $allMyLinks = $this->linkservice->getMyLinks();
        return response()->json(['response' => 'success', 'my links' => $allMyLinks]);
    }

    public function show(Link $link)
    {
        $link = $this->linkservice->getLink($link);
        return response()->json(['response' => 'success', 'created' => $link]);
    }

    public function store(CreateLink $request)
    {
        $createdLink = $this->linkservice->create($request);
        return response()->json(['response' => 'success', 'created' => $createdLink]);
    }

    public function update(Link $link, EditLink $request)
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