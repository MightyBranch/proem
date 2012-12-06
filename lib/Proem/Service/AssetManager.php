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


/**
 * @namespace Proem\Service
 */
namespace Proem\Service;

use Proem\Service\AssetManagerInterface;
use Proem\Service\AssetInterface;
use Proem\Util\DataCollectionTrait;

/**
 * A collection of assets.
 *
 * Within the manager itself assets are stored in a hash of key values where each
 * value is an asset container.
 *
 * These containers contain the parameters required to instantiate an asset as
 * well as a closure capable of returning a configured and instantiated asset.
 *
 * While this class looks very similar to the DataAccessInterface it does *NOT* implement
 * this interface and in fact, if you look closer you will note that the methods involved
 * are slight variants of the interface.
 *
 * @see Proem\Service\Asset
 */
class AssetManager implements AssetManagerInterface, \Iterator, \Serializable
{
    /**
     * Use the generic DataCollectionTrait trait.
     *
     * This provides implementations for the Iterator and Serializable
     */
    use DataCollectionTrait;

    /**
     * Store an array containing information about what
     * Assets this manager provides.
     *
     * @var array
     */
    protected $provides = [];

    /**
     * Store an Asset container by named index.
     *
     * @param string $index The index the asset will be referenced by.
     * @param Proem\Service\AssetInterface $asset
     * @return Proem\Service\AssetManagerInterface
     */
    public function set($index, AssetInterface $asset)
    {
        $this->data[$index] = $asset;
        $this->provides[]   = $asset->is();
        return $this;
    }

    /**
     * Retrieve an asset.
     *
     * Returns an instantiated obejct by default or optionaly the
     * asset container itself.
     *
     * @param string $index The index the asset is referenced by
     * @param bool Wether or not to return the asset's object or container
     * @return object The object provided by the asset container
     */
    public function get($index, $asAsset = false)
    {
        if (!$asAsset) {
            return isset($this->data[$index]) ? $this->data[$index]->fetch($this) : null;
        }

        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    /**
     * Check to see if this manager has a specific asset by index.
     *
     * @param string $index The index the asset is referenced by
     * @return bool
     */
    public function has($index)
    {
        return isset($this->assets[$index]);
    }
}
