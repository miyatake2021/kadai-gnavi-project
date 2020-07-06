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
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center mt-5">
        @if($offset == 1)
        <li class="page-item disabled">
          <a class="page-link text-dark" href="/result/?page={{ ($offset-1) }}" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link text-dark" href="/result/?page=1" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        @endif

        
        <!-- @if($offset == 1)
        <li class="page-item active" aria-current="page"><a class="page-link" href="/result/?page=1">1<span class="sr-only">(現位置)</span></a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=2">2</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=3">3</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=4">4</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=5">5</a></li>
        @elseif($offset == 2)
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=1">1</a></li>
        <li class="page-item active" aria-current="page"><a class="page-link" href="/result/?page=2">2<span class="sr-only">(現位置)</span></a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=3">3</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=4">4</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=5">5</a></li>
        @elseif($offset == 49)
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=46">46</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=47">47</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=48">48</a></li>
        <li class="page-item active" aria-current="page"><a class="page-link" href="/result/?page=49">49<span class="sr-only">(現位置)</span></a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=50">50</a></li>
        @elseif($offset == 50)
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=46">46</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=47">47</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=48">48</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page=49">49</a></li>
        <li class="page-item active" aria-current="page"><a class="page-link" href="/result/?page=50">50<span class="sr-only">(現位置)</span></a></li>
        @else
        <li class="page-item"><a class="page-link text-dark" href="/result/?page={{ $offset-2 }}">{{ $offset-2 }}</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page={{ $offset-1 }}">{{ $offset-1 }}</a></li>
        <li class="page-item active" aria-current="page"><a class="page-link" href="/result/?page={{ $offset }}">{{ $offset }}<span class="sr-only">(現位置)</span></a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page={{ $offset+1 }}">{{ $offset+1 }}</a></li>
        <li class="page-item"><a class="page-link text-dark" href="/result/?page={{ $offset+2 }}">{{ $offset+2 }}</a></li> -->
        
        @if($offset >= 3 )
        @for($i=($offset-2);$i<=($offset+2);$i++)
        <li class="page-item"><a class="page-link text-dark" href="/result/?page={{ $i }}">{{ $i }}</a></li>
        @endfor
        @endif

        @if($offset == 50)
        <li class="page-item disabled">
          <a class="page-link text-dark" href="/result/?page={{ ($offset+1) }}" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link text-dark" href="/result/?page=50" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
        @endif
      </ul>
    </nav>
@endsection   

    
