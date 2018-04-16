<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\Link\ApiCreateLink;
use App\Http\Requests\Link\EditLink;
use Illuminate\Http\Request;
use App\Entity\Link;
use Gate;
use App\UseCases\LinkService;
use App\Http\Controllers\Controller;
use Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
        try {
        $link = $this->linkservice->getLink($link);
        } catch (HttpException $e) {
            throw new HttpResponseException(
                Response::json([
                'code' => 403,
                'message' => 'This action is unauthorized.',
            ],403)
            );
        }
        return response()->json(['response' => 'success', 'show' => $link]);
    }

    public function store(ApiCreateLink $request)
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