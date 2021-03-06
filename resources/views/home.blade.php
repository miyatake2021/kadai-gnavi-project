@extends('layout/app')
@section('content')
    <nav aria-label="パンくずリスト">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active text-dark" aria-current="page">Home</li>
      </ol>
    </nav>
 
    <form action="result" method="post">
      @csrf
      <input type="hidden" id="lat" name="lat">
      <input type="hidden" id="lon" name="lon">
      <input type="hidden" id="offset" name="offset" value="1">
      <div class="form-row aligh-items-center mt-5" >
          <div class="col-4 mt-1">
            <p class="float-right">現在地から</p>
          </div>
          <div class="col-4">
            <select class="custom-select" name="range">
              <option value="1">300m</option>
              <option value="2">500m</option>
              <option value="3">1000m</option>
              <option value="4">2000m</option>
              <option value="5">3000m</option>
            </select>
          </div>
          <div class="col-4 mt-1">
            <p>圏内</p>
          </div>
      <div class="dropdown">
        <button type="button" id="dropdown1"
            class="btn btn-secondary dropdown-toggle"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
          詳細設定
        </button>
        <!-- 詳細設定 -->
        <div class="form-check dropdown-menu" aria-labelledby="dropdown1">
          <div class="dropdown-item">
          <input class="form-check-input" type="hidden" value="0" id="wifi" name="wifi">
          <input class="form-check-input" type="checkbox" value="1" id="wifi" name="wifi">
          <label class="form-check-label" for="wifi">
          wifi
          </label>
          </div>
          <div class="dropdown-item">
          <input class="form-check-input" type="hidden" value="0" id="outret" name="outret">
          <input class="form-check-input" type="checkbox" value="1" id="outret" name="outret">
          <label class="form-check-label" for="outret">
          電源
          </label>
          </div>
          <div class="dropdown-item">
          <input class="form-check-input" type="hidden" value="0" id="card" name="card">
          <input class="form-check-input" type="checkbox" value="1" id="card" name="card">
          <label class="form-check-label" for="card">
          カードの利用
          </label>
          </div>
        </div>
      </div>

      </div>
    
      <div class="text-center mt-3">
        <button type="submit" class="btn btn-outline-dark center-block" id ="check_position" disabled>検索</button>
      </div>
    </form>
@endsection    


<script>
    // Geolocation APIに対応している
    if (navigator.geolocation) {
      alert("位置情報を取得しますか？");
    // Geolocation APIに対応していない
    } 
    else {
      alert("位置情報が取得できません");
    }

    // 現在地取得処理
    function getPosition() {
      // 現在地を取得
      navigator.geolocation.getCurrentPosition(
        // 取得成功した場合
        function(position) {
          // alert("取得成功");
          const lat = position.coords.latitude; 
				  const lon = position.coords.longitude; 
          const $lat = document.getElementById("lat");
          const $lon = document.getElementById("lon");
          $lat.value = lat;
          $lon.value = lon;
          document.getElementById("check_position").disabled = "";
        },
        // 取得失敗した場合
        function(error) {
          switch(error.code) {
            case 1: //PERMISSION_DENIED
              alert("位置情報の利用が許可されていません");
              break;
            case 2: //POSITION_UNAVAILABLE
              alert("現在位置が取得できませんでした");
              break;
            case 3: //TIMEOUT
              alert("タイムアウトになりました");
              break;
            default:
              alert("その他のエラー(エラーコード:"+error.code+")");
              break;
          }
        }
      );
    }
    getPosition();
</script>

  

