<?php

namespace Tests\Unit;

use App\Support\PostalAddressJsonLd;
use PHPUnit\Framework\TestCase;

class PostalAddressJsonLdTest extends TestCase
{
    public function test_splits_supplier_blob_into_postal_fields(): void
    {
        $address = PostalAddressJsonLd::fromRaw(
            'Поставщик АО "Р-Фарм". Почтовый адрес: 119421, г. Москва, Ленинский проспект, д.111, корп.1, этаж 5, ком.128.'
        );

        $this->assertSame('PostalAddress', $address['@type']);
        $this->assertSame('Ленинский проспект, д.111, корп.1, этаж 5, ком.128', $address['streetAddress']);
        $this->assertSame('Москва', $address['addressLocality']);
        $this->assertSame('119421', $address['postalCode']);
        $this->assertSame('RU', $address['addressCountry']);
        $this->assertStringNotContainsString('Поставщик', $address['streetAddress']);
        $this->assertStringNotContainsString('Р-Фарм', $address['streetAddress']);
    }

    public function test_parses_owner_address_without_g_prefix(): void
    {
        $address = PostalAddressJsonLd::fromRaw(
            'Владелец сайта: АО «Р-Фарм» 123154, Москва, ул. Берзарина, д. 19, корп. 1'
        );

        $this->assertSame('ул. Берзарина, д. 19, корп. 1', $address['streetAddress']);
        $this->assertSame('Москва', $address['addressLocality']);
        $this->assertSame('123154', $address['postalCode']);
    }

    public function test_empty_raw_returns_null(): void
    {
        $this->assertNull(PostalAddressJsonLd::fromRaw(''));
        $this->assertNull(PostalAddressJsonLd::fromRaw('   '));
        $this->assertNull(PostalAddressJsonLd::fromRaw(null));
    }

    public function test_parent_organization_is_rpharm(): void
    {
        $parent = PostalAddressJsonLd::parentOrganization();

        $this->assertSame('Organization', $parent['@type']);
        $this->assertSame('АО «Р-Фарм»', $parent['name']);
        $this->assertSame('https://www.r-pharm.com/ru', $parent['url']);
    }
}
