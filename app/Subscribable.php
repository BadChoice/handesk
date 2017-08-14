<?php

namespace App;

use App\Jobs\SubscribeToMailchimp;

trait Subscribable{

    public abstract function getSubscribableEmail();
    public abstract function getSubscribableName();

    public function getSubscribableLists(){
        $listIds = config('services.mailchimp.tag_list_id');
        return array_intersect_key($listIds, array_flip($this->tags->pluck('name')->toArray()));
    }

    public function subscribeToMailchimp(){
        $fullNameArray  = explode(" ", $this->getSubscribableName());
        $firstName      = array_shift($fullNameArray);
        $fullName       = join($fullNameArray, " ");
        foreach( $this->getSubscribableLists() as $listName => $listId){
            dispatch( new SubscribeToMailchimp($listId, $this->getSubscribableEmail(), $firstName, $fullName) );
        }
    }
}