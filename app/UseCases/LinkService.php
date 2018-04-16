<?php
/**
 * Created by PhpStorm.
 * User: Slash
 * Date: 03.04.2018
 * Time: 2:07
 */

namespace App\UseCases;

use App\Entity\User;
use App\Entity\Link;
use App\Http\Requests\Link\ApiCreateLink;
use Illuminate\Http\Request;
use Gate;
use Validator;
use App\Http\Requests\Link\EditLink;
use Auth;

class LinkService
{

    public function getMyLinks()
    {
        $links = Link::where('user_id', '=', Auth::user()->id)->paginate(3);
        return $links;
    }

    public function getAllLinks()
    {
        if (Gate::allows('list-private-links')) {
            return $links = Link::paginate(4);
        }

        if (Auth::user()) {
            return $links = Link::where('private', '=', false)->orWhere('user_id', '=', Auth::user()->id)->paginate(4);
        } else {
            return $links = Link::where('private', '=', false)->paginate(4);
        }
    }

    public function getLink(Link $link)
    {
        if (Gate::allows('show-private-link', $link) or $link->private == 0) {
            $link = Link::findOrFail($link->id);
        } else {
            abort(403);
        }
        return $link;
    }

    public function update(Link $link, EditLink $request)
    {
        $link->upgrade($link, $request);

        if( $link->update()) {
            return $link;
        }
    }

    public function create(ApiCreateLink $request)
    {
        return Link::build($request);
    }

    public function delete(Link $link)
    {
        $link->delete();
    }

}