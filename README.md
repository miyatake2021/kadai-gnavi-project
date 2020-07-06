# Restaurant Searcher

## 開発環境
- Visual Studio Code(1.32.1)

## 開発言語
- PHP(7.3.11)
- laravel FrameWork(7.12.2)

## 動作対象端末
- MacbookAir,iPhone6s（動作確認済み）

## 動作対象OS
- iOS 10.15.5、iOS13.5.1

## アプリのセットアップ方法
1).env.exampleを.envにコピー
  
2)composer installとコマンドを入力

3)php artisan key:generateとコマンドを入力

4)ぐるなびwebサービスに登録し、[https://ssl.gnavi.co.jp/api/regist/?p=input]発行されたアクセスキーを.envのGNAVI_ACCESS_KEY=　以下に書き入れる


## サーバーの起動
ローカル環境で次のコマンドを入力：php artisan serve

