<?php
namespace penguin_syan\php_form_4_expt;

/**
 * チェックボックス形式の質問を扱う関数があるクラス
 * 
 * @access public
 * @copyright 2022 HSSLab.
 */
class Checkbox{

    /**
     * セクションを用いてチェックボックス形式の質問を出力する関数
     * 
     * @param string $question 質問文
     * @param string $supplement 補足文
     * @param array $choices 回答の選択肢
     * @param bool $required 回答の必須有無
     * @param int $min_select 最小選択数
     * @param int $max_select 最大選択数
     * @return array セクション用関数の実行に必要な関数名及び引数の情報
     */

    public static function checkbox_array(string $question, string $supplement, array $choices, bool $required, int $min_select = 0, int $max_select = 0){
        return ['checkbox', $question, $supplement, $choices, $required, $min_select, $max_select];
    }

    /**
     * チェックボックス形式の質問を出力する関数
     * 
     * 本関数を使用するとチェックボックス形式の質問が出力される．
     * オプションとして，回答の必須有無，最小選択数，最大選択数を設定することができる．
     * 最小選択数，最大選択数の引数は省略することができる
     * 省略した場合の初期値は，最小選択数が0（回答必須有の場合1），最大選択数は回答の選択肢と同数（選択肢の数が5であれば最大選択数も5）となる．
     * 
     * @param string $question 質問文
     * @param string $supplement 補足文
     * @param array $choices 回答の選択肢
     * @param bool $required 回答の必須有無
     * @param int $min_select 最小選択数
     * @param int $max_select 最大選択数
     * @todo 最小選択数と最大選択数のオプションは本関数内では未対応
     */

    public static function checkbox(string $question, string $supplement, array $choices, bool $required, int $min_select = 0, int $max_select = 0){
        if ($max_select == 0){
            $max_select = count($choices);
        }

        echo "<div>";
        echo "<h4>{$question}</h4>";
        echo "<p>{$supplement}</p>";

        if ($required == true){
            if ($min_select == 0){
                $min_select = 1;
            }

            foreach ($choices as $choice){
                echo "<span style=\"display: block;\"><input type=\"checkbox\" value=\"{$choice}\" required>{$choice}</span>";
            }
        } else {
            foreach ($choices as $choice){
                echo "<span style=\"display: block;\"><input type=\"checkbox\" value=\"{$choice}\">{$choice}</span>";
            }
        }
    }
}