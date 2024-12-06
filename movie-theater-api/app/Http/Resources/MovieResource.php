<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->movie_id,
            'name' => $this->movie_name,
            'summary' => $this->summary,
            'realeaseDate' => $this->release_date,
            'author' => $this->author,
            'actor' => $this->actor,
            'language' => $this->language,
            'trailer' => $this->trailer,
            'enabled' => $this->is_enabled,
            'poster' => $this->poster_url,
            'banner' => $this->banner_url,
            'categoryId' => $this->categories->pluck('category_id')->toArray(),
        ];
    }
}
