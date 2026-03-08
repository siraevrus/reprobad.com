<div class="step-item {{ $item->color }}"><img src="images/{{ $idx + 1 }}.svg" loading="lazy" alt="{{ $idx + 1 }}" class="step-item-number">
    <div class="step-item-content">
        <h2 class="step-h">{!! $item->title !!}</h2>
        <p class="step-description">{{ $item->subtitle }}</p>
        <div class="step-products">
            <a href="{{ route('site.complex.show', $item->alias) }}#{{ $item->anchor_left }}" class="step-product-left w-inline-block">
                <div class="sache-image-element">
                    <img src="{{ $item->image_left }}" loading="lazy" alt="{{ $item->alt_left ?? $item->title }}" class="sache-image">
                </div>
                <div class="step-product-shadow"></div>
            </a>
            <a href="{{ route('site.complex.show', $item->alias) }}#{{ $item->anchor_right }}" class="step-product-right w-inline-block">
                <div class="sache-image-element">
                    <img src="{{ $item->image_right }}" loading="lazy" alt="{{ $item->alt_right ?? $item->title }}" class="sache-image">
                </div>
                <div class="step-product-shadow gipokortizol"></div>
            </a>
        </div>
        <a href="{{ route('site.complex.show', $item->alias) }}" class="step-button {{ $item->color }} w-button">Подробнее —&gt;</a>
    </div>
    <div class="step-item-overlay {{ $item->color }}"></div>
</div>
