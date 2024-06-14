<?php

namespace App\Http\Resources\Api\v1\User;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DefaultUserResource
 *
 * @mixin User
 */
class DefaultUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $role = $this->roles->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role_name' => $role->name,
        ];
    }
}
