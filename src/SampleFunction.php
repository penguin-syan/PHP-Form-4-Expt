<?php
namespace penguin_syan\php_form_4_expt;

/**
 * サンプル用のクラス
 * 
 * @access public
 * @copyright 2022 HSSLab.
 */
class SampleFunction{

    /**
     * セクションを用いてサンプル関数を呼び出すための関数
     * 
     * PHPDocの動作及びその結果を確認するために作成された関数．
     * ライブラリとしては本関数に意味はなく，ある程度開発が進んだ段階で削除する．
     * 当然，ライブラリとしてこの関数を使用することは厳禁である．
     * 
     * @deprecated PHPDocのサンプル用関数のため，非推奨どころか使用禁止．
     * 
     * @param int $id ユーザID
     * @param string $name ユーザ名
     * @return array セクション用関数の実行に必要な関数名及び引数の情報
     */
    public function sample_function_array(int $id, string $name) {
        return ['sample_function', $id, $name];
    }
    
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
    public function sample_function(int $id, string $name){
        return "ユーザIDが".$id."の人は".$name."さんです．";
    }
}

