<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommitmentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' => [
                'totalCommitments' => $this->total(),
                'commitmentsPerPage' => $this->count(),
                'currentPage' => $this->currentPage(),
                'previousPage' => $this->previousPageUrl(),
                'nextPage' => $this->nextPageUrl(),
                'pageUrls' => $this->getUrlRange(1, $this->lastPage())
            ],
        ];
    }
}
