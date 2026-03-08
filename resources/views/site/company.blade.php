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
        "@id": "{{ route('site.text.company') }}",
        "name": "{{ strip_tags($resource->title ?? 'О компании') }}"
      }
    }
  ]
}
</script>
@endsection

@section('content')
    <section class="section">
        <div class="container manufacturer-container">
            <div class="rfarm-logo-wrap"><img src="images/RFarmLogo.png" loading="lazy" alt="Лого Р-ФАРМ" class="rfarm-green-logo"></div>
            <div class="manufacturer-richtext _w-630 w-richtext">
                <h1>{{ $resource->title }}</h1>
                <p>{{ $resource->description }}</p>
            </div>

            @foreach($resource->content as $block)
                @if($block['type'] == 'block12')
                    <div class="manufacturer-richtext w-richtext">
                        {!! $block['data']['text'] !!}
                    </div>
                @elseif($block['type'] == 'block3')
                    <div class="manufacturer-images-wrap main-image">
                        <img src="{{ $block['data']['image'] }}" loading="lazy" alt="{{ $block['data']['image_alt'] ?? '' }}" class="manufacturer-image">
                    </div>
                @elseif($block['type'] == 'block9')
                    <div class="manufacturer-images-wrap">
                        @foreach($block['data']['subBlocks'] as $idx => $subBlock)
                            @if($idx == 0)
                                <img src="{{ $subBlock['data']['image'] }}" loading="lazy" alt="{{ $subBlock['data']['image_alt'] ?? '' }}" class="manufacturer-image manufacturer-image _1-2">
                            @else
                                <img src="{{ $subBlock['data']['image'] }}" loading="lazy" alt="{{ $subBlock['data']['image_alt'] ?? '' }}" class="manufacturer-image manufacturer-image _1-4">
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection
