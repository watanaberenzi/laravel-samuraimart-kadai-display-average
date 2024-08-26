@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-2">
    @component('components.sidebar', ['categories' => $categories, 'major_categories' => $major_categories])
        @endcomponent
    </div>
    <div class="col-9">
        <div class="container">
            @if ($category !== null)
            <a href="{{ route('products.index') }}">トップ</a> > <a href="#">{{ $major_category->name }}</a> > {{ $category->name }}
                <h1>{{ $category->name }}の商品一覧{{$total_count}}件</h1>
            @elseif ($keyword !== null)
                <a href="{{ route('products.index') }}">トップ</a> > 商品一覧
                <h1>"{{ $keyword }}"の検索結果{{$total_count}}件</h1>
            @endif
        </div>
        <div>
            Sort By
            @sortablelink('id', 'ID')
            @sortablelink('price', 'Price')
            @sortablelink('created_at', 'Created_At')
        </div>
        <div class="container mt-4">
            <div class="row w-100">
                @foreach($products as $product)
                <div class="col-3">
                    <a href="{{route('products.show', $product)}}">
                        @if ($product->image !== "")
                        <img src="{{ asset($product->image) }}" class="img-thumbnail">
                        @else
                        <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail">
                        @endif
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <p class="samuraimart-product-label mt-2">
                                <a href="{{ route('products.show', $recommend_product) }}" class="link-dark">{{ $recommend_product->name }}</a>
                                <br>
                                <!-- 平均評価 -->
                                @if ($recommend_product->reviews()->exists())
                                <span class="samuraimart-star-rating" data-rate="{{ round($recommend_product->reviews->avg('score')*2)/2 }}"></span>
                                {{ round($recommend_product->reviews->avg('score'), 1) }}
                                @endif

                                <br>
                                <label>￥{{ number_format($recommend_product->price) }}</label>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection