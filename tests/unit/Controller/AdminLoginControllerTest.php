<?php
/**
 * MIT License
 *
 * Copyright (c) 2024-Present Kevin Traini
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace Gashmob\PicLib\Controller;

use Gashmob\PicLib\ApplicationConfiguration;
use Gashmob\PicLib\Services\Twig;
use Gashmob\PicLib\Test\Builder\RequestBuilder;
use Gashmob\PicLib\Test\SessionSandbox;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

final class AdminLoginControllerTest extends TestCase
{
    use SessionSandbox;

    private AdminLoginController $controller;

    protected function setUp(): void
    {
        $this->controller = new AdminLoginController(new Twig(), $this->session, new ApplicationConfiguration('pass'));
    }

    public function testItRedirectsToAdminIfLogin(): void
    {
        $this->session->set('login', true);
        $response = $this->controller->handle(RequestBuilder::aRequest('GET', '/admin/login')->build());

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame(301, $response->getStatusCode());
        self::assertSame('/admin', $response->getHeaderLine('Location'));
    }

    public function testItDisplaysPageIfNotLogin(): void
    {
        $this->session->set('login', null);
        $response = $this->controller->handle(RequestBuilder::aRequest('GET', '/admin/login')->build());

        self::assertIsString($response);
        self::assertNotEmpty($response);
    }

    public function testItRedirectsToRickAfter3Attempts(): void
    {
        $this->session->set('login', null);
        $this->session->set('login_try', 3);
        $response = $this->controller->handle(RequestBuilder::aRequest('POST', '/admin/login')->build());

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame(301, $response->getStatusCode());
        self::assertSame('https://youtu.be/dQw4w9WgXcQ?si=3WLapoBabhahy01v', $response->getHeaderLine('Location'));
    }

    public function testItRedirectsToAdminIfPasswordCorrect(): void
    {
        $this->session->set('login', null);
        $response = $this->controller->handle(RequestBuilder::aRequest('POST', '/admin/login')->withPostBody(['password' => 'pass'])->build());

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame(301, $response->getStatusCode());
        self::assertSame('/admin', $response->getHeaderLine('Location'));
        self::assertTrue($this->session->get('login'));
    }

    public function testItDisplaysPageIfWrongPassword(): void
    {
        $this->session->set('login', null);
        $response = $this->controller->handle(RequestBuilder::aRequest('POST', '/admin/login')->withPostBody(['password' => 'foo'])->build());

        self::assertIsString($response);
        self::assertNotEmpty($response);
        self::assertSame(1, $this->session->get('login_try'));
    }
}
