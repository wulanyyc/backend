<?php

namespace Shop\Model;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;

class Products extends Model
{
    public function getSource() {
        return "products";
    }
}
