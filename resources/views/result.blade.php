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
        <p class="text-center mt-4">該当する店舗がありませんでした</p>
      @endif
    </div>
    @if($max <= 1)
    <nav aria-label="Page navigation example" class="d-none">
    </nav>
    @else
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center mt-5">
        @if($offset == $start)
        <li class="page-item disabled">
          <a class="page-link text-dark" href="" aria-label="Previous">
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

        <!-- $max < 5の場合の処理 -->
        @if($max < 5)
          @for($i=$start;$i<=$max;$i++)
          <li class="page-item @if($i == $offset) active @endif"><a class="page-link @if($i != $offset) text-dark @endif" href="/result/?page={{ $i }}">{{ $i }}</a></li>
          @endfor
        <!-- $max >= 5の場合の処理 -->
        @else
          <!-- $offsetが1,2の時の処理 -->
          @if($offset < 3)
            @for($i=$start;$i<=5;$i++)
              <li class="page-item @if($i == $offset) active @endif "><a class="page-link @if($i != $offset) text-dark @endif" href="/result/?page={{ $i }}">{{ $i }}</a></li>
            @endfor
          <!-- $offsetが$max-2,$max-1の時の処理 -->
          @elseif($offset > ($max-2))
            @for($i=($max-4);$i<=$max;$i++)
            <li class="page-item @if($i == $offset) active @endif"><a class="page-link @if($i != $offset) text-dark @endif" href="/result/?page={{ $i }}">{{ $i }}</a></li>
            @endfor
          <!-- 通常のループ -->
          @else
            @for($i=($offset-2);$i<=($offset+2);$i++)
              <li class="page-item @if($i == $offset) active @endif"><a class="page-link @if($i != $offset) text-dark @endif" href="/result/?page={{ $i }}">{{ $i }}</a></li>
            @endfor
          @endif
        @endif

        @if($offset == $max)
        <li class="page-item disabled">
          <a class="page-link" href="" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
        @else
        <li class="page-item">
          <a class="page-link text-dark" href="/result/?page={{ $max }}" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
        @endif
      </ul>
    </nav>
    @endif
@endsection   

    
