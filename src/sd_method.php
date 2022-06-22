<?php
namespace penguin_syan\php_form_4_expt;

/**
 * SD法による質問を出力する関数
 *
 * 本関数を使用するとSD法による質問が生成される．
 * 引数として質問文，補足文，尺度，形容対，回答必須の有無が必要．
 * 尺度の数によって，一つの形容詞対に対するラジオボタンの生成数が決まる．
 * 形容対は配列で入力する必要がある．（例：[["自然な", "人工的な"], ["明るい", "暗い"]]）
 * 回答必須の有無はboolean型の引数であり，trueの場合に回答が必須となる．
 * 
 * @param string $question 質問文
 * @param string $supplement 補足文
 * @param int $answer_step 尺度
 * @param array $label 形容詞対
 * @param bool $required 回答必須の有無
 * @param string $radio_name input（radio）タグのname
 */
function sd_method(string $question, string $supplement, int $answer_step, array $label, bool $required){
    echo "<div>";
    echo "<h4>{$question}</h4>";
    echo "<p class=\"Qsup\">{$supplement}</p>";                

    // 形容詞対が一次配列もしくは二次配列の場合があるため，先頭要素がさらに配列かどうかを判定
    if (is_array($label[0]) == false){
        // 本関数を複数利用する際にnameの競合を避けるため，ユニークIDを生成
        $radio_name = uniqid("radio_", mt_rand());

        echo $label[0];
        for ($i = 1; $i <= $answer_step; $i++){       
            if ($required == true){                                
                echo "<input type=\"radio\" name=\"{$radio_name}\" value=\"{$i}\" required>";
            } else {
                echo "<input type=\"radio\" name=\"{$radio_name}\" value=\"{$i}\">";
            }
        }
        echo $label[1];

    } else {
        foreach ($label as $index => $label_one){
            // 本関数を複数利用する際にnameの競合を避けるため，ユニークIDを生成
            $radio_name = uniqid("radio_", mt_rand());

            echo "<p>{$label_one[0]}";
            for ($i = 1; $i <= $answer_step; $i++){                   
                if ($required == true){                     
                    echo "<input type=\"radio\" name=\"{$radio_name}\" value=\"{$i}\" required>";
                } else {
                    echo "<input type=\"radio\" name=\"{$radio_name}\" value=\"{$i}\">";
                }
            }
            echo "{$label_one[1]}</p>";
        }
    }

    echo "</div>";
}
