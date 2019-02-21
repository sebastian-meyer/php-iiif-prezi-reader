<?php
/*
 * Copyright (C) 2019 Leipzig University Library <info@ub.uni-leipzig.de>
 * 
 * This file is part of the php-iiif-prezi-reader.
 * 
 * php-iiif-prezi-reader is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

use Ubl\Iiif\AbstractIiifTest;
use Ubl\Iiif\Services\ImageInformation2;
use Ubl\Iiif\Services\Profile;
use Ubl\Iiif\Tools\IiifHelper;

/**
 * ImageInformation2 test case.
 */
class ImageInformation2Test extends AbstractIiifTest {

    /**
     * Tests ImageInformation2->getFormats()
     */
    public function testGetFormats() {
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-01.json"));
        /* @var $service ImageInformation2 */
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getFormats());
        self::assertEquals(1, count($service->getFormats()));
        self::assertContains("jpg", $service->getFormats());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getFormats());
        self::assertEquals(2, count($service->getFormats()));
        self::assertContains("jpg", $service->getFormats());
        self::assertContains("tif", $service->getFormats());

        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getFormats());
        self::assertEquals(1, count($service->getFormats()));
        self::assertContains("jpg", $service->getFormats());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getFormats());
        self::assertEquals(2, count($service->getFormats()));
        self::assertContains("jpg", $service->getFormats());
        self::assertContains("pdf", $service->getFormats());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getFormats());
        self::assertEquals(2, count($service->getFormats()));
        self::assertContains("jpg", $service->getFormats());
        self::assertContains("png", $service->getFormats());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getFormats());
        self::assertEquals(4, count($service->getFormats()));
        self::assertContains("jpg", $service->getFormats());
        self::assertContains("png", $service->getFormats());
        self::assertContains("gif", $service->getFormats());
        self::assertContains("pdf", $service->getFormats());
    }
    
    /**
     * Tests ImageInformation2->getQualities()
     */
    public function testGetQualities() {
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-01.json"));
        /* @var $service ImageInformation2 */
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getQualities());
        self::assertEquals(1, count($service->getQualities()));
        self::assertContains(Profile::DEFAULT_, $service->getQualities());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getQualities());
        self::assertEquals(3, count($service->getQualities()));
        self::assertContains(Profile::DEFAULT_, $service->getQualities());
        self::assertContains(Profile::COLOR, $service->getQualities());
        self::assertContains(Profile::GRAY, $service->getQualities());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getQualities());
        self::assertEquals(1, count($service->getQualities()));
        self::assertContains(Profile::DEFAULT_, $service->getQualities());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getQualities());
        self::assertEquals(3, count($service->getQualities()));
        self::assertContains(Profile::DEFAULT_, $service->getQualities());
        self::assertContains(Profile::COLOR, $service->getQualities());
        self::assertContains(Profile::BITONAL, $service->getQualities());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getQualities());
        self::assertEquals(2, count($service->getQualities()));
        self::assertContains(Profile::DEFAULT_, $service->getQualities());
        self::assertContains(Profile::BITONAL, $service->getQualities());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getQualities());
        self::assertEquals(3, count($service->getQualities()));
        self::assertContains(Profile::DEFAULT_, $service->getQualities());
        self::assertContains(Profile::COLOR, $service->getQualities());
        self::assertContains(Profile::BITONAL, $service->getQualities());
    }
    
    /**
     * Tests ImageInformation2->getSupports()
     */
    public function testGetSupports() {
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-01.json"));
        /* @var $service ImageInformation2 */
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getSupports());
        self::assertEquals(1, count($service->getSupports()));
        self::assertContains(Profile::SIZE_BY_WH_LISTED, $service->getSupports());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getSupports());
        self::assertEquals(2, count($service->getSupports()));
        self::assertContains(Profile::SIZE_BY_WH_LISTED, $service->getSupports());
        self::assertContains(Profile::ROTATION_BY_90S, $service->getSupports());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getSupports());
        self::assertEquals(8, count($service->getSupports()));
        self::assertContains(Profile::REGION_BY_PX, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_WH_LISTED, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_W, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_H, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_PCT, $service->getSupports());
        self::assertContains(Profile::BASE_URI_REDIRECT, $service->getSupports());
        self::assertContains(Profile::CORS, $service->getSupports());
        self::assertContains(Profile::JSONLD_MEDIA_TYPE, $service->getSupports());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getSupports());
        self::assertEquals(11, count($service->getSupports()));
        self::assertContains(Profile::REGION_BY_PX, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_WH_LISTED, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_W, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_H, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_PCT, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_WH, $service->getSupports());
        self::assertContains(Profile::ROTATION_BY_90S, $service->getSupports());
        self::assertContains(Profile::MIRRORING, $service->getSupports());
        self::assertContains(Profile::BASE_URI_REDIRECT, $service->getSupports());
        self::assertContains(Profile::CORS, $service->getSupports());
        self::assertContains(Profile::JSONLD_MEDIA_TYPE, $service->getSupports());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getSupports());
        self::assertEquals(14, count($service->getSupports()));
        self::assertContains(Profile::REGION_BY_PX, $service->getSupports());
        self::assertContains(Profile::REGION_BY_PCT, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_WH_LISTED, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_CONFINED_WH, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_DISTORTED_WH, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_FORCED_WH, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_W, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_H, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_PCT, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_WH, $service->getSupports());
        self::assertContains(Profile::ROTATION_BY_90S, $service->getSupports());
        self::assertContains(Profile::BASE_URI_REDIRECT, $service->getSupports());
        self::assertContains(Profile::CORS, $service->getSupports());
        self::assertContains(Profile::JSONLD_MEDIA_TYPE, $service->getSupports());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertNotEmpty($service->getSupports());
        self::assertEquals(17, count($service->getSupports()));
        self::assertContains(Profile::REGION_BY_PX, $service->getSupports());
        self::assertContains(Profile::REGION_BY_PCT, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_WH_LISTED, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_CONFINED_WH, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_DISTORTED_WH, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_FORCED_WH, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_W, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_H, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_PCT, $service->getSupports());
        self::assertContains(Profile::SIZE_BY_WH, $service->getSupports());
        self::assertContains(Profile::SIZE_ABOVE_FULL, $service->getSupports());
        self::assertContains(Profile::ROTATION_BY_90S, $service->getSupports());
        self::assertContains(Profile::ROTATION_ARBITRARY, $service->getSupports());
        self::assertContains(Profile::MIRRORING, $service->getSupports());
        self::assertContains(Profile::BASE_URI_REDIRECT, $service->getSupports());
        self::assertContains(Profile::CORS, $service->getSupports());
        self::assertContains(Profile::JSONLD_MEDIA_TYPE, $service->getSupports());
    }
    
    /**
     * Tests ImageInformation2->isFeatureSupported()
     */
    public function testIsFeatureSupported() {

        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-01.json"));
        /* @var $service ImageInformation2 */
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertFalse($service->isFeatureSupported(Profile::REGION_BY_PX));
        self::assertFalse($service->isFeatureSupported(Profile::REGION_BY_PCT));
        self::assertFalse($service->isFeatureSupported(Profile::REGION_SQUARE));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_WH_LISTED));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_W));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_H));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_PCT));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_CONFINED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_DISTORTED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_FORCED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_ABOVE_FULL));
        self::assertFalse($service->isFeatureSupported(Profile::ROTATION_BY_90S));
        self::assertFalse($service->isFeatureSupported(Profile::ROTATION_ARBITRARY));
        self::assertFalse($service->isFeatureSupported(Profile::MIRRORING));
        self::assertFalse($service->isFeatureSupported(Profile::BASE_URI_REDIRECT));
        self::assertFalse($service->isFeatureSupported(Profile::CORS));
        self::assertFalse($service->isFeatureSupported(Profile::JSONLD_MEDIA_TYPE));
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertFalse($service->isFeatureSupported(Profile::REGION_BY_PX));
        self::assertFalse($service->isFeatureSupported(Profile::REGION_BY_PCT));
        self::assertFalse($service->isFeatureSupported(Profile::REGION_SQUARE));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_WH_LISTED));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_W));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_H));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_PCT));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_CONFINED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_DISTORTED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_FORCED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_ABOVE_FULL));
        self::assertTrue($service->isFeatureSupported(Profile::ROTATION_BY_90S));
        self::assertFalse($service->isFeatureSupported(Profile::ROTATION_ARBITRARY));
        self::assertFalse($service->isFeatureSupported(Profile::MIRRORING));
        self::assertFalse($service->isFeatureSupported(Profile::BASE_URI_REDIRECT));
        self::assertFalse($service->isFeatureSupported(Profile::CORS));
        self::assertFalse($service->isFeatureSupported(Profile::JSONLD_MEDIA_TYPE));
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertTrue($service->isFeatureSupported(Profile::REGION_BY_PX));
        self::assertFalse($service->isFeatureSupported(Profile::REGION_BY_PCT));
        self::assertFalse($service->isFeatureSupported(Profile::REGION_SQUARE));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_WH_LISTED));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_W));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_H));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_PCT));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_CONFINED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_DISTORTED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_FORCED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_ABOVE_FULL));
        self::assertFalse($service->isFeatureSupported(Profile::ROTATION_BY_90S));
        self::assertFalse($service->isFeatureSupported(Profile::ROTATION_ARBITRARY));
        self::assertFalse($service->isFeatureSupported(Profile::MIRRORING));
        self::assertTrue($service->isFeatureSupported(Profile::BASE_URI_REDIRECT));
        self::assertTrue($service->isFeatureSupported(Profile::CORS));
        self::assertTrue($service->isFeatureSupported(Profile::JSONLD_MEDIA_TYPE));
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::asserttrue($service->isFeatureSupported(Profile::REGION_BY_PX));
        self::assertFalse($service->isFeatureSupported(Profile::REGION_BY_PCT));
        self::assertFalse($service->isFeatureSupported(Profile::REGION_SQUARE));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_WH_LISTED));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_W));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_H));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_PCT));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_CONFINED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_DISTORTED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_BY_FORCED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_ABOVE_FULL));
        self::assertTrue($service->isFeatureSupported(Profile::ROTATION_BY_90S));
        self::assertFalse($service->isFeatureSupported(Profile::ROTATION_ARBITRARY));
        self::assertTrue($service->isFeatureSupported(Profile::MIRRORING));
        self::assertTrue($service->isFeatureSupported(Profile::BASE_URI_REDIRECT));
        self::assertTrue($service->isFeatureSupported(Profile::CORS));
        self::assertTrue($service->isFeatureSupported(Profile::JSONLD_MEDIA_TYPE));
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertTrue($service->isFeatureSupported(Profile::REGION_BY_PX));
        self::assertTrue($service->isFeatureSupported(Profile::REGION_BY_PCT));
        self::assertFalse($service->isFeatureSupported(Profile::REGION_SQUARE));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_WH_LISTED));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_W));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_H));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_PCT));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_WH));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_CONFINED_WH));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_DISTORTED_WH));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_FORCED_WH));
        self::assertFalse($service->isFeatureSupported(Profile::SIZE_ABOVE_FULL));
        self::assertTrue($service->isFeatureSupported(Profile::ROTATION_BY_90S));
        self::assertFalse($service->isFeatureSupported(Profile::ROTATION_ARBITRARY));
        self::assertFalse($service->isFeatureSupported(Profile::MIRRORING));
        self::assertTrue($service->isFeatureSupported(Profile::BASE_URI_REDIRECT));
        self::assertTrue($service->isFeatureSupported(Profile::CORS));
        self::assertTrue($service->isFeatureSupported(Profile::JSONLD_MEDIA_TYPE));
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertTrue($service->isFeatureSupported(Profile::REGION_BY_PX));
        self::assertTrue($service->isFeatureSupported(Profile::REGION_BY_PCT));
        self::assertFalse($service->isFeatureSupported(Profile::REGION_SQUARE));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_WH_LISTED));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_W));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_H));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_PCT));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_WH));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_CONFINED_WH));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_DISTORTED_WH));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_BY_FORCED_WH));
        self::assertTrue($service->isFeatureSupported(Profile::SIZE_ABOVE_FULL));
        self::assertTrue($service->isFeatureSupported(Profile::ROTATION_BY_90S));
        self::assertTrue($service->isFeatureSupported(Profile::ROTATION_ARBITRARY));
        self::assertTrue($service->isFeatureSupported(Profile::MIRRORING));
        self::assertTrue($service->isFeatureSupported(Profile::BASE_URI_REDIRECT));
        self::assertTrue($service->isFeatureSupported(Profile::CORS));
        self::assertTrue($service->isFeatureSupported(Profile::JSONLD_MEDIA_TYPE));
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-no-profile.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        foreach (Profile::IMAGE2_LEVEL2["supported"] as $feature) {
            self::assertFalse($service->isFeatureSupported($feature), "Service should not support ".$feature);
        }
        
    }
    
    /**
     * Tests ImageInformation2->getImageUrl()
     */
    public function testGetImageUrl() {
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-01.json"));
        self::assertEquals("http://example.com/image/11/full/full/0/default.jpg", $service->getImageUrl());
        self::assertEquals("http://example.com/image/11/100,100,200,200/200,/90/bitonal.png", $service->getImageUrl("100,100,200,200", "200,","90","bitonal","png"));
    }
    
    public function testGetId() {
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://example.com/image/07", $service->getId());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://example.com/image/08", $service->getId());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://example.com/image/09", $service->getId());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://example.com/image/10", $service->getId());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://example.com/image/11", $service->getId());
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://example.com/image/12", $service->getId());
    }
    
    public function testGetProfile() {
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://iiif.io/api/image/2/level0.json", $service->getProfile()[0]);
        self::assertEquals(1, count($service->getProfile()));
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level0-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://iiif.io/api/image/2/level0.json", $service->getProfile()[0]);
        self::assertEquals(2, count($service->getProfile()));
        self::assertEquals(["rotationBy90s"], $service->getProfile()[1]["supports"]);
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://iiif.io/api/image/2/level1.json", $service->getProfile()[0]);
        self::assertEquals(1, count($service->getProfile()));
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level1-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://iiif.io/api/image/2/level1.json", $service->getProfile()[0]);
        self::assertEquals(2, count($service->getProfile()));
        self::assertEquals(["sizeByWh","rotationBy90s","mirroring"], $service->getProfile()[1]["supports"]);
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-01.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://iiif.io/api/image/2/level2.json", $service->getProfile()[0]);
        self::assertEquals(1, count($service->getProfile()));
        
        $service = IiifHelper::loadIiifResource(static::getFile("services/image2-level2-02.json"));
        self::assertNotNull($service);
        self::assertInstanceOf(ImageInformation2::class, $service);
        self::assertEquals("http://iiif.io/api/image/2/level2.json", $service->getProfile()[0]);
        self::assertEquals(2, count($service->getProfile()));
        self::assertEquals(["sizeAboveFull","rotationArbitrary","mirroring"], $service->getProfile()[1]["supports"]);
        
    }
    
}

