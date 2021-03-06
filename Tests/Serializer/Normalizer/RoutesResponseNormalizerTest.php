<?php

/*
 * This file is part of the FOSJsRoutingBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\JsRoutingBundle\Tests\Serializer\Normalizer;

use FOS\JsRoutingBundle\Serializer\Normalizer\RouteCollectionNormalizer;
use FOS\JsRoutingBundle\Serializer\Normalizer\RoutesResponseNormalizer;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RoutesResponseNormalizerTest
 */
class RoutesResponseNormalizerTest extends \PHPUnit_Framework_TestCase
{
    public function testSupportsNormalization()
    {
        $normalizer = new RoutesResponseNormalizer(new RouteCollectionNormalizer());
        $response   = $this->getMockBuilder('FOS\JsRoutingBundle\Response\RoutesResponse')
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertFalse($normalizer->supportsNormalization(new \stdClass()));
        $this->assertFalse($normalizer->supportsNormalization($response));

        $response->expects($this->once())
            ->method('getRoutes')
            ->will($this->returnValue(new RouteCollection()));

        $this->assertTrue($normalizer->supportsNormalization($response));
    }

    public function testNormalize()
    {
        $normalizer = new RoutesResponseNormalizer(new RouteCollectionNormalizer());
        $response   = $this->getMockBuilder('FOS\JsRoutingBundle\Response\RoutesResponse')
            ->disableOriginalConstructor()
            ->getMock();

        $response->expects($this->once())
            ->method('getRoutes')
            ->will($this->returnValue(new RouteCollection()));

        $response->expects($this->once())
            ->method('getBaseUrl')
            ->will($this->returnValue('baseUrl'));

        $response->expects($this->once())
            ->method('getPrefix')
            ->will($this->returnValue('prefix'));

        $response->expects($this->once())
            ->method('getHost')
            ->will($this->returnValue('host'));

        $response->expects($this->once())
            ->method('getScheme')
            ->will($this->returnValue('scheme'));

        $expected = array(
            'base_url' => 'baseUrl',
            'routes'   => array(),
            'prefix'   => 'prefix',
            'host'     => 'host',
            'scheme'   => 'scheme',
        );

        $this->assertSame($expected, $normalizer->normalize($response));
    }
}
