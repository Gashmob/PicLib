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

use Gashmob\PicLib\Services\Twig;
use Gashmob\PicLib\Test\Builder\RequestBuilder;
use Gashmob\PicLib\Test\SessionSandbox;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

final class AdminControllerTest extends TestCase
{
    use SessionSandbox;

    private AdminController $controller;

    protected function setUp(): void
    {
        $this->controller = new AdminController($this->session, new Twig());
    }

    public function testItRedirectsToLoginIfNotLogin(): void
    {
        $this->session->set('login', null);
        $response = $this->controller->handle(RequestBuilder::aRequest('GET', '/admin')->build());

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame(301, $response->getStatusCode());
        self::assertSame('/admin/login', $response->getHeaderLine('Location'));
    }

    public function testItDisplaysPageIfLogin(): void
    {
        $this->session->set('login', true);
        $response = $this->controller->handle(RequestBuilder::aRequest('GET', '/admin')->build());

        self::assertIsString($response);
        self::assertNotEmpty($response);
    }
}
