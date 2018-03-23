<?php

namespace Shop\Model;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class Users extends Model
{
    public function getSource() {
        return "users";
    }

    public function validation() {
        $validator = new Validation();
        $validator->add('openid', new PresenceOf(
            [
                "message" => "openid is required",
            ]
        ));

        $validator->add('openid', new Uniqueness(
            [
                "message" => "openid is already exsit",
            ]
        ));

        return $this->validate($validator);
    }

    public function getMessages()
    {
        $messages = [];

        foreach (parent::getMessages() as $message) {
            switch ($message->getType()) {
                case "InvalidValue":
                    $messages[] = "The  field" . $message->getField() . " is invalid";
                    break;

                case "InvalidCreateAttempt":
                    $messages[] = "The record cannot be created because it already exists";
                    break;

                case "InvalidUpdateAttempt":
                    $messages[] = "The record cannot be updated because it doesn't exist";
                    break;

                case "PresenceOf":
                    $messages[] = "The field " . $message->getField() . " is mandatory";
                    break;
            }
        }

        return $messages;
    }
}
