<?php

namespace Modules\Codes\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CodesApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
