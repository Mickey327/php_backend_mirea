<?php
require_once '../../jpgraph/jpgraph.php';
require_once '../../jpgraph/jpgraph_line.php';
require_once '../../jpgraph/jpgraph_bar.php';
require_once '../../jpgraph/jpgraph_pie.php';
const width = 800, height = 600;
if (isset($_GET['number']) && is_numeric($_GET['number'])){
    try {
        addWatermark(createGraphImage(), createWatermarkStamp($_GET['number']));
    } catch (Exception $e) {
        error_log('Cant create image', $e->getMessage());
    }
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
    if (isset($_GET['type'])){
        $type = $_GET['type'];
    }
    if (isset($_GET['data'])){
        $data = $_GET['data'];
    }
    if (!isset($type) || !is_numeric($type)
        || !isset($data) || !is_string($data)) {
        exit(1);
    }
    $type = intval($type);
    $data = explode(',', substr($data, 1, strlen($data)-2));
    if ($type != 0){
        $graph = new Graph(width, height);
        $graph->SetScale('intint');
        $graph->title->Set(($type == 1 ? 'Bar' : 'Line') .' graph');
        $graph->xaxis->title->Set('X-AXIS');
        $graph->yaxis->title->Set('Y-AXIS');
        $graph->Add(plotType($type, $data));
    } else {
        $graph = new PieGraph(width, height);
        $graph->title->Set("Pie graph");
        $graph -> SetBox(true);
        $p1 = plotType($type, $data);
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
    header('Content-type: image/png');
    imagepng($image);
    imagedestroy($image);
}
