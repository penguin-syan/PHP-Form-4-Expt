<?php
namespace penguin_syan\php_form_4_expt;

/**
 * フォームの終了宣言を行う関数があるクラス
 * 
 * @access public
 * @copyright 2022 HSSLab.
 */
class FormEnd {

    /**
     * 出力されたHTMLにおけるフォームの終了を宣言する関数
     * 
     * 本関数を使用すると，formの終了タグ"</form>"が出力される．
     */
    public static function form_end(){
        echo "</form>";
    }
}