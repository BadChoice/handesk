<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends BaseModel
{
    use SoftDeletes, Taggable;

    const STATUS_NEW            = 1;
    const STATUS_FIRST_CONTACT  = 2;
    const STATUS_VISITED        = 3;
    const STATUS_COMPLETED      = 4;
    const STATUS_FAILED         = 5;

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function statusUpdates() {
        return $this->hasMany( LeadStatusUpdate::class )->latest();
    }

    public function updateStatus($user, $body, $status) {
        if( ! $this->user)  $this->update(["status" => $status, "updated_at" => Carbon::now(), "user_id" => $user->id] );
        else                $this->update(["status" => $status, "updated_at" => Carbon::now()] );
        $this->statusUpdates()->create( ["user_id" => $user->id, "new_status" => $status, "body" => $body] );
    }

    public static function availableStatus() {
        return [
            static::STATUS_NEW              => "new",
            static::STATUS_FIRST_CONTACT    => "first-contact",
            static::STATUS_VISITED          => "visited",
            static::STATUS_COMPLETED        => "completed",
            static::STATUS_FAILED           => "failed"
        ];
    }

    public function statusName() {
        return static::getStatusText($this->status);
    }

    public static function getStatusText($status) {
        return static::availableStatus()[$status];
    }

//    public function subscribeToMailchimp(){
//        $listId = $this->getMailchimpListId();
//        if ($listId) {
//            $fullNameArray = explode(" ", $this->fullName);
//            $firstName = array_shift($fullNameArray);
//            (new Mailchimp())->subscribe($listId, $this->email, $firstName, join($fullNameArray, " "));
//        }
//    }
//
//    public function getMailchimpListId() {
//        //$listIds = config('services.mailchimp.list_ids');
//        //return array_key_exists($this->source, $listIds) ? $listIds[$this->source] : false;
//    }
}
