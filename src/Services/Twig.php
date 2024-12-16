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

namespace Gashmob\PicLib\Services;

use Archict\Brick\Service;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

#[Service]
final class Twig
{
    private readonly Environment $twig;
    /**
     * @var array<string, mixed>
     */
    private array $context;

    public function __construct()
    {
        $this->twig    = new Environment(new FilesystemLoader(__DIR__ . '/../../templates/'));
        $this->context = [
            'js_assets'  => [],
            'css_assets' => [],
            'apps'       => [],
        ];

        $this->twig->addExtension(new TwigExtension());
    }

    public function addCssAsset(string $file_path): void
    {
        assert(is_array($this->context['css_assets']));
        $this->context['css_assets'][] = $file_path;
    }

    public function addJsAsset(string $file_path): void
    {
        assert(is_array($this->context['js_assets']));
        $this->context['js_assets'][] = $file_path;
    }

    public function addApp(string $app_name): void
    {
        assert(is_array($this->context['apps']));
        $this->context['apps'][] = $app_name;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function render(string $template_name, array $context = []): string
    {
        return $this->twig->render(
            $template_name, [
                ...$this->context,
                ...$context,
            ],
        );
    }
}
