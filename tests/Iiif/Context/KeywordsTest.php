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

use Ubl\Iiif\Context\Keywords;
use PHPUnit\Framework\TestCase;

/**
 * Keywords test case.
 */
class KeywordsTest extends TestCase
{

    /**
     * Tests Keywords::isKeyword()
     */
    public function testIsKeyword()
    {
        self::assertTrue(Keywords::isKeyword("@base"));
        self::assertTrue(Keywords::isKeyword("@id"));
        self::assertFalse(Keywords::isKeyword("@notakeyword"));
        self::assertFalse(Keywords::isKeyword(null));
        self::assertFalse(Keywords::isKeyword("foo"));
    }
}

