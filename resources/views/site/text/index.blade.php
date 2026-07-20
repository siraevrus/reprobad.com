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
        "@id": "{{ route('site.text.index') }}",
        "name": "Информация"
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
                <h1>Информация</h1>
                @forelse($resources as $item)
                    <p>
                        <a href="{{ route('site.text.show', $item->alias) }}">{{ strip_tags($item->title) }}</a>
                    </p>
                @empty
                    <p>Страницы пока не опубликованы.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
