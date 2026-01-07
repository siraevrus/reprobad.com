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
        "@id": "{{ request()->url() }}",
        "name": "{{ strip_tags($resource->title ?? '') }}"
      }
    }
  ]
}
</script>
@endsection

@section('content')
    <section class="section">
        <div class="container">
            <div class="policy-richtext w-richtext">
                <h1>{{ $resource->title }}</h1>
                @foreach($resource->content as $block)
                    {!! $block['data']['text'] ?? '' !!}
                @endforeach
            </div>
        </div>
    </section>
@endsection
