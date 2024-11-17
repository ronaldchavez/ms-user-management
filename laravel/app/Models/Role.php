<?php

namespace Spatie\Permission\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\User;

class Role extends \Spatie\Permission\Models\Role
{
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'model', 'model_has_roles', 'role_id', 'model_id');
    }
}
