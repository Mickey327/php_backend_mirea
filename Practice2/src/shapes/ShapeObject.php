<?php
abstract class ShapeObject{
    private $color;

    /**
     * @param $color
     */
    public function __construct($color)
    {
        $this->color = $color;

    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }


    public function getStyle(): string
    {
        $css = "fill: " . $this->getColor() . ";
        stroke: " . $this->getColor() . ";
        stroke-width: " . $this->getColor() . ";";
        return $css;
    }
    public abstract function getShapeTag();
}
class Circle extends ShapeObject{
    private $radius;

    /**
     * @param $radius
     */
    public function __construct($radius, $color)
    {
        parent::__construct($color);
        $this->radius = $radius;
    }
    /**
     * @param $radius
     */

    /**
     * @return mixed
     */
    public function getRadius()
    {
        return $this->radius;
    }

    /**
     * @param mixed $radius
     */
    public function setRadius($radius): void
    {
        $this->radius = $radius;
    }


    public function getShapeTag()
    {
        $center = $this->radius + 10;
        $style = $this->getStyle();
        $circleTag = "<circle style='$style' cx ='$center' cy ='$center' r ='$this->radius'/>";
        echo $circleTag;
    }
}
class Rectangle extends ShapeObject{
    private $width;
    private $height;

    /**
     * @param $width
     * @param $height
     */
    public function __construct($width, $height, $color)
    {
        parent::__construct($color);
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width): void
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height): void
    {
        $this->height = $height;
    }

    public function getShapeTag()
    {
        $style = $this->getStyle();
        $rectangleTag = "<rect width='$this->width' height='$this->height' style='$style'/>";
        echo $rectangleTag;
    }


}
