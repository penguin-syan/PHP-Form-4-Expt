<?php
namespace penguin_syan\php_form_4_expt;

/**
 * 複数の質問をまとめて扱い、順番をランダムにするセクションを作成するためのclass.
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

/**
 * コールバック関数を使用するための関数。
 * 
 * @param string $callback
 * @param array $val
 */
function run (string $callback, array $val){
    call_user_func_array(array("penguin_syan\php_form_4_expt\\".snake_to_camel($callback) , $callback), $val);
}


/**
 * スネークケースで記述された関数名からキャメルケースのクラス名を求める
 * 
 * スネークケースで記述された関数名から，その関数が所属するクラス名を求めることができる．
 * ただし，関数名とクラス名が同一である場合に限る．
 * 
 * @param string $function_name クラス名を求める関数名
 */
function snake_to_camel(string $function_name) {
    $function_name = preg_replace('/_array$/', '', $function_name);
    $func_name_parts = explode('_', $function_name);

    $class_name = "";
    foreach($func_name_parts as $func_name_part){
        $class_name .= ucfirst($func_name_part);
    }
    
    return $class_name.PHP_EOL;
}