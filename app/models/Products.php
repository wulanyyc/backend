<?php

namespace Shop\Model;

use Phalcon\Mvc\Model;

class Products extends Model
{
    public function getSource() {
        return "products";
    }
}
