<?php

namespace App\Http\Resources\Teacher;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
    public function toArray($request)
    {
        $now = Carbon::now();
        $year = ($this->adm_birthday == 0) ? 0 : explode('-', date("Y-m-d", $this->adm_birthday))[0];
        return [
            'key'       => $this->adm_id,
            'name'      => $this->adm_name,
            'age'       => ($year == 0 ) ? 0 : ($now->year - $year),
            'tel'       => $this->adm_phone,
            'level'     => 0,
            'address'   => ""
        ];
    }
}
