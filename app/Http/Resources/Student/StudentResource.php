<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'id'        => $this->adm_id,
            'name'      => $this->adm_name,
            'number'    => $this->adm_code,
            'class_name'=> $this->st_class_name,
            'date'      => $this->date_check_in
        ];
    }
}
