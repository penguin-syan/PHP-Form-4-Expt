<?php
namespace penguin_syan\php_form_4_expt;

/**
 * 動画を表示するための関数
 * 
 * リッカート尺度を用いた質問を実装する関数．
 * 引数として渡された質問文，補足文を表示する．
 * また、引数として渡された回答の選択肢をラジオボタンで表示する。
 * 引数に従って，inputタグにrequiredの指定を行う．
 * 
 * 
 *
 * @param string $question 質問文
 * @param string $supplement 補足文
 * @param array $choices 回答の選択肢
 * @param bool $required 回答の必須有無
 */
function likert_scale(string $question,string $supplement,array $choices,bool $required) {
    if ($required){
        $req = "required";
    } else {
        $req = "";
    }
    echo "<div class='question'>";
    echo "<p>$question</p>";
    echo "<p>$supplement</p>";
    echo "<div style= 'display: flex;' class = 'radioButtons'>";
    $radioId = uniqid();
    for ($i = 0; $i < count($choices); $i++){
        echo "<div style= 'text-align: center;padding: 10px;'class='choices'>";
        echo "<div>";
        echo "<input type='radio' name='$radioId' id='$radioId-$i' value='$choices[$i]' $req>"; 
        echo "</div>";
        echo "<div>";
        echo "<label for='$radioId-$i'>$choices[$i]</label>";        
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
}