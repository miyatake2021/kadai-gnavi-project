<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppsController extends Controller
{
    public function index () 
    {
        return view('home');
    }

    public function result(Request $request) 
    {   
        // 変数の定義
        $range = 2;
        $lat = 0;
        $lon = 0;
        if($request->isMethod('POST')){
            $request->session()->put('search_params',$request->all());
            $range = $request->range;
            // $lat = $request->lat;
            // $lon = $request->lon;
            $lat   = 35.670083;
            $lon   = 139.763267;
            // dd($lat,$lon);
        }
        elseif($request->session()->has('search_params')){
            $search_params = $request->session()->get('search_params');
            $range = $search_params['range'];
            $lat = $search_params['lat'];
            $lon = $search_params['lon'];
        }
        else{
            return redirect('/');
        }
        
        // $request->session()->put('search_params',$request->all());
        // dd($search_params);
       


        // dd($request->all());
        // $range = $request->range;

        // dd($range);
        $uri   = "https://api.gnavi.co.jp/RestSearchAPI/v3/";

        //APIアクセスキーを変数に入れる
        $acckey= "f3e9d2953453a5b5f4c5f27d659cc78f";

        //返却値のフォーマットを変数に入れる
        $format= "json";

        //緯度・経度、範囲を変数に入れる
        //緯度経度は日本測地系で日比谷シャンテのもの。範囲はrange=1で300m以内を指定している。
        // $lat   = 35.670083;
        // $lon   = 139.763267;
        // $lat = $request->lat;
        // $lon = $request->lon;

        //URL組み立て
        // $url  = sprintf("%s%s%s%s%s%s%s%s%s%s%s", $uri, "?format=", $format, "&keyid=", $acckey, "&latitude=", $lat,"&longitude=",$lon,"&range=",$range);
        $url  = $uri ."?keyid=" .$acckey ."&range=" .$range ."&latitude=" .$lat ."&longitude=" .$lon;
        
        // $context = stream_context_create();
        // stream_context_set_option($context, 'https', 'ignore_errors', true);

        // //404ページをfile_get_contentsする
        // $html = file_get_contents("https://www.softel.co.jp/123", false, $context);

        // //404ページのHTMLの確認
        // var_dump(htmlspecialchars($html));

        // //404ページのレスポンスヘッダの確認
        // var_dump($http_response_header);

        // curl
        $ch = curl_init();
        curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FAILONERROR => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 60,
        ]);
        $obj = @json_decode(curl_exec($ch), true);
        // dd($result);

        //API実行
        // $json = file_get_contents($url);
        // dd($json);
        //取得した結果をオブジェクト化
        // $obj  = json_decode($json);
        // dd($obj);
        $restaurants = [];
        
        foreach((array)$obj as $key => $val){
            // print_r("<pre>");
            // print_r($key);
            // print_r("</pre>");
            // if(strcmp($key, "total_hit_count" ) == 0 ){
            //     echo "total:".$val."\n";
            // }
            if ($key =="rest"){
                // dd("レストランのキーがキタ");
                foreach((array)$val as $restItem){
                    $restItem = json_decode(json_encode($restItem));
                    // dd($restItem); 
                    $restaurant = [];
                    $restaurant["id"] = $restItem->id;
                    // dd($restaurant);
                    $restaurant["name"] = $restItem->name;
                    // dd($restaurant);
                    $restaurant["image"] = $restItem->image_url->shop_image1;
                    $restaurant["line"] = $restItem->access->line;
                    $restaurant["station"] = $restItem->access->station;
                    $restaurant["station_exit"] = $restItem->access->station_exit;
                    $restaurant["walk"] = $restItem->access->walk;

                    $restaurants[] = $restaurant;
                    // dd($restaurants);
                }
            }
            // if(strcmp($key, "rest") == 0){
            //     // foreach((array)$val as $restArray){
            //     //      if(checkString($restArray->{'id'}))   echo $restArray->{'id'}."\t";
            //     //      if(checkString($restArray->{'name'})) echo $restArray->{'name'}."\t";
            //     //      if(checkString($restArray->{'access'}->{'line'}))    echo (string)$restArray->{'access'}->{'line'}."\t";
            //     //      if(checkString($restArray->{'access'}->{'station'})) echo (string)$restArray->{'access'}->{'station'}."\t";
            //     //      if(checkString($restArray->{'access'}->{'walk'}))    echo (string)$restArray->{'access'}->{'walk'}."分\t";
          
            //     //      foreach((array)$restArray->{'code'}->{'category_name_s'} as $v){
            //     //          if(checkString($v)) echo $v."\t";
            //     //      }
            //     //      echo "\n";
            //     // }
          
            // }
         }
        // dd($restaurants);
        return view('result', [
            "restaurants" => $restaurants
        ]);
        
        
    }

    public function detail(Request $request) 
    {   
        // $search_params = $request->session()->get('search_params');
        // dd($search_params);
        // dd($request->all());
        $id = $request->id;
        // dd($id);
        
        $uri   = "https://api.gnavi.co.jp/RestSearchAPI/v3/";

        //APIアクセスキーを変数に入れる
        $acckey= "f3e9d2953453a5b5f4c5f27d659cc78f";

        //返却値のフォーマットを変数に入れる
        $format= "json";

        //URL組み立て
        // $url  = sprintf("%s%s%s%s%s%s%s%s%s%s%s", $uri, "?format=", $format, "&keyid=", $acckey, "&latitude=", $lat,"&longitude=",$lon,"&range=",$range);
        $url  = $uri ."?keyid=" .$acckey ."&id=" .$id;
        // dd ($url); 

        //API実行
        $json = file_get_contents($url);
        
        //取得した結果をオブジェクト化
        $obj  = json_decode($json);
        // dd($obj);
        $restaurants = [];

        foreach((array)$obj as $key => $val){
            // print_r("<pre>");
            // print_r($key);
            // print_r("</pre>");
            // if(strcmp($key, "total_hit_count" ) == 0 ){
            //     echo "total:".$val."\n";
            // }
            if ($key =="rest"){
                // dd("レストランのキーがキタ");
                // dd($val[0]);

                foreach((array)$val as $restItem){
                    // dd($restItem);
                    $restaurant = [];
                    $restaurant["name"] = $restItem->name;
                    $restaurant["image"] = $restItem->image_url->shop_image1;
                    $restaurant["opentime"] = $restItem->opentime;
                    $restaurant["tel"] = $restItem->tel;
                    $restaurant["address"] = $restItem->address;

                    $restaurants[] = $restaurant;
                    // dd($restaurants);
                }
            }
            // if(strcmp($key, "rest") == 0){
            //     // foreach((array)$val as $restArray){
            //     //      if(checkString($restArray->{'id'}))   echo $restArray->{'id'}."\t";
            //     //      if(checkString($restArray->{'name'})) echo $restArray->{'name'}."\t";
            //     //      if(checkString($restArray->{'access'}->{'line'}))    echo (string)$restArray->{'access'}->{'line'}."\t";
            //     //      if(checkString($restArray->{'access'}->{'station'})) echo (string)$restArray->{'access'}->{'station'}."\t";
            //     //      if(checkString($restArray->{'access'}->{'walk'}))    echo (string)$restArray->{'access'}->{'walk'}."分\t";
          
            //     //      foreach((array)$restArray->{'code'}->{'category_name_s'} as $v){
            //     //          if(checkString($v)) echo $v."\t";
            //     //      }
            //     //      echo "\n";
            //     // }
          
            // }
        }
        return view('detail', [
            "restaurants" => $restaurants
        ]);

    }
    //
}
