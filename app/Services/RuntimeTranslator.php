<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RuntimeTranslator
{
    public function translate(mixed $text, ?string $source = null, ?string $target = null): mixed
    {
        if (!is_string($text)) {
            return $text;
        }

        $text = trim($text);
        if ($text === '') {
            return $text;
        }

        $locale = app()->getLocale();

        $source = $source ?: config('translate.source', 'id');
        $target = $target ?: $locale;

        if ($target === $source) {
            return $text;
        }

        $supported = config('translate.supported_locales', ['id', 'en']);
        if (!in_array($target, $supported, true)) {
            return $text;
        }

        $version = (string) config('translate.cache_version', 'v1');
        $cacheKey = 'runtime_translate:' . $version . ':' . $source . ':' . $target . ':' . sha1($text);

        $cached = Cache::get($cacheKey);
        if (is_string($cached) && $cached !== '') {
            return $cached;
        }

        $url = config('translate.url');
        $key = config('translate.key');
        $timeout = (int) config('translate.timeout', 4);

        if (!$url) {
            return $text;
        }

        try {
            $payload = [
                'q' => $text,
                'source' => $source,
                'target' => $target,
                'format' => 'text',
            ];

            if ($key) {
                $payload['api_key'] = $key;
            }

            $response = Http::timeout($timeout)
                ->acceptJson()
                ->asJson()
                ->post($url, $payload);

            if (!$response->successful()) {
                return $text;
            }

            $json = $response->json();

            if (is_array($json) && isset($json['translatedText']) && is_string($json['translatedText'])) {
                $translated = trim($json['translatedText']);
                if ($translated !== '') {
                    Cache::put($cacheKey, $translated, now()->addDays(30));
                    return $translated;
                }
            }

            return $text;
        } catch (\Throwable $e) {
            return $text;
        }
    }
}
