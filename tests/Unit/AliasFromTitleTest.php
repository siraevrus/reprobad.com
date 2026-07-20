<?php

namespace Tests\Unit;

use App\Support\AliasFromTitle;
use PHPUnit\Framework\TestCase;

class AliasFromTitleTest extends TestCase
{
    public function test_transliterates_cyrillic_title_to_slug(): void
    {
        $this->assertSame(
            'podgotovka-k-beremennosti',
            AliasFromTitle::make('Подготовка к беременности')
        );
    }

    public function test_strips_html_and_extra_dashes(): void
    {
        $this->assertSame(
            'poleznyy-sovet',
            AliasFromTitle::make('<p>Полезный   совет!!!</p>')
        );
    }

    public function test_empty_title_returns_empty_alias(): void
    {
        $this->assertSame('', AliasFromTitle::make(''));
        $this->assertSame('', AliasFromTitle::make(null));
    }
}
