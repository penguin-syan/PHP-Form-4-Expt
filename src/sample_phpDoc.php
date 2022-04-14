<?php
namespace penguin_syan\php_form_4_expt;

/**
 * サンプル関数
 *
 * PHPDocの動作及びその結果を確認するために作成された関数．
 * ライブラリとしては本関数に意味はなく，ある程度開発が進んだ段階で削除する．
 * 当然，ライブラリとしてこの関数を使用することは厳禁である．
 *
 * @deprecated PHPDocのサンプル用関数の為，非推奨どころか使用禁止．
 *
 * @param int $id ユーザID
 * @param string $name ユーザ名
 * @return string ユーザIDとユーザ名を結合した文字列
 */
function sampleFunc(int $id, string $name){
    return "ユーザIDが".$id."の人は".$name."さんです．";
}
