<?php
namespace penguin_syan\php_form_4_expt;

/**
 * 複数の質問をまとめて扱うセクションを作成するためのclass
 * 
 * 
 * 使用例
 * $group1 = random_section::random_section_array(
 *             [video::video_array('./movie.mp4', ObjectSize::SMALL_FULL , 1),
 *              video::video_array('./movie.mp4', ObjectSize::SMALL, 2),
 *              video::video_array('./movie.mp4', ObjectSize::SMALL, 3),
 *              video::video_array('./movie.mp4', ObjectSize::SMALL_FULL , 4)]
 *           );
 * $group2 = random_section::random_section_array(
 *              [likert_scale::likert_scale_array('次のうち当てはまるものを選択してください．','迷わず，直感的に選択してください',['非常に同意する', '同意する', 'やや同意する', 'どちらともいえない', 'やや同意しない', '同意しない', '全く同意しない'],true),
 *               likert_scale::likert_scale_array('次のうち当てはまるものを選択してください．','迷わず，直感的に選択してください',['非常に同意する', '同意する', 'やや同意する', 'どちらともいえない', 'やや同意しない', '同意しない', '全く同意しない'],true),
 *               likert_scale::likert_scale_array('次のうち当てはまるものを選択してください．','迷わず，直感的に選択してください',['非常に同意する', '同意する', 'やや同意する', 'どちらともいえない', 'やや同意しない', '同意しない', '全く同意しない'],true)]
 *            );
 * group_section::group_section([$group1,$group2]);
 * 
 * 
 */
class GroupSection {

    /**
     * section作成用にメソッド名と引数を配列にして返すメソッド
     * 
     * @param array $lib_function 
     * @return array
     */
    public static function group_section_array(array $lib_function){
        return ['group_section', $lib_function];
    }

    /**
     * 複数の質問をまとめて扱うセクションを作成するための関数
     * 
     * 本関数を使用すると，複数の質問項目をまとめて扱うことができる．
     * また、必要に応じてページ内で表示順序を入れ替えることができる
     * 
     * @param array $lib_function [string 関数名, 実行する関数の引数] ライブラリに実装された関数の配列
     */
    public static function group_section(array $lib_function){
        if (is_array($lib_function[0])){
            foreach ($lib_function as $function) {
                self::group_section($function);
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
    
    return $class_name;
}