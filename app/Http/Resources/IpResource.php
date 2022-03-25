<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        // return parent::toArray($request);
        $histories = [];
        foreach ($this->histories as $history) {
            $histories[] = array(
                "history" => $history->history,
                "id" => $history->id,
                "created_at" => date('Y-m-d H:i:s', strtotime($history->created_at)),
                "user" => $history->user->name,
            );
        }

        return [
            "id"=> $this->id,
            "ip_add"=> $this->ip_add,
            "label"=> $this->label,
            "created_at"=> date('Y-m-d H:i:s', strtotime($this->created_at)),
            "histories"=> $histories
        ];
    }
}
