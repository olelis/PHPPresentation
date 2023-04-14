<?php

include_once 'Sample_Header.php';

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Shape\Chart\Series;
use PhpOffice\PhpPresentation\Shape\Chart\Type\Bar;
use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Fill;

// Create new PHPPresentation object
echo date('H:i:s') . ' Create new PHPPresentation object' . EOL;
$objPHPPresentation = new PhpPresentation();

// Set properties
echo date('H:i:s') . ' Set properties' . EOL;
$objPHPPresentation->getDocumentProperties()->setCreator('PHPOffice')
    ->setLastModifiedBy('PHPPresentation Team')
    ->setTitle('Sample 08 Title')
    ->setSubject('Sample 08 Subject')
    ->setDescription('Sample 08 Description')
    ->setKeywords('office 2007 openxml libreoffice odt php')
    ->setCategory('Sample Category');

// Remove first slide
echo date('H:i:s') . ' Remove first slide' . EOL;
$objPHPPresentation->removeSlideByIndex(0);

// Create templated slide
echo date('H:i:s') . ' Create templated slide' . EOL;
$currentSlide = createTemplatedSlide($objPHPPresentation); // local function

// Generate sample data for first chart
echo date('H:i:s') . ' Generate sample data for first chart' . EOL;
$series1Data = ['Jan' => 133, 'Feb' => 99, 'Mar' => 191, 'Apr' => 205, 'May' => 167, 'Jun' => 201, 'Jul' => 240, 'Aug' => 226, 'Sep' => 255, 'Oct' => 264, 'Nov' => 283, 'Dec' => 293];
$series2Data = ['Jan' => 266, 'Feb' => 198, 'Mar' => 271, 'Apr' => 305, 'May' => 267, 'Jun' => 301, 'Jul' => 340, 'Aug' => 326, 'Sep' => 344, 'Oct' => 364, 'Nov' => 383, 'Dec' => 379];

// Create a bar chart (that should be inserted in a shape)
echo date('H:i:s') . ' Create a bar chart (that should be inserted in a chart shape)' . EOL;
$bar = new Bar();
$bar->addSeries(new Series('2009', $series1Data));
$bar->addSeries(new Series('2010', $series2Data));

// Create a shape (chart)
echo date('H:i:s') . ' Create a shape (chart)' . EOL;
$shape = $currentSlide->createChartShape();
$shape->setName('PHPPresentation Monthly Downloads')
    ->setResizeProportional(false)
    ->setHeight(550)
    ->setWidth(700)
    ->setOffsetX(120)
    ->setOffsetY(80)
    ->setIncludeSpreadsheet(true);
$shape->getShadow()->setVisible(true)
    ->setDirection(45)
    ->setDistance(10);
$shape->getFill()->setFillType(Fill::FILL_GRADIENT_LINEAR)
    ->setStartColor(new Color('FFCCCCCC'))
    ->setEndColor(new Color('FFFFFFFF'))
    ->setRotation(270);
$shape->getBorder()->setLineStyle(Border::LINE_SINGLE);
$shape->getTitle()->setText('PHPPresentation Monthly Downloads');
$shape->getTitle()->getFont()->setItalic(true);
$shape->getPlotArea()->getAxisX()->setTitle('Month');
$shape->getPlotArea()->getAxisY()->setTitle('Downloads');
$shape->getPlotArea()->setType($bar);
$shape->getView3D()->setRightAngleAxes(true);
$shape->getView3D()->setRotationX(20);
$shape->getView3D()->setRotationY(20);
$shape->getLegend()->getBorder()->setLineStyle(Border::LINE_SINGLE);
$shape->getLegend()->getFont()->setItalic(true);

// Add line chart
// Create a line chart (that should be inserted in a shape)
echo date('H:i:s') . ' Create a line chart (that should be inserted in a chart shape)' . EOL;
$lineChart = new \PhpOffice\PhpPresentation\Shape\Chart\Type\Line();
$series = new Series('Downloads', $series1Data);
$series->setShowSeriesName(true);
$series->setShowValue(true);
$lineChart->addSeries($series);

