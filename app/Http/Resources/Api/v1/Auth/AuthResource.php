<?php

namespace App\Http\Resources\Api\v1\Auth;

use App\Http\Resources\Api\v1\User\DefaultUserResource;
use App\Models\User;

/**
 * Class UserResource
 *
 * @mixin User
 */
class AuthResource extends DefaultUserResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
