@extends('site.layouts.base')

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
