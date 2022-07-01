<?php
namespace penguin_syan\php_form_4_expt;

use function penguin_syan\php_form_4_expt\run;
require_once __DIR__.'/Functions.php';

/**
 * 複数の質問をまとめて扱い、順番をランダムにするセクションを作成するためのclass.
 * 
 * @access public
 * @copyright 2022 HSSLab.
 */
class RandomSection {

     /**
     * section作成用にメソッド名と引数を配列にして返すメソッド
     * 
     * @param array $lib_function 
     * @return array
     */
    public static function random_section_array(array $lib_function){
        return ['random_section', $lib_function];
    }

    /**
     * 複数の質問をまとめて扱い、順番をランダムにするセクションを作成するための関数
     * 
     * 本関数を使用すると，複数の質問項目をまとめて扱い、必要に応じてページ内で表示順序を入れ替えることができる
     * 
     * @param array $lib_function [string 関数名, 実行する関数の引数] ライブラリに実装された関数の配列
     */
    public static function random_section(array $lib_function){
        if (is_array($lib_function[0])){
            shuffle($lib_function);
            foreach ($lib_function as $function) {
                self::random_section($function);
            }
        } else {
            if (count($lib_function) > 1){
                run($lib_function[0],array_slice($lib_function, 1));
            } else {
                run($lib_function[0],[]);
            }
        }
    }
}