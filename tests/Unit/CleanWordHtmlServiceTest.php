<?php

namespace Tests\Unit;

use App\Services\CleanWordHtmlService;
use Tests\TestCase;

class CleanWordHtmlServiceTest extends TestCase
{
    private CleanWordHtmlService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CleanWordHtmlService;
    }

    public function test_removes_word_inline_styles_and_classes(): void
    {
        $input = '<p class="MsoNormal" style="line-height: normal; margin: 12.0pt 0cm;"><span style="font-size: 12.0pt; font-family: \'Times New Roman\',serif; color: black;">Слово &laquo;фертильность&raquo; &mdash; это способность организма к зачатию.</span></p>';

        $result = $this->service->clean($input);

        $this->assertStringNotContainsString('MsoNormal', $result);
        $this->assertStringNotContainsString('style=', $result);
        $this->assertStringNotContainsString('<span', $result);
        $this->assertStringContainsString('фертильность', $result);
        $this->assertStringContainsString('«', $result);
        $this->assertStringContainsString('—', $result);
    }

    public function test_preserves_links_and_semantic_tags(): void
    {
        $input = '<p><strong>Важно</strong> <a href="https://example.com" target="_blank" rel="noopener" style="color: blue;">ссылка</a></p><ul><li>пункт</li></ul>';

        $result = $this->service->clean($input);

        $this->assertStringContainsString('<strong>', $result);
        $this->assertStringContainsString('href="https://example.com"', $result);
        $this->assertStringContainsString('target="_blank"', $result);
        $this->assertStringContainsString('<ul>', $result);
        $this->assertStringNotContainsString('style=', $result);
    }

    public function test_preserves_iframe_attributes(): void
    {
        $input = '<p><iframe src="https://rutube.ru/play/embed/abc" width="720" height="405" class="video" style="border:0;"></iframe></p>';

        $result = $this->service->clean($input);

        $this->assertStringContainsString('<iframe', $result);
        $this->assertStringContainsString('src="https://rutube.ru/play/embed/abc"', $result);
        $this->assertStringNotContainsString('class=', $result);
        $this->assertStringNotContainsString('style=', $result);
    }

    public function test_returns_plain_text_unchanged(): void
    {
        $input = 'Простой текст без HTML';

        $this->assertSame($input, $this->service->clean($input));
    }
}
