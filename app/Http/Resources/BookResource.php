<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'title' => $this->title,
            'desc' => $this->description,
            'author' => $this->author,
            'image' => $this->image,
            'genre' => $this->genre,
            'year' => $this->year,
            'country' => $this->country,
            'pages' => $this->pages,
            'book' => $this->book
        ];
    }
}
