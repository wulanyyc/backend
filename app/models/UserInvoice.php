<?php

namespace Shop\Model;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Numericality;

class UserInvoice extends Model
{
    public function getSource() {
        return "user_invoice";
    }
}
