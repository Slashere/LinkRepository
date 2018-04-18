<?php
/**
 * Created by PhpStorm.
 * User: Slash
 * Date: 03.04.2018
 * Time: 2:07
 */

namespace App\UseCases;

use Illuminate\Auth\Access\AuthorizationException;

use App\Entity\Link;
use App\Http\Requests\Link\ApiCreateLink;
use Gate;
use Validator;
use App\Http\Requests\Link\ApiEditLink;
use Auth;
use Illuminate\Support\Facades\File;

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
            return $link;
        } else {
            abort(403);
        }
    }

    public function getApiLink(Link $link)
    {

        if (Gate::allows('api-show-private-link', $link) or $link->private == 0) {
            return $link;
        } else {
            throw new AuthorizationException();
        }
    }

    public function update(Link $link, ApiEditLink $request)
    {
        $data = $request->all();
        $path = public_path() . '/images/';
        if ($request->has('image')) {
            if ($link->image != NULL && File::exists($path . $link->image)) { // unlink or remove previous image from folder
                unlink($path . $link->image);
            }
            $explode = explode(',', $request['image']);
            $image = $explode[1];
            $file = base64_decode($image);
            $safeName = str_random(10).'.'.'png';
            file_put_contents($path .$safeName, $file);

            //save new file path into db
            $data['image'] = $safeName;
        }
        $data['user_id'] = auth()->user()->id;

        if( $link->fill($data)->save()) {
            return $link;
        }
    }

    public function create(ApiCreateLink $request)
    {
        $data = $request->all();
        $path = public_path() . '/images/';
        if ($request->has('image')) {
            $explode = explode(',', $request['image']);
            $image = $explode[1];
            $file = base64_decode($image);
            $safeName = str_random(10) . '.' . 'png';
            file_put_contents($path . $safeName, $file);

            //save new file path into db
            $data['image'] = $safeName;
        }
        $data['user_id'] = auth()->user()->id;

        return Link::create($data);
    }

    public function delete(Link $link)
    {
        $link->delete();
    }

}