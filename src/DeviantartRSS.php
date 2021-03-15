<?php

namespace AngryMoustache\DeviantartRss;

use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class DeviantartRss
{
    public static array $config = [];

    public static array $options = [];

    public static function fetch(string $query, array $options = [])
    {
        self::$config = config('deviantart-rss', []);

        $query = str_replace(' ', '+', $query);
        $options['q'] = $query;
        $options = array_merge(self::$config['default-options'], $options);
        self::$options = $options;

        $response = Http::get(self::buildQuery())->body();
        $xml = new SimpleXMLElement($response);

        return collect(((array) $xml->channel)['item'])
            ->map(fn ($item) => new MediaItem($item))
            ->values();
    }

    public static function buildQuery($options = null)
    {
        $query = collect($options ?? self::$options)
            ->map(fn ($value, $key) => "${key}=${value}")
            ->implode('&');

        return self::$config['base-url'] . '?' . $query;
    }
}
