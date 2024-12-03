<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource {
    public $status;
    public $message;
    public $resource;

    public function _construct($status, $message, $resource) {
        parent::_construct($resource);
        $this->status = $status;
        $this->message = message;
    }

    public function toArray(Request $request): array
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->resource,
        ];
    }
}