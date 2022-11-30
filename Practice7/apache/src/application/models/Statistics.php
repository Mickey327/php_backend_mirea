<?php
namespace application\models;
require '../vendor/autoload.php';
require_once '../jpgraph/jpgraph.php';
require_once '../jpgraph/jpgraph_line.php';
require_once '../jpgraph/jpgraph_bar.php';
require_once '../jpgraph/jpgraph_pie.php';
use application\core\Model;
use BarPlot;
use Exception;
use GdImage;
use Graph;
use LinePlot;
use Nelmio\Alice\Loader\NativeLoader;
use PieGraph;
use PiePlot;

class Statistics extends Model {
    public $width = 800;
    public $height = 600;
    public function generateFixtures(){
        $loader = new NativeLoader();
        $objectSet = $loader->loadData([
            MyShape::class => [
                'myshape{1..50}' => [
                    'red' => '<numberBetween(0, 255)>',
                    'green' => '<numberBetween(0, 255)>',
                    'blue' => '<numberBetween(0, 255)>',
                    'width' => '<numberBetween(100, 500)>',
                    'height' => '<numberBetween(100, 500)>'
                ],
            ]
        ]);
        $array = $objectSet->getObjects();
        return $array;
    }

    public function drawImages(){

        $fixtures = $this->generateFixtures();
        $i = 0;
        $j = 0;
        $encodedImages = array();
        foreach ($fixtures as $shape) {
            if ($i === 3)
                $i = 0;
            $image = $this->addWatermark($this->createGraphImage($i, $shape), $this->createWatermarkStamp($j));
            $encodedImages[] = 'data:image/png;base64,' . base64_encode($image);
            $i++;
            $j++;
        }
        return $encodedImages;
    }

    function plotType(int $type, $data) {
        return match($type) {
            0 => new PiePlot($data),
            1 => new BarPlot($data),
            2 => new LinePlot($data),
            default => throw new Exception()
        };
    }

    /**
     * @throws Exception
     */
    function createGraphImage($type, $data): GdImage | bool | null{
        $type = intval($type);
        $data = explode(',', substr($data, 1, strlen($data)-2));
        if ($type != 0){
            $graph = new Graph($this->width, $this->height);
            $graph->SetScale('intint');
            $graph->title->Set(($type == 1 ? 'Bar' : 'Line') .' graph');
            $graph->xaxis->title->Set('X-AXIS');
            $graph->yaxis->title->Set('Y-AXIS');
            $graph->Add($this->plotType($type, $data));
        } else {
            $graph = new PieGraph($this->width, $this->height);
            $graph->title->Set("Pie graph");
            $graph -> SetBox(true);
            $p1 = $this->plotType($type, $data);
            $graph->Add($p1);
            $p1->ShowBorder();
            $p1->SetSliceColors(array('#1E90FF','#2E8B57','#ADFF2F','#DC143C','#BA55D3'));
        }
        $graph->img->SetImgFormat('png');
        return $graph->Stroke(_IMG_HANDLER);
    }
    function createWatermarkStamp(int $number): GdImage | bool {
        $image = imagecreate(100, 30);
        imagecolorallocatealpha($image, 255, 255, 255, 127);
        $textColor = imagecolorallocatealpha($image, 0, 0, 0, 100);
        imagestring($image, 5, 20, 5, 'Graph#' . $number, $textColor);
        return $image;
    }
    function addWatermark(GdImage $image, GdImage $stamp) {
        $stampWidth = imagesx($stamp);
        $stampHeight = imagesy($stamp);
        imagecopy(
            $image, $stamp,
            imagesx($image) - $stampWidth - 360,
            imagesy($image) - $stampHeight - 330,
            0, 0,
            $stampWidth, $stampHeight
        );
        // Begin capturing the byte stream
        ob_start();

        // generate the byte stream
        imagepng($image);
        // and finally retrieve the byte stream
        $rawImageBytes = ob_get_clean();
        imagedestroy($image);
        return $rawImageBytes;
    }
}