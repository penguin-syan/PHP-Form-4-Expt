<?php
namespace penguin_syan\php_form_4_expt;

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
    
    return $class_name;
}