<?php

namespace Samrm;

use Kirby\Cms\App;
use Kirby\Filesystem\F;
use Kirby\Filesystem\Dir;
use Kirby\Filesystem\Asset;
use Kirby\Toolkit\A;
use Kirby\Toolkit\Str;
use Kirby\Data\Data;
use Kirby\Cms\NestCollection;
use Kirby\Http\Response;

use PHPHtmlParser\Dom;

class Documentation
{

    private static function root($path = '')
    {
        $root = kirby()->root('site').'/'.option('samrm.documentation.root');
        if ($path) {
            $root .= "/$path";
        }
        return $root;
    }

    public static function getPages()
    {
        $pages = new NestCollection();
        if (Dir::exists(static::root())) {
            $markdownFiles = A::filter(Dir::read(static::root(), null, true), fn($path) => F::extension($path) == 'md');
            foreach ($markdownFiles as $path) {
                $page = self::loadPage($path);
                $pages->set($page['id'], $page);
            }
        }
        return $pages;
    }

    public static function loadPage(string $path)
    {
        if (F::exists($path)) {
            $name = preg_replace('/^(\d+_)?(.+)$/', '$2', F::name($path));
            $id = Str::slug($name);
            $url = option('samrm.documentation.root').'/'.$id;
            $data = Data::read($path);
            $title = $data['title'] ?? $name;
            $content = markdown($data['content'] ?? F::read($path));
            $content = self::handleFiles($content);

            return compact('path', 'id', 'url', 'title', 'content');
        }
    }

    public static function getPagePath(string $id)
    {
        foreach (self::getPages() as $page) {
            if ($page['id'] == $id) {
                return $page['path'];
            }
        }
    }

    public static function getPage(string $id)
    {
        if ($path = self::getPagePath($id)) {
            return self::loadPage($path);
        }
    }

    private static function handleFiles(string $html)
    {
        $doc = new \DOMDocument;
        $doc->loadHTML($html);
        foreach ([...$doc->getElementsByTagName('img'), ...$doc->getElementsByTagName('a')] as $node) {
            if (($src = $node->getAttribute('src') ?? $node->getAttribute('href')) && F::exists(static::root($src))) {
                $path = self::resolveFile(static::root($src));
                $node->hasAttribute('src') ? $node->setAttribute('src', $path) : $node->setAttribute('href', $path);
            }
        }
        return $doc->saveHTML();
    }

    private static function resolveFile($source)
    {
        if ($plugin = App::instance()->plugin('samrm/documentation')) {
            if (F::exists($source) === true && $filename = F::filename($source)) {
                $target = $plugin->mediaRoot() . '/' . $filename;
                F::link($source, $target, 'symlink');
                return $plugin->mediaUrl() . '/' . $filename;
            }
        }
    }


}
