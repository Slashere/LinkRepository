<?php

namespace App\Entity;

use App\Http\Requests\Link\CreateLink;
use App\Http\Requests\Link\EditLink;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function build(CreateLink $request): self
    {
        $data = $request->all();
        return self::create($data);
    }

    public static function upgrade(Link $link, EditLink $request)
    {
        $link->link = $request->input('link') ?? $link->link;
        $link->title = $request->input('name') ?? $link->title;
        $link->description = $request->input('description') ?? $link->description;
        $link->private = $request->input('private') ?? $link->private;
    }
}
