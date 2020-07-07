@extends('layout/app')
@section('content')
      <nav aria-label="パンくずリスト">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/" class="text-dark">Home</a></li>          
          <li class="breadcrumb-item"><a href="/result?page={{ $offset }}" class="text-dark">店舗一覧</a></li>
          <li class="breadcrumb-item active text-dark" aria-current="page">店舗詳細</li>
        </ol>
      </nav>
      
      <div class="container-lg mt-5 mr-0">
        @foreach ($restaurants as $restaurant)
        <h3 class="m-0">{{ $restaurant["name"] }}</h3>
        <div class="mt-3 w-100">
          <div class="contents w-auto align-top">　
            @if($restaurant['image'] == "")
            <img src="https://placehold.jp/240x240.png?text=no_image" alt="">
            @else
            <img src="{{ $restaurant['image'] }}" alt="">
            @endif
          </div>
          <div class="intro align-top">
            <ul class="list-group list-group-flush">
            <li class="list-group-item">営業時間:{{ $restaurant["opentime"] }}</li>
            <li class="list-group-item">休業日:{{ $restaurant["holiday"] }}</li>
            @if($restaurant["budget"] == "")
            <li class="list-group-item">平均予算:</li>
            @else
            <li class="list-group-item">平均予算:{{ $restaurant["budget"] }}円</li>
            @endif
            <li class="list-group-item">住所:{{ $restaurant["address"] }}</li>
            <li class="list-group-item">電話番号:{{ $restaurant["tel"] }}</li>
            <li class="list-group-item url">ページURL:
              <a href="{{url( $restaurant['url'])}}" target="_blank" rel="noopener noreferrer">{{ $restaurant["url"] }}</a>
            </li>
            </ul>
          </div>
        </div>
        @endforeach
      </div>
@endsection
