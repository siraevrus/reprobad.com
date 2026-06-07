<?php

namespace App\Services;

class InternalLinkService
{
    /**
     * @return array{html: string, status: 'linked'|'already_linked'|'not_found'}
     */
    public function insertLink(string $html, string $phrase, string $url): array
    {
        $phrase = trim($phrase);
        $url = trim($url);

        if ($phrase === '' || $url === '') {
            return ['html' => $html, 'status' => 'not_found'];
        }

        if ($this->isPhraseAlreadyLinked($html, $phrase, $url)) {
            return ['html' => $html, 'status' => 'already_linked'];
        }

        $parts = preg_split('/(<a\b[^>]*>.*?<\/a>)/is', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        if ($parts === false) {
            return ['html' => $html, 'status' => 'not_found'];
        }

        $linked = false;

        foreach ($parts as $index => $part) {
            if ($linked || preg_match('/^<a\b/i', $part)) {
                continue;
            }

            $replacement = $this->replaceFirstPhraseMatch($part, $phrase, $url);
            if ($replacement === null) {
                continue;
            }

            $parts[$index] = $replacement;
            $linked = true;
        }

        if (! $linked) {
            return ['html' => $html, 'status' => 'not_found'];
        }

        return ['html' => implode('', $parts), 'status' => 'linked'];
    }

    private function replaceFirstPhraseMatch(string $part, string $phrase, string $url): ?string
    {
        $position = mb_strpos($part, $phrase);
        if ($position !== false) {
            return $this->wrapPhraseAtPosition($part, $position, $phrase, $url);
        }

        $flexiblePattern = $this->buildFlexibleWhitespacePattern($phrase);
        if ($flexiblePattern !== null && preg_match($flexiblePattern, $part, $matches)) {
            $matchedText = $matches[1];
            $position = mb_strpos($part, $matchedText);
            if ($position !== false) {
                return $this->wrapPhraseAtPosition($part, $position, $matchedText, $url);
            }
        }

        $pattern = $this->buildPhrasePattern($phrase);
        if (! preg_match($pattern, $part, $matches, PREG_OFFSET_CAPTURE)) {
            return null;
        }

        $matchedText = $matches[1][0];
        $position = mb_strpos($part, $matchedText);
        if ($position === false) {
            return null;
        }

        return $this->wrapPhraseAtPosition($part, $position, $matchedText, $url);
    }

    private function wrapPhraseAtPosition(string $part, int $position, string $matchedText, string $url): string
    {
        $before = mb_substr($part, 0, $position);
        $after = mb_substr($part, $position + mb_strlen($matchedText));
        $link = '<a href="' . htmlspecialchars($url, ENT_QUOTES | ENT_HTML5, 'UTF-8') . '">' . $matchedText . '</a>';

        return $before . $link . $after;
    }

    private function buildPhrasePattern(string $phrase): string
    {
        return '/(?<![\p{L}\p{N}])(' . preg_quote($phrase, '/') . ')(?![\p{L}\p{N}])/ui';
    }

    private function buildFlexibleWhitespacePattern(string $phrase): ?string
    {
        $words = preg_split('/\s+/u', trim($phrase));
        if (count($words) <= 1) {
            return null;
        }

        $separator = '(?:\s|&nbsp;|\x{00A0})+';
        $parts = array_map(static fn (string $word): string => preg_quote($word, '/'), $words);

        return '/(?<![\p{L}\p{N}])(' . implode($separator, $parts) . ')(?![\p{L}\p{N}])/ui';
    }

    private function isPhraseAlreadyLinked(string $html, string $phrase, string $url): bool
    {
        $escapedUrl = preg_quote($url, '/');
        $pattern = '/<a\b[^>]*href="' . $escapedUrl . '"[^>]*>(.*?)<\/a>/uis';

        if (preg_match_all($pattern, $html, $matches)) {
            foreach ($matches[1] as $anchorText) {
                if (mb_strtolower(trim(strip_tags($anchorText))) === mb_strtolower($phrase)) {
                    return true;
                }
            }
        }

        $phrasePattern = $this->buildPhrasePattern($phrase);
        if (preg_match_all('/<a\b[^>]*>(.*?)<\/a>/uis', $html, $matches)) {
            foreach ($matches[1] as $anchorText) {
                if (preg_match($phrasePattern, strip_tags($anchorText))) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return list<array{0: string, 1: string, 2: string}>
     */
    public function parseSpreadsheet(string $path): array
    {
        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            throw new \RuntimeException("Cannot open spreadsheet: {$path}");
        }

        $sharedStrings = $this->parseSharedStrings($zip->getFromName('xl/sharedStrings.xml') ?: '');
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($sheetXml === false) {
            throw new \RuntimeException('Worksheet sheet1.xml not found in spreadsheet.');
        }

        $sheet = simplexml_load_string($sheetXml);
        if ($sheet === false) {
            throw new \RuntimeException('Failed to parse worksheet XML.');
        }

        $ns = $sheet->getNamespaces(true);
        $mainNs = $ns['x'] ?? $ns[''] ?? 'http://schemas.openxmlformats.org/spreadsheetml/2006/main';

        $rows = [];
        foreach ($sheet->children($mainNs)->sheetData->row as $row) {
            $values = ['', '', ''];
            $columnIndex = 0;

            foreach ($row->children($mainNs)->c as $cell) {
                $attributes = $cell->attributes();
                $reference = isset($attributes['r']) ? (string) $attributes['r'] : '';
                $column = preg_replace('/[^A-Z]/', '', $reference);
                $index = ['A' => 0, 'B' => 1, 'C' => 2][$column] ?? null;

                if ($index === null) {
                    $index = $columnIndex;
                    $columnIndex++;
                }

                if ($index > 2) {
                    continue;
                }

                $cellType = isset($attributes['t']) ? (string) $attributes['t'] : '';
                $cellValue = (string) $cell->children($mainNs)->v;
                if ($cellValue === '') {
                    continue;
                }

                $values[$index] = match ($cellType) {
                    's' => $sharedStrings[(int) $cellValue] ?? '',
                    default => $cellValue,
                };
            }

            if ($values[0] !== '' && ! in_array($values[0], ['Статья', 'Название статьи'], true)) {
                $rows[] = [$values[0], $values[1], $values[2]];
            }
        }

        return $rows;
    }

    /**
     * @return list<string>
     */
    private function parseSharedStrings(string $xml): array
    {
        if ($xml === '') {
            return [];
        }

        $document = simplexml_load_string($xml);
        if ($document === false) {
            return [];
        }

        $ns = $document->getNamespaces(true);
        $mainNs = $ns[''] ?? $ns['x'] ?? 'http://schemas.openxmlformats.org/spreadsheetml/2006/main';
        $strings = [];

        foreach ($document->children($mainNs)->si as $item) {
            $textParts = [];
            foreach ($item->children($mainNs)->t as $textNode) {
                $textParts[] = (string) $textNode;
            }

            if ($textParts === []) {
                foreach ($item->children($mainNs)->r as $run) {
                    foreach ($run->children($mainNs)->t as $textNode) {
                        $textParts[] = (string) $textNode;
                    }
                }
            }

            $strings[] = implode('', $textParts);
        }

        return $strings;
    }
}
