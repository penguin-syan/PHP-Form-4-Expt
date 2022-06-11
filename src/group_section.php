<?php
namespace penguin_syan\php_form_4_expt;

/**
 * 複数の質問をまとめて扱うセクションを作成するための関数
 * 
 * 本関数を使用すると，複数の質問項目をまとめて扱うことができる．
 * 
 * 
 * 使用例
 * $group1 = ["random_section",
 *             [
 *               ['video','./movie.mp4', ObjectSize::SMALL_FULL , 3],
 *               ["likert_scale",'次のうち当てはまるものを選択してください．','迷わず，直感的に選択してください',['非常に同意する', '同意する', 'やや同意する', 'どちらともいえない', 'やや同意しない', '同意しない', '全く同意しない'],true],
 *               ["video",'./movie.mp4', ObjectSize::SMALL, 1]
 *             ]
 *           ];
 *
 * $group2 = ["random_section",
 *             [
 *               ['video','./movie.mp4', ObjectSize::SMALL_FULL , 3],
 *               ["likert_scale",'次のうち当てはまるものを選択してください．','迷わず，直感的に選択してください',['非常に同意する', '同意する', 'やや同意する', 'どちらともいえない', 'やや同意しない', '同意しない', '全く同意しない'],true],
 *               ["video",'./movie.mp4', ObjectSize::SMALL, 1]
 *             ]
 *           ];
 *
 * group_section([$group1,$group2]);
 * 
 * 
 * @param array $lib_function [string 関数名, 実行する関数の引数] ライブラリに実装された関数の配列
 */

 function group_section(array $lib_function){
    foreach ($lib_function as $function) {
        run($function[0],array_slice($function, 1));
    }
 }

 function random_section(array $lib_function){
    shuffle($lib_function);
    foreach ($lib_function as $function) {
        run($function[0],array_slice($function, 1));
    }
 }

 function run (callable $f, array $val){
    call_user_func_array($f,$val);
}