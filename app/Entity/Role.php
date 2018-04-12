<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    public $timestamps = false;
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class,'id');
    }

    public function hasAccess(array $permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    protected function hasPermission(string $permission)
    {
        $permissions = json_decode($this->permissions, true);
        return $permissions[$permission] ?? false;
    }
}