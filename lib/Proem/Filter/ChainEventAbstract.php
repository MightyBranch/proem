<?php

/**
 * The MIT License
 *
 * Copyright (c) 2010 - 2014 Tony R Quilkey <trq@proemframework.org>
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
 * @namespace Proem\Filter\ChainEvent
 */
namespace Proem\Filter;

use Proem\Filter\ChainManagerInterface;
use Proem\Filter\ChainEventInterface;
use Proem\Service\AssetManagerInterface;

/**
 * An abstract filter chain event. All filter chain
 * events should extend this abstract class.
 */
abstract class ChainEventAbstract implements ChainEventInterface
{
    /**
     * Define the method to be called on the way into the filter.
     *
     * @param Proem\Service\AssetManagerInterface $assets
     */
    abstract public function in(AssetManagerInterface $assets);

    /**
     * Define the method to be called on the way out of the filter.
     *
     * @param Proem\Service\AssetManagerInterface $assets
     */
    abstract public function out(AssetManagerInterface $assets);

    /**
     * Bootstrap this event.
     *
     * Executes in() then init() on the next event= in the filter chain
     * before returning to execute out().
     *
     * @param Proem\Filter\ChainManagerInterface $chainManager
     * @param array Optional extra parameters.
     */
    public function init(ChainManagerInterface $chainManager, array $params = [])
    {
        $this->in($chainManager->getAssetManager());

        if ($chainManager->hasEvents()) {
            $event = $chainManager->getNextEvent();
            if (is_object($event)) {
                $event->init($chainManager);
            }
        }

        $this->out($chainManager->getAssetManager());

        return $this;
    }
}
