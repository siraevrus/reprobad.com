@extends('site.layouts.base')

@section('content')
    <section class="section">
        <div class="container manufacturer-container">
            <div class="rfarm-logo-wrap"><img src="images/RFarmLogo.png" loading="lazy" alt="" class="rfarm-green-logo"></div>
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
                        <img src="{{ $block['data']['image'] }}" loading="lazy" sizes="(max-width: 767px) 100vw, 83vw" srcset="{{ $block['data']['image'] }} 500w, {{ $block['data']['image'] }}, {{ $block['data']['image'] }} 1080w, {{ $block['data']['image'] }} 1440w" alt="" class="manufacturer-image">
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection
