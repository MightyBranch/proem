<?php

/**
 * The MIT License
 *
 * Copyright (c) 2010 - 2012 Tony R Quilkey <trq@proemframework.org>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Proem\Test\Service;

use Proem\Service\AssetComposer;

class AssetComposerTest extends \PHPUnit_Framework_TestCase
{
    public function testCanInstantiateAssetManager()
    {
        $this->assertInstanceOf('Proem\Service\AssetComposer', new AssetComposer([]));
    }

    public function testCanBuildSimpleAsset()
    {
        require_once __DIR__ . '/AssetComposerFixtures/Foo.php';

        $foo = new AssetComposer('Foo');

        $this->assertInstanceOf('Proem\Service\AssetInterface', $foo->compose());
        $this->assertInstanceOf('Foo', $foo->compose()->fetch());
    }

    public function testCanBuildAssetFromConstructArray()
    {
        require_once __DIR__ . '/AssetComposerFixtures/Foo.php';

        $foo = new AssetComposer([
            'class' => 'Foo',
            'construct' => ['hello']
        ]);

        $this->assertInstanceOf('Proem\Service\AssetInterface', $foo->compose());
        $this->assertInstanceOf('Foo', $foo->compose()->fetch());
        $this->assertEquals('hello', $foo->compose()->fetch()->getVar());
    }

    public function testCanBuildAssetFromComplexArray()
    {
        require_once __DIR__ . '/AssetComposerFixtures/Foo.php';

        $foo = new AssetComposer([
            'class' => 'Foo',
            'methods' => ['setVar' => ['hello']]
        ]);

        $this->assertInstanceOf('Proem\Service\AssetInterface', $foo->compose());
        $this->assertInstanceOf('Foo', $foo->compose()->fetch());
        $this->assertEquals('hello', $foo->compose()->fetch()->getVar());
    }

    public function testCanBuildAssetFromConstructCall()
    {
        require_once __DIR__ . '/AssetComposerFixtures/Foo.php';

        $foo = new AssetComposer('Foo');
        $foo->construct(['hello']);

        $this->assertInstanceOf('Proem\Service\AssetInterface', $foo->compose());
        $this->assertInstanceOf('Foo', $foo->compose()->fetch());
        $this->assertEquals('hello', $foo->compose()->fetch()->getVar());
    }

    public function testCanBuildAssetFromMethodCall()
    {
        require_once __DIR__ . '/AssetComposerFixtures/Foo.php';

        $foo = new AssetComposer('Foo');
        $foo->methods(['setVar' => ['hello']]);

        $this->assertInstanceOf('Proem\Service\AssetInterface', $foo->compose());
        $this->assertInstanceOf('Foo', $foo->compose()->fetch());
        $this->assertEquals('hello', $foo->compose()->fetch()->getVar());
    }
}
