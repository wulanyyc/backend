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
        $this->validate(
            new Uniqueness(
                [
                    "field"   => "openid",
                    "message" => "Value of field 'openid' is already present in another record",
                ]
            )
        );

        if ($this->validationHasFailed() === true) {
            return false;
        }
    }
}
