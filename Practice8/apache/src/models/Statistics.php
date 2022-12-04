<?php

namespace app\models;
require '../../vendor/autoload.php';
require_once '../../jpgraph/jpgraph.php';
require_once '../../jpgraph/jpgraph_line.php';
require_once '../../jpgraph/jpgraph_bar.php';
require_once '../../jpgraph/jpgraph_pie.php';
use BarPlot;
use Exception;
use GdImage;
use Graph;
use LinePlot;
use Nelmio\Alice\Loader\NativeLoader;
use PieGraph;
use PiePlot;

class Statistics
{
    const width = 800;
    const height = 600;
    public static function generateFixtures(){
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

    public static function drawImages(){

        $fixtures = Statistics::generateFixtures();
        $i = 0;
        $j = 0;
        $encodedImages = array();
        foreach ($fixtures as $shape) {
            if ($i === 3)
                $i = 0;
            $image = Statistics::addWatermark(Statistics::createGraphImage($i, $shape), Statistics::createWatermarkStamp($j));
            $encodedImages[] = 'data:image/png;base64,' . base64_encode($image);
            $i++;
            $j++;
        }
        return $encodedImages;
    }

    static function plotType(int $type, $data) {
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
    static function createGraphImage($type, $data): GdImage | bool | null{
        $type = intval($type);
        $data = explode(',', substr($data, 1, strlen($data)-2));
        if ($type != 0){
            $graph = new Graph(Statistics::width, Statistics::height);
            $graph->SetScale('intint');
            $graph->title->Set(($type == 1 ? 'Bar' : 'Line') .' graph');
            $graph->xaxis->title->Set('X-AXIS');
            $graph->yaxis->title->Set('Y-AXIS');
            $graph->Add(Statistics::plotType($type, $data));
        } else {
            $graph = new PieGraph(Statistics::width, Statistics::height);
            $graph->title->Set("Pie graph");
            $graph -> SetBox(true);
            $p1 = Statistics::plotType($type, $data);
            $graph->Add($p1);
            $p1->ShowBorder();
            $p1->SetSliceColors(array('#1E90FF','#2E8B57','#ADFF2F','#DC143C','#BA55D3'));
        }
        $graph->img->SetImgFormat('png');
        return $graph->Stroke(_IMG_HANDLER);
    }
    static function createWatermarkStamp(int $number): GdImage | bool {
        $image = imagecreate(100, 30);
        imagecolorallocatealpha($image, 255, 255, 255, 127);
        $textColor = imagecolorallocatealpha($image, 0, 0, 0, 100);
        imagestring($image, 5, 20, 5, 'Graph#' . $number, $textColor);
        return $image;
    }
    static function addWatermark(GdImage $image, GdImage $stamp) {
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