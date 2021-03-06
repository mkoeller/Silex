<?php

/*
 * This file is part of the Silex framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Silex\Tests\Extension;

use Silex\Application;
use Silex\Extension\UrlGeneratorExtension;

use Symfony\Component\HttpFoundation\Request;

/**
 * UrlGeneratorExtension test cases.
 *
 * @author Igor Wiedler <igor@wiedler.ch>
 */
class UrlGeneratorExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $app = new Application();

        $app->register(new UrlGeneratorExtension());

        $app->get('/hello/{name}', function ($name) {})
            ->bind('hello');

        $app->get('/', function () use ($app) {
            return $app['url_generator']->generate('hello', array('name' => 'john'));
        });

        $request = Request::create('/');
        $response = $app->handle($request);
        $this->assertEquals('/hello/john', $response->getContent());
    }
}
