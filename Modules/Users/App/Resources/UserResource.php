<?php

namespace Modules\Users\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        // return parent::toArray($request);

        return [
            "id"            => $this->id,
            "name"          => $this->name,
            "first_name"    => $this->first_name,
            "last_name"     => $this->last_name,
            "email"         => $this->email,
            "photo"         => $this->photo,
            "status"        => $this->status,
        ];
    }
}
