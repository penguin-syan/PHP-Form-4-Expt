# PHP-Form-4-Expt
研究で使用するPHPベースのアンケートフォーム作成用ライブラリ

## ℹ️ 本ライブラリについて
このライブラリは[こちら](https://github.com/penguin-syan/PHP-Form-4-Expt)のリポジトリを中心に開発されています．  
研究室用のオンプレミスGitLabサーバにも同一のものがありますが，こちらは開発時の痕跡です．  
本ライブラリに更新を加える場合，その変更内容はGitHub上のリポジトリに必ず適応する必要があります．  
適切に適応されない場合，Composerを用いてインストールしたライブラリに変更が適応されません．

---

## 💻 動作イメージ
<img src="https://user-images.githubusercontent.com/58884426/156914940-239a4c0c-5ab0-4e84-8ba7-eedf7f57cf91.svg" width="65%">


## ⬇️ インストール
本ライブラリのインストールには，[Composer](https://getcomposer.org/)を使用します．
1. （未インストールの場合）[こちら](https://getcomposer.org/download/)からComposerをインストールする
1. 本ライブラリを使用するプロジェクトディレクトリに`composer.json`ファイルを作成し，以下の内容を記述する
1. ターミナルにてプロジェクトディレクトリを開き，コマンド`composer install`を実行する
1. インストールに成功した場合，`vendor/`ディレクトリが作成される

* ライブラリをアップデートする場合は，ターミナルにて`プロジェクトディレクトリ`を開き，コマンド`composer upgrade`を実行する．

```json:composer.json
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/penguin-syan/PHP-Form-4-Expt.git"
    }
  ],

  "require": {
    "penguin_syan/composertest": "1.*"
  }
}
```

## 使い方
ライブラリを読み込むプログラム内に以下の内容を追記する．

```php
require_once dirname(__FILE__).'/vendor/autoload.php';

use penguin_syan\ComposerTest\WorldClass;
use function penguin_syan\ComposerTest\hworld;
use function penguin_syan\ComposerTest\hworld_text;
```

詳細は[Wiki](https://github.com/penguin-syan/PHP-Form-4-Expt/wiki)を参照すること．
