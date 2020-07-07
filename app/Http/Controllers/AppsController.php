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
        // 1000件を超えている場合、上位1000件までのデータが返却される
        $offset = 1;
        $hit_per_page = 20;
        $page_max = 1000/$hit_per_page;
        $total_hit_count = 0;

        if($request->isMethod('POST')){
            $request->session()->put('search_params',$request->all());
            $range = $request->range;
            $lat = $request->lat;
            $lon = $request->lon;
            $wifi = $request->wifi;
            $outret = $request->outret;
            $card = $request->card;
            $offset =$request->offset;
        }
        elseif($request->session()->has('search_params')){
            $search_params = $request->session()->get('search_params');
            $range = $search_params['range'];
            $lat = $search_params['lat'];
            $lon = $search_params['lon'];
            $wifi = $search_params['wifi'];
            $outret = $search_params['outret'];
            $card = $search_params['card'];
            $offset = $request->page;
            $search_params['offset']= $offset;
            $search_params = $request->session()->put('search_params',$search_params);
        }
        else{
            return redirect('/');
        }

        $uri   = "https://api.gnavi.co.jp/RestSearchAPI/v3/";

        //APIアクセスキーを変数に入れる
        $acckey= env('GNAVI_ACCESS_KEY');

        //返却値のフォーマットを変数に入れる
        $format= "json";

        //URL組み立て
        $url  = $uri ."?keyid=" .$acckey ."&range=" .$range ."&latitude=" .$lat ."&longitude=" .$lon ."&wifi=" .$wifi ."&outret=" .$outret ."&card=" .$card ."&offset_page=" .$offset ."&hit_per_page=" .$hit_per_page;
        

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
        

        $restaurants = [];
        
        
        foreach((array)$obj as $key => $val){
            
            if ($key =="rest"){
                foreach((array)$val as $restItem){
                    $restItem = json_decode(json_encode($restItem));
                    $restaurant = [];
                    $restaurant["id"] = $restItem->id;
                    $restaurant["name"] = $restItem->name;
                    $restaurant["image"] = $restItem->image_url->shop_image1;
                    $restaurant["line"] = $restItem->access->line;
                    $restaurant["station"] = $restItem->access->station;
                    $restaurant["station_exit"] = $restItem->access->station_exit;
                    $restaurant["walk"] = $restItem->access->walk;
                    $restaurant["holiday"] = $restItem->holiday;
                    $restaurant["url"] = $restItem->url;
                    $restaurant["budget"] = $restItem->budget;
                    
                    $restaurants[] = $restaurant;
                }
            }
        }
        if($restaurants){
            $total_hit_count = $obj["total_hit_count"];
        }
        else{
            $total_hit_count = 0;
        }
        $start = 1;
        $max =50;
        $total_page =ceil($total_hit_count/$hit_per_page);
        if($page_max > $total_page){
            $max = $total_page;
        }
        else{
            $max =$page_max;
        }
        return view('result', [
            "restaurants" => $restaurants,
            "offset"=>$offset,
            "max"=>$max,
            "start"=>$start,
        ]);
    }

    public function detail(Request $request) 
    {   
        $id = $request->id;
        
        $uri   = "https://api.gnavi.co.jp/RestSearchAPI/v3/";

        $offset = $request->page;
        // dd($offset);

        //APIアクセスキーを変数に入れる
        $acckey= env('GNAVI_ACCESS_KEY');

        //返却値のフォーマットを変数に入れる
        $format= "json";

        //URL組み立て
        $url  = $uri ."?keyid=" .$acckey ."&id=" .$id ."&offset=" .$offset;

        //API実行
        $json = file_get_contents($url);
        
        //取得した結果をオブジェクト化
        $obj  = json_decode($json);
        $restaurants = [];

        foreach((array)$obj as $key => $val){
            
            if ($key =="rest"){
                foreach((array)$val as $restItem){
                    $restaurant = [];
                    $restaurant["name"] = $restItem->name;
                    $restaurant["image"] = $restItem->image_url->shop_image1;
                    $restaurant["opentime"] = $restItem->opentime;
                    $restaurant["tel"] = $restItem->tel;
                    $restaurant["address"] = $restItem->address;
                    $restaurant["holiday"] = $restItem->holiday;
                    $restaurant["url"] = $restItem->url;
                    $restaurant["budget"] = $restItem->budget;

                    $restaurants[] = $restaurant;
                }
            }
        }
        $search_params = $request->session()->get('search_params');
        $offset = $search_params['offset'];
        
        return view('detail', [
            "restaurants" => $restaurants,
            "offset"=> $offset,
        ]);
    }
    //
}
