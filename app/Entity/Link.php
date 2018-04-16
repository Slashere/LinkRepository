<?php

namespace App\Entity;

use App\Http\Requests\Link\ApiCreateLink;
use App\Http\Requests\Link\CreateLink;
use App\Http\Requests\Link\EditLink;
use Faker\Provider\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class Link extends Model
{
    protected $table = 'links';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function build(ApiCreateLink $request): self
    {
        $data = $request->all();
        $path = public_path() . '/images/';
        $explode = explode(',', $request['image']);
        $image = $explode[1];
        $file = base64_decode($image);
        $safeName = str_random(10).'.'.'png';
        file_put_contents($path .$safeName, $file);

        //save new file path into db
        $data['image'] = $safeName;
        $data['user_id'] = auth()->user()->id;

        return self::create($data);
    }

    public static function upgrade(Link $link, EditLink $request)
    {
        $data = $request->all();
        $path = public_path() . '/images/';
        if ($request->has('image')) {
            if (File::exists($path . $link->image)) { // unlink or remove previous image from folder
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

        $link->fill($data)->save();
    }
}
