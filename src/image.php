<?php
namespace penguin_syan\php_form_4_expt;

/**
 * 画像を表示するimage関数を扱うクラス
 * 
 * @access public
 * @copyright 2022 HSSLab.
 */
class Image{

    /**
     * セクションを用いて画像を表示するための関数
     * 
     * @param string|array $filePass 画像のファイルパス
     * @param int $size 画像の大きさ
     * @return array セクション用関数の実行に必要な関数名及び引数の情報
     */
    public function image_array(string|array $filePass, int $size) {
        return ["image", $filePass, $size];
    }
    
    /**
     * 画像を表示するための関数
     * 
     * 本関数を使用すると，引数として渡された画像を<img>タグを用いて表示する．
     * この時，引数として渡されたパラメータをもとに画像のサイズを設定する．
     * 引数として渡された画像のpassが配列の場合ランダムな順番で表示する．
     * 
     *
     * @param string|array $filePass 画像のpass
     * @param int $size 画像の大きさ
     */
    public function image(string|array $filePass, int $size){
        switch ($size){
            case 0:
                $width = "45%";
                break;
            case 1:
                $width = "60%";
                break;
            case 2:
                $width = "80%";
                break;
            case 3:
                $width = "98%";
                break;
        }
    
        if (is_array($filePass)) {
            shuffle($filePass);
            foreach ($filePass as $file) {
                echo "<div><img src=$file width=$width></div>";
            }
        } else {
            echo "<div><img src=$filePass width=$width></div>";
        }
    
    }
}
