<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PixelEvent extends Model
{
    public function getTitleAttribute() {

        $event = Event::where('id',$this->event_id)->get(['title']);

        $event_title = $event[0]->title;

        return $event_title;
    }
    
    public function getDescriptionAttribute() {

        $event = Event::where('id',$this->event_id)->get(['description']);

        $event_description = $event[0]->description;

        return $event_description;
    }
    
    public function getFormattedStatusAttribute() {

        if($this->status == 1)
          $status = 'Active';
        else
            $status = 'Disabled';

        return $status;
    }
}
