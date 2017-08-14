<?php

namespace App;

use App\Services\Mailchimp;

trait Subscribable{

    public abstract function getSubscribableEmail();
    public abstract function getSubscribableName();

    public function getSubscribableLists(){
        $listIds = config('services.mailchimp.tag_list_id');
        return array_intersect_key($listIds, array_flip($this->tags->pluck('name')->toArray()));
    }

    public function subscribeToMailchimp(){
        $mailchimp      = app()->make(Mailchimp::class);
        $fullNameArray  = explode(" ", $this->getSubscribableName());
        $firstName      = array_shift($fullNameArray);
        foreach($this->getSubscribableLists() as $listName => $listId){
            $mailchimp->subscribe($listId, $this->getSubscribableEmail(), $firstName, join($fullNameArray, " "));
        }
    }
}