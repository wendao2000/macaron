<?php

namespace App\Model;

class Role extends BaseModel
{
    public function users() {
        return $this->belongsToMany(User::class, UserRole::class);
    }
}