$series = new Series('Downloads', $series2Data);
$series->setShowSeriesName(true);
$series->setShowValue(true);
$lineChart->addSeries($series);

$shape->getPlotArea()->addType($lineChart);


// Create templated slide
echo EOL . date('H:i:s') . ' Create templated slide' . EOL;
$currentSlide = createTemplatedSlide($objPHPPresentation);


// Create a shape (chart)
echo date('H:i:s') . ' Create a shape (chart)' . EOL;
$shape = $currentSlide->createChartShape();
$shape->setName('PHPPresentation Monthly Downloads')
    ->setResizeProportional(false)
    ->setHeight(550)
    ->setWidth(700)
    ->setOffsetX(120)
    ->setOffsetY(80)
    ->setIncludeSpreadsheet(true);
$shape->getShadow()->setVisible(true)
    ->setDirection(45)
    ->setDistance(10);
$shape->getFill()->setFillType(Fill::FILL_GRADIENT_LINEAR)
    ->setStartColor(new Color('FFCCCCCC'))
    ->setEndColor(new Color('FFFFFFFF'))
    ->setRotation(270);
$shape->getBorder()->setLineStyle(Border::LINE_SINGLE);
$shape->getTitle()->setText('PHPPresentation Monthly Downloads');
$shape->getTitle()->getFont()->setItalic(true);
$shape->getPlotArea()->getAxisX()->setTitle('Month');
$shape->getPlotArea()->getAxisY()->setTitle('Downloads');
$shape->getPlotArea()->getAxisX2()->setTitle('')->setIsVisible(false);
$shape->getPlotArea()->getAxisY2()
    ->setTitle('')
    ->setTickLabelPosition(\PhpOffice\PhpPresentation\Shape\Chart\Axis::TICK_LABEL_POSITION_HIGH)
/*    ->setMinBounds(0)
    ->setMaxBounds(2)*/
;

$shape->getLegend()->getBorder()->setLineStyle(Border::LINE_SINGLE);
$shape->getLegend()->getFont()->setItalic(true);

// Add line chart
// Create a line chart (that should be inserted in a shape)
echo date('H:i:s') . ' Create a line chart (that should be inserted in a chart shape)' . EOL;
$lineChart = new \PhpOffice\PhpPresentation\Shape\Chart\Type\Line();
$series = new Series('Downloads', $series1Data);
$series->setShowSeriesName(false);
$series->setShowValue(true);
$lineChart->addSeries($series);

$series = new Series('Downloads', $series2Data);
$series->setShowSeriesName(false);
$series->setShowValue(true);
$lineChart->addSeries($series);

$shape->getPlotArea()->addType($lineChart);

// Add second axis chart
// Create a line chart (that should be inserted in a shape)
echo date('H:i:s') . ' Create a line chart (that should be inserted in a chart shape)' . EOL;
$lineChart = new \PhpOffice\PhpPresentation\Shape\Chart\Type\Line();

$seriesDiff = ['Jan' => 100, 'Feb' => 50, 'Mar' => 60, 'Apr' => 70, 'May' => 80, 'Jun' => 90, 'Jul' => 20, 'Aug' => 50, 'Sep' => 60, 'Oct' => 30, 'Nov' => 40, 'Dec' => 120];
foreach($seriesDiff as $key => $value){
    $seriesDiff[$key]= $value/100;
}
$series = new Series('Compared to prev year', $seriesDiff);
$series->setShowSeriesName(false);
$series->setShowValue(true);

$series->setFormatCode('0%');
$lineChart->addSeries($series);
$lineChart->setSecondaryAxis(true);

$shape->getPlotArea()->addType($lineChart);
$shape->getPlotArea()->getAxisX2()->setFormatCode('0%');


// Save file
echo write($objPHPPresentation, basename(__FILE__, '.php'), $writers);

if (!CLI) {
    include_once 'Sample_Footer.php';
}
