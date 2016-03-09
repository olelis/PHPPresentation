<?php
/**
 * This file is part of PHPPresentation - A pure PHP library for reading and writing
 * presentations documents.
 *
 * PHPPresentation is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPPresentation/contributors.
 *
 * @copyright   2009-2015 PHPPresentation contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 * @link        https://github.com/PHPOffice/PHPPresentation
 */

namespace PhpOffice\PhpPresentation\Tests\Writer;

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Writer\ODPresentation;
use PhpOffice\PhpPresentation\Tests\TestHelperDOCX;

/**
 * Test class for PhpOffice\PhpPresentation\Writer\ODPresentation
 *
 * @coversDefaultClass PhpOffice\PhpPresentation\Writer\ODPresentation
 */
class ODPresentationTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        parent::tearDown();

        TestHelperDOCX::clear();
    }

    /**
     * Test create new instance
     */
    public function testConstruct()
    {
        $objectPrefix = 'PhpOffice\\PhpPresentation\\Writer\\ODPresentation\\';
        $parts = array(
            'content'  => 'Content',
            'manifest' => 'Manifest',
            'meta'     => 'Meta',
            'mimetype' => 'Mimetype',
            'styles'   => 'Styles',
            'drawing'  => 'Drawing',
        );

        $oPhpPresentation = new PhpPresentation();
        $oPhpPresentation->getActiveSlide()->createDrawingShape();
        $object = new ODPresentation($oPhpPresentation);

        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\PhpPresentation', $object->getPhpPresentation());
        $this->assertEquals('./', $object->getDiskCachingDirectory());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\HashTable', $object->getDrawingHashTable());
    }

    /**
     * Test save
     */
    public function testSave()
    {
        $filename = tempnam(sys_get_temp_dir(), 'PhpPresentation');
        $imageFile = PHPPRESENTATION_TESTS_BASE_DIR . '/resources/images/PhpPresentationLogo.png';

        $oPhpPresentation = new PhpPresentation();
        $slide = $oPhpPresentation->getActiveSlide();
        $slide->createRichTextShape();
        $slide->createLineShape(10, 10, 10, 10);
        $slide->createChartShape()->getPlotArea()->setType(new \PhpOffice\PhpPresentation\Shape\Chart\Type\Bar3D());
        $slide->createDrawingShape()->setName('Drawing')->setPath($imageFile);
        $slide->createTableShape()->createRow();

        $object = new ODPresentation($oPhpPresentation);
        $object->save($filename);

        $this->assertTrue(file_exists($filename));

        unlink($filename);
    }

    /**
     * Test get PhpPresentation exception
     *
     * @expectedException Exception
     * @expectedExceptionMessage Filename is empty
     */
    public function testSaveEmpty()
    {
        $object = new ODPresentation();
        $object->save('');
    }

    /**
     * Test get PhpPresentation exception
     *
     * @expectedException Exception
     * @expectedExceptionMessage No PhpPresentation assigned.
     */
    public function testGetPhpPresentationException()
    {
        $object = new ODPresentation();
        $object->getPhpPresentation();
    }

    /**
     * Test set/get disk caching
     */
    public function testSetGetUseDiskCaching()
    {
        $object = new ODPresentation(new PhpPresentation());
        $this->assertFalse($object->hasDiskCaching());

        $object->setUseDiskCaching(true, sys_get_temp_dir());
        $this->assertTrue($object->hasDiskCaching());
        $this->assertEquals(sys_get_temp_dir(), $object->getDiskCachingDirectory());
    }

    /**
     * Test set/get disk caching exception
     *
     * @expectedException Exception
     */
    public function testSetUseDiskCachingException()
    {
        $object = new ODPresentation(new PhpPresentation());
        $object->setUseDiskCaching(true, 'foo');
    }

    public function testFeatureThumbnail()
    {
        $imagePath = PHPPRESENTATION_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'PhpPresentationLogo.png';

        $xPathManifest = '/manifest:manifest/manifest:file-entry[@manifest:media-type=\'image/png\'][@manifest:full-path=\'Thumbnails/thumbnail.png\']';

        $oPhpPresentation = new PhpPresentation();

        $oXMLDoc = TestHelperDOCX::getDocument($oPhpPresentation, 'ODPresentation');
        $this->assertFalse($oXMLDoc->fileExists('Thumbnails/thumbnail.png'));
        $this->assertTrue($oXMLDoc->fileExists('META-INF/manifest.xml'));
        $this->assertFalse($oXMLDoc->elementExists($xPathManifest, 'META-INF/manifest.xml'));

        $oPhpPresentation->getPresentationProperties()->setThumbnailPath($imagePath);
        $oXMLDoc = TestHelperDOCX::getDocument($oPhpPresentation, 'ODPresentation');
        $this->assertTrue($oXMLDoc->fileExists('Thumbnails/thumbnail.png'));
        $this->assertTrue($oXMLDoc->fileExists('META-INF/manifest.xml'));
        $this->assertTrue($oXMLDoc->elementExists($xPathManifest, 'META-INF/manifest.xml'));
    }
}
