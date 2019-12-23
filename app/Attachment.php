<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use PhpImap\IncomingMail;

class Attachment extends BaseModel
{
    public function attachable()
    {
        return $this->morphTo();
    }

    public static function storeAttachmentFromRequest($request, $attachable)
    {
        $path = str_replace(' ', '_', $attachable->id.'_'.$request->file('attachment')->getClientOriginalName());
        Storage::putFileAs('public/attachments/', $request->file('attachment'), $path);
        $attachable->attachments()->create(['path' => $path]);
    }

    /**
     * @param IncomingMail $mail
     * @param $attachable
     */
    public static function storeAttachmentsFromEmail($mail, $attachable)
    {
        foreach ($mail->getAttachments() as $mailAttachment) {
            $path = str_replace(' ', '_', $attachable->id.'_'.$mailAttachment->name);
            Storage::put('public/attachments/'.$path, file_get_contents($mailAttachment->filePath));
            $attachable->attachments()->create(['path' => $path]);
            unlink($mailAttachment->filePath);
        }
    }
}
