<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;
use Carbon\Carbon;

class IndividualCoachingPresenter extends BasePresenter
{
    public function formatDate()
    {
        return $this->date->format('d.m.Y');
    }

    public function formatTime()
    {
        $time = Carbon::parse($this->time);
        return $time->format('H:i').' - '.$time->addHours($this->duration)->format('H:i');
    }

    public function trialHighlight(){
        if($this->trial){
            return 'info';
        }
    }
}