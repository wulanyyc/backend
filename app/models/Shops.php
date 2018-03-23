<?php

namespace Shop\Model;

use Phalcon\Mvc\Model;

class Shops extends Model
{
    public function getSource() {
        return "shops";
    }
}
