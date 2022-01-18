<?php

namespace app\models;

use app\core\Model;

class ContactForm extends Model
{
    public string $subject = '';
    public string $email = '';
    public string $body = '';

    public function rules():array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'subject' => [self::RULE_REQUIRED],
            'body' => [self::RULE_REQUIRED]
        ];
    }

    public function labels():array
    {
        return [
            'email' => 'Your email',
            'subject' => 'Subject',
            'body' => 'Description'
        ];
    }

    public function send()
    {
        return true;
    }
}