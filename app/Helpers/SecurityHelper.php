<?php

namespace App\Helpers;

class SecurityHelper
{
    /**
     * Sanitize maps_iframe input.
     * - Allows only a single <iframe> tag with safe Google Maps src.
     * - Strips all other HTML tags including <script>, <style>, etc.
     * - Returns null if input is empty or dangerous.
     */
    public static function sanitizeMapsIframe(?string $input): ?string
    {
        if (empty(trim($input ?? ''))) {
            return null;
        }

        $input = trim($input);

        // If it's a plain URL (not an iframe tag), validate it's a trusted maps URL
        if (str_starts_with($input, 'http')) {
            $allowedDomains = [
                'google.com/maps',
                'maps.google.com',
                'maps.app.goo.gl',
                'www.google.com/maps',
            ];
            foreach ($allowedDomains as $domain) {
                if (str_contains($input, $domain)) {
                    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
                }
            }
            return null;
        }

        // It contains an <iframe> tag — safely parse and rebuild it
        $allowedAttrs = ['src', 'width', 'height', 'style', 'class', 'allowfullscreen', 'loading', 'referrerpolicy', 'frameborder', 'title'];

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<html><body>' . $input . '</body></html>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $iframes = $dom->getElementsByTagName('iframe');

        if ($iframes->length === 0) {
            return null;
        }

        /** @var \DOMElement $iframe */
        $iframe = $iframes->item(0);

        // Validate that src is from Google Maps only
        $src = $iframe->getAttribute('src');
        $allowedSrcDomains = ['google.com/maps', 'maps.google.com'];
        $srcTrusted = false;
        foreach ($allowedSrcDomains as $domain) {
            if (str_contains($src, $domain)) {
                $srcTrusted = true;
                break;
            }
        }

        if (!$srcTrusted) {
            return null;
        }

        // Rebuild a clean, safe iframe tag with only allowed attributes
        $safeAttrs = [];
        foreach ($allowedAttrs as $attr) {
            $val = $iframe->getAttribute($attr);
            if ($val !== '') {
                $safeAttrs[] = $attr . '="' . htmlspecialchars($val, ENT_QUOTES, 'UTF-8') . '"';
            }
        }

        return '<iframe ' . implode(' ', $safeAttrs) . '></iframe>';
    }
}
