@extends('site.layouts.base')

@section('content')
    <section class="section">
        <div class="container">
            <div class="sistema-repro-heading products-page-heading">
                <h1 class="sistema-repro-h1"><span class="sistema-repro-semibold">СИСТЕМА РЕПРО</span> <span class="sistema-repro-h1-descriptor">подготовка пары к беременности</span></h1>
                <p class="sistema-repro-p">Современным трендом преконцепционной подготовки к успешному зачатию и вынашиванию беременности является совместная подготовка пары и гармонизация здоровья женщины и мужчины</p>
            </div>
            <div class="spacer desktop-2-rem"></div>
            <div class="_4-steps-wrap">
                @foreach($resources as $idx => $complex)
                    @include('site.components.complex.item', ['item' => $complex])
                @endforeach
            </div>
            <div class="spacer desktop-3-rem"></div>
        </div>
    </section>
@endsection
