<?php

namespace App\Services\Pop3;

class Pop3Message{
    protected $attributes;
    protected $connection;
    protected $headers;
    protected $plain_body;

    public function __construct($connection, $attributes){
        $this->connection = $connection;
        $this->attributes = $attributes;
    }

    public function subject(){
        return mb_decode_mimeheader($this->attributes->subject);
    }

    public function from(){
        $from = explode(" ", mb_decode_mimeheader($this->attributes->from));
        return [
            "email" => str_replace(">","",str_replace("<","", array_pop($from) )),
            "name" => str_replace("_"," ", implode(" ", $from)),
        ];
    }

    public function body(){
        if($this->plain_body) return $this->plain_body;
        $mimes_array = collect($this->mime_to_array());
        $this->plain_body = $mimes_array[1]["data"];
        return $this->plain_body;
    }

    function fetchHeaders() {
        $headers = (imap_fetchheader($this->connection, $this->uid, FT_PREFETCHTEXT));
        return $this->headers = $this->parseHeaders($headers);
    }

    private function parseHeaders($headers){
        $headers = preg_replace('/\r\n\s+/m', '', $headers);
        preg_match_all('/([^: ]+): (.+?(?:\r\n\s(?:.+?))*)?\r\n/m', $headers, $matches);
        foreach ($matches[1] as $key => $value) $result[$value] = $matches[2][$key];
        return $result;
    }

    function mime_to_array($parse_headers = false) {
        $mail = imap_fetchstructure($this->connection, $this->uid);
        $mail = $this->mail_get_parts($mail, 0);
        if ($parse_headers) $mail[0]["parsed"] = $this->parseHeaders($mail[0]["data"]);
        return ($mail);
    }

    function mail_get_parts($part, $prefix) {
        $attachments = [];
        $attachments[$prefix] = $this->mail_decode_part($part, $prefix);
        if (isset($part->parts)) // multipart
        {
            $prefix = ($prefix == "0") ? "" : "$prefix.";
            foreach ($part->parts as $number => $subpart) {
                if($subpart->subtype == "PLAIN")
                    $attachments = array_merge($attachments, $this->mail_get_parts($subpart, $prefix . ($number + 1)));
            }
        }
        return $attachments;
    }

    function mail_decode_part($part, $prefix) {
        $attachment = [];
        if ($part->ifdparameters) {
            foreach ($part->dparameters as $object) {
                $attachment[strtolower($object->attribute)] = $object->value;
                if (strtolower($object->attribute) == 'filename') {
                    $attachment['is_attachment'] = true;
                    $attachment['filename'] = $object->value;
                }
            }
        }

        if ($part->ifparameters) {
            foreach ($part->parameters as $object) {
                $attachment[strtolower($object->attribute)] = $object->value;
                if (strtolower($object->attribute) == 'name') {
                    $attachment['is_attachment'] = true;
                    $attachment['name'] = $object->value;
                }
            }
        }

        $attachment['data'] = imap_fetchbody($this->connection, $this->uid, $prefix);
        if ($part->encoding == 3) { // 3 = BASE64
            $attachment['data'] = base64_decode($attachment['data']);
        } elseif ($part->encoding == 4) { // 4 = QUOTED-PRINTABLE
            $attachment['data'] = quoted_printable_decode($attachment['data']);
        }
        return ($attachment);
    }


    function delete() {
        return (imap_delete($this->connection, $this->uid ));
    }

    public function __get($name) {
        return $this->attributes->$name;
    }
}