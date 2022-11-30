<?php
namespace application\models;

use application\core\Model;

class MyShape {
    public $red;
    public $blue;
    public $green;
    public $width;
    public $height;
    public function __toString(): string {
        return sprintf('[%d,%d,%d,%d,%d]', $this->red, $this->blue, $this->green, $this->width, $this->height);
    }
}