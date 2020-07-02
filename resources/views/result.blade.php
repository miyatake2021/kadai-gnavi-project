@extends('layout/app')
@section('content')
    <nav aria-label="パンくずリスト">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/" class="text-dark">Home</a></li>
        <li class="breadcrumb-item active text-dark" aria-current="page">店舗一覧</li>
      </ol>
    </nav>
        
    <div class="container-sm mt-3">
      @if(count($restaurants) > 0)
      <table class="table">
        <thead>
          <tr>
            <th scope="col">店名</th>
            <th scope="col">画像</th>
            <th scope="col">アクセス</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($restaurants as $restaurant)
          <tr>
            <td><a href="{{url('detail/' .$restaurant['id'])}}" class="id text-dark" >{{ $restaurant["name"] }}</a></td>
            @if($restaurant['image'] == "")
            <td><a href="{{url('detail/' .$restaurant['id'])}}" class="id text-dark" ><img src="https://placehold.jp/80x80.png?text=no_image" alt=""></a></td>
            @else
            <td><a href="{{url('detail/' .$restaurant['id'])}}" class="id text-dark" ><img src="{{ $restaurant['image'] }}" alt=""></a></td>
            @endif
            @if($restaurant["walk"] == "")
            <td></td>
            @else
            <td data-label="アクセス">{{ $restaurant["line"] }}{{ $restaurant["station"] }}{{ $restaurant["station_exit"] }}{{ $restaurant["walk"] }}分</td>
            @endif
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
        <p>該当する店舗がありませんでした</p>
      @endif
    </div>
@endsection   
    
