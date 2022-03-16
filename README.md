# PHP-Form-4-Expt（開発中）
![License](https://img.shields.io/github/license/penguin-syan/PHP-Form-4-Expt)
![RepoVersion](https://img.shields.io/github/v/release/penguin-syan/PHP-Form-4-Expt)
![PHPVersion](https://img.shields.io/badge/php-%5E8.0-blueviolet)
![Size](https://img.shields.io/github/repo-size/penguin-syan/PHP-Form-4-Expt?color=9cf)

## ℹ️ 本ライブラリについて
このライブラリは[こちら](https://github.com/penguin-syan/PHP-Form-4-Expt)のリポジトリにて開発されています．  
研究室用のオンプレミスGitLabサーバにも同一のリポジトリがありますが，こちらは単にミラーリングされたものです．  
本ライブラリに更新を加える場合，その変更内容はGitHub上のリポジトリに必ず適応する必要があります．  

---

## 💻 概要：動作イメージ
研究で使用するPHPベースのアンケートフォーム作成用ライブラリです．  
Composerを用いて簡単にインストールすることができ，各アンケート項目を容易に実装できます．  

<img src="https://user-images.githubusercontent.com/58884426/156914940-239a4c0c-5ab0-4e84-8ba7-eedf7f57cf91.svg" width="65%">


## ⬇️ インストール
本ライブラリのインストール方法は2つあります．  
何れの場合も[Composer](https://getcomposer.org/)を使用しますので，未インストールの場合は予め[こちら](https://getcomposer.org/download/)からインストールしてください．

### 方法1：コマンドラインで追加する（推奨）
ライブラリを読み込むプログラムディレクトリ内にて以下のコマンドを実行する．

```sh
$ composer config repositories.penguin-syan/PHP-Form-4-Expt vcs https://github.com/penguin-syan/PHP-Form-4-Expt
$ composer require penguin-syan/PHP-Form-4-Expt
```
※`File "./composer.json" cannot be found in the current directory`とエラーが表示される場合は，`composer.json`を作成し以下の内容を記述する
```json
{
}
```

### 方法2：composer.jsonを直接記述する

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

本ライブラリの利用に関する詳細は[ドキュメント](https://penguin-syan.github.io/PHP-Form-4-Expt/)を参照すること．
開発者用データは[Wiki](https://github.com/penguin-syan/PHP-Form-4-Expt/wiki)を参照すること．
