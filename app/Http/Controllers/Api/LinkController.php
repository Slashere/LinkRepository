<?php
namespace App\Http\Controllers\Api;

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
    }
    public function showMyLinks()
    {
    }
    public function show(Link $link)
    {
        if(Gate::allows('show-private-link', $link)){
            return 1;
        }
        return $link;

    }
    public function store(Request $request)
    {
        return $this->linkservice->create($request);
    }
    public function update(Link $link, EditLink $request)
    {
        $this->linkservice->update($link, $request);
    }
    public function destroy(Link $link)
    {
        $this->linkservice->destroy($link);
    }
}