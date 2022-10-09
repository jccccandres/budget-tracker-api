<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\UserResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'typeId' => $this->type_id,
            'categoryId' => $this->category_id,
            'note' => $this->note,
            'amount' => $this->amount,
            'dateTransact' => date('F j, Y', strtotime($this->date_transact)),
            'type' => new TypeResource($this->type),
            'category' => new CategoryResource($this->category)
        ];
    }
}
