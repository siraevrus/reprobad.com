@extends('site.layouts.base')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "item": {
        "@id": "{{ config('app.url') }}",
        "name": "Главная"
      }
    },
    {
      "@type": "ListItem",
      "position": 2,
      "item": {
        "@id": "{{ route('site.text.about') }}",
        "name": "{{ strip_tags($resource->title ?? 'О системе') }}"
      }
    }
  ]
}
</script>
<style>
    .about-repro-h1 .sistema-repro-semibold {
        margin-right: -5px;
    }
    .about-schema-footnotes,
    .about-schema-footnotes p,
    .about-schema-footnotes div,
    .about-schema-footnotes li,
    .about-schema-footnotes span {
        font-family: Inter, sans-serif;
        font-size: 1rem !important;
        font-weight: 500;
        line-height: 1.375;
        text-align: left !important;
    }
    .about-schema-footnotes {
        margin-left: 0 !important;
        margin-right: auto !important;
        align-self: flex-start !important;
        margin-bottom: 0;
    }
</style>
@endsection

@section('content')
    @foreach($resource->content as $block)
        @if($block['type'] == 'block13' && !$block['hide'])
            <section class="section about-page-hero">
                <div class="container about-page-container">
                    <h1 class="about-repro-h1"><span class="sistema-repro-semibold">{{ $block['data']['title'] }}</span><span class="o-span about-o"><strong>О</strong></span> <span class="about-repro-h1-descriptor">{{ $block['data']['subtitle'] }}</span></h1>
                </div><img src="{{ public_asset($block['data']['image']) }}" loading="lazy" alt="" class="about-hero-img">
            </section>
        @elseif($block['type'] == 'block14' && !$block['hide'])
            <section class="section">
                <div class="container about-flex-container">
                    <h2 class="about-h2">{{ $block['data']['title'] }}</h2>
                    <p class="about-p">{{ $block['data']['col1'] }}</p>
                    <p class="about-p">{{ $block['data']['col2'] }}</p>
                </div>
            </section>
        @elseif($block['type'] == 'block15' && !$block['hide'])
            <section class="section about-schema-section">
                <div class="container about-schema-container">
                    @if($block['data']['title'])<h2 class="about-schema-h2"><strong>{{ $block['data']['title'] }}</strong></h2>@endif
                    @if($block['data']['subtitle'])<p class="about-schema-p">{!! $block['data']['subtitle'] !!}</p>@endif
                    @if($block['data']['image'])
                        @php $aboutSchemaImg = public_asset($block['data']['image']); @endphp
                        @if($aboutSchemaImg !== '')
                            <img src="{{ $aboutSchemaImg }}" loading="lazy" alt="{{ $block['data']['title'] ?? 'Схема системы РЕПРО' }}" class="about-schema">
                            <img src="{{ $aboutSchemaImg }}" loading="lazy" alt="" class="about-schema mob">
                        @endif
                    @endif
                    @if($block['data']['text'])<div class="about-schema-footnotes">{!! $block['data']['text'] !!}</div>@endif
                </div>
            </section>
        @endif
    @endforeach


    <section class="section sistema-section">
        <div class="container">
            <div>
                <div class="_4-steps-wrap">
                    @foreach($complexes as $idx => $complex)
                        @include('site.components.complex.item', ['item' => $complex])
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
