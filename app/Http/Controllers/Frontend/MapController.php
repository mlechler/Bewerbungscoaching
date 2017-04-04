<?php

namespace App\Http\Controllers\Frontend;

use Cornford\Googlmapper\Facades\MapperFacade as Mapper;

class MapController extends Controller
{
    public $count = 0;

    public function index($address)
    {
        $this->count = $this->count +1;
        $maps = Mapper::map($address->latitude, $address->longitude);
        for($i = 0;$i < $this->count-1; $i++){
            unset($maps->items[$i]);
        }
    }
}
