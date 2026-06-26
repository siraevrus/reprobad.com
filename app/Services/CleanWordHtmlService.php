<?php

declare(strict_types=1);

namespace App\Services;

use DOMDocument;
use DOMElement;

class CleanWordHtmlService
{
    private const ROOT_ID = 'clean-word-html-root';

    /** @var list<string> */
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 'a', 'ul', 'ol', 'li',
        'h2', 'h3', 'h4', 'blockquote', 'iframe', 'figure', 'figcaption', 'img', 'div',
    ];

    /** @var array<string, list<string>> */
    private const ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'target', 'rel'],
        'iframe' => ['src', 'width', 'height', 'allow', 'allowfullscreen', 'frameborder', 'loading', 'referrerpolicy'],
        'img' => ['src', 'alt', 'loading', 'width', 'height'],
    ];

    public function clean(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        if (! $this->containsHtml($html)) {
            return $html;
        }

        $dom = $this->loadDom($html);
        if ($dom === null) {
            return $html;
        }

        $root = $dom->getElementById(self::ROOT_ID);
        if ($root === null) {
            return $html;
        }

        $this->cleanNode($root);

        return $this->innerHtml($root);
    }

    private function containsHtml(string $html): bool
    {
        return $html !== strip_tags($html);
    }

    private function loadDom(string $html): ?DOMDocument
    {
        $previous = libxml_use_internal_errors(true);

        try {
            $dom = new DOMDocument('1.0', 'UTF-8');
            $wrapped = '<div id="' . self::ROOT_ID . '">' . $html . '</div>';
            $loaded = $dom->loadHTML(
                '<?xml encoding="UTF-8"?>' . $wrapped,
                LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING
            );

            if (! $loaded) {
                return null;
            }

            return $dom;
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }
    }

    private function cleanNode(DOMElement $root): void
    {
        $elements = [];
        $walker = $root->getElementsByTagName('*');
        for ($i = $walker->length - 1; $i >= 0; $i--) {
            $node = $walker->item($i);
            if ($node instanceof DOMElement) {
                $elements[] = $node;
            }
        }

        foreach ($elements as $element) {
            $tag = strtolower($element->tagName);

            if ($tag === 'span' || ! in_array($tag, self::ALLOWED_TAGS, true)) {
                $this->unwrapElement($element);

                continue;
            }

            $this->stripDisallowedAttributes($element);
        }

        $this->removeEmptyParagraphs($root);
    }

    private function stripDisallowedAttributes(DOMElement $element): void
    {
        $tag = strtolower($element->tagName);
        $hasWhitelist = array_key_exists($tag, self::ALLOWED_ATTRIBUTES);
        $allowed = self::ALLOWED_ATTRIBUTES[$tag] ?? [];

        $toRemove = [];
        foreach (iterator_to_array($element->attributes ?? []) as $attribute) {
            $name = strtolower($attribute->name);

            if (str_starts_with($name, 'mso-')) {
                $toRemove[] = $attribute->name;

                continue;
            }

            if (in_array($name, ['style', 'class', 'lang', 'dir'], true)) {
                $toRemove[] = $attribute->name;

                continue;
            }

            if ($hasWhitelist) {
                if (! in_array($name, $allowed, true)) {
                    $toRemove[] = $attribute->name;
                }
            } else {
                $toRemove[] = $attribute->name;
            }
        }

        foreach ($toRemove as $name) {
            $element->removeAttribute($name);
        }
    }

    private function unwrapElement(DOMElement $element): void
    {
        $parent = $element->parentNode;
        if ($parent === null) {
            return;
        }

        while ($element->firstChild !== null) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }

    private function removeEmptyParagraphs(DOMElement $root): void
    {
        $paragraphs = $root->getElementsByTagName('p');
        for ($i = $paragraphs->length - 1; $i >= 0; $i--) {
            $paragraph = $paragraphs->item($i);
            if (! $paragraph instanceof DOMElement) {
                continue;
            }

            $text = trim(str_replace("\xc2\xa0", '', $paragraph->textContent ?? ''));
            $hasMedia = $paragraph->getElementsByTagName('img')->length > 0
                || $paragraph->getElementsByTagName('iframe')->length > 0;

            if ($text === '' && ! $hasMedia) {
                $paragraph->parentNode?->removeChild($paragraph);
            }
        }
    }

    private function innerHtml(DOMElement $element): string
    {
        $html = '';
        foreach ($element->childNodes as $child) {
            $html .= $element->ownerDocument?->saveHTML($child) ?? '';
        }

        return trim($html);
    }
}
