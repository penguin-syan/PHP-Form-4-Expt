<?php
namespace penguin_syan\php_form_4_expt;

/**
 * 自由記述形式の質問を出力する関数を扱うクラス
 * 
 * @access public
 * @copyright 2022 HSSLab
*/

require_once "./InputTextType.php";

class Textbox{
/**
 * 自由記述形式の質問を出力する関数
 *
 * ユーザが質問形式に応じて入力を行うテキストボックスを出力する関数．
 * 引数として質問文，補足文，テキストボックスの入力形式，最大入力可能文字数，回答必須の有無，最小入力条件文字数（任意）を与える．
 * テキストボックスの入力形式には以下の5種類がある．
 * InputTextType::INTEGER（整数）
 * InputTextType::DECIMAL（小数）
 * InputTextType::ALPHABET（英字）
 * InputTextType::ALPHANUMERICAL（英数字）
 * InputTextType::ARBITRARY（任意の文字列）
 * テキストボックスに入力する際，入力形式・最大入力可能文字数・最小入力条件文字数に反した場合，テキストボックスの下にエラー文が表示される．
 *
 * @param string $question 質問文
 * @param string $supplement 補足文
 * @param int $type テキストボックスの入力形式
 * @param float $max_length 最大入力可能文字数
 * @param boolean $required 回答必須の有無
 * @param float $min_length 最小入力条件文字数
 * @see ./InputTextType.php: InputTextTypeクラスを呼び出し
 * @throws $max_lengthと$min_lengthの型にdoubleではなくfloatを使用しているためか，入力形式が少数で例えば数値範囲が5~10とした場合，
 * 　　　　「4.9」や「10.1」と入力した場合にはエラーが出るが「4.9999999999999」や「10.00000000000001」と入力すると切り上げ・切り捨てによる誤差は発生しエラーが出ない．
 * @todo 入力された文字列に対するエスケープ処理には未対応
 */
    public function textbox(string $question, string $supplement, int $type, float $max_length, bool $required, float $min_length = 0){
        echo "<div>";
        echo "<h4>{$question}</h4>";
        echo "<p>{$supplement}</p>";

        // 本関数を複数利用した際idが競合しないようにするため，ユニークidを生成
        $textbox_id = uniqid("textarea_", mt_rand());
        $attention_id = uniqid("attention_", mt_rand());

        switch ($type){
            case 0:
                echo "<input id=\"{$textbox_id}\" type=\"number\" step=\"1\" max=\"{$max_length}\" min=\"{$min_length}\" placeholder=\"整数値{$min_length}～{$max_length}以内\" style=\"font-size:12pt; width:380pt;\">";
                break;
            
            case 1:
                echo "<input id=\"{$textbox_id}\" type=\"number\" max=\"{$max_length}\" min=\"{$min_length}\" placeholder=\"{$min_length}～{$max_length}以内の数値\" style=\"font-size:12pt; width:380pt;\">";
                break;
            
            // 引数に最小入力条件文字数を与えた場合のみ，inputタグにminlengthを設定（case3,4においても同様）
            case 2:
                if ($min_length > 0){
                    echo "<input id=\"{$textbox_id}\" type=\"text\" size=\"60\" pattern=\"^[A-Za-z]+$\" maxlength=\"{$max_length}\" minlength=\"{$min_length}\" placeholder=\"{$min_length}～{$max_length}文字以内 半角英字のみ\" style=\"font-size:12pt\";>";
                } else {
                    echo "<input id=\"{$textbox_id}\" type=\"text\" size=\"60\" pattern=\"^[A-Za-z]+$\" maxlength=\"{$max_length}\" placeholder=\"{$max_length}文字以内 半角英字のみ\" style=\"font-size:12pt\";>";
                }
                break;
            
            case 3:
                if ($min_length > 0){
                    echo "<input id=\"{$textbox_id}\" type=\"text\" size=\"60\" pattern=\"^[0-9a-zA-Z]+$\" maxlength=\"{$max_length}\" minlength=\"{$min_length}\" placeholder=\"{$min_length}～{$max_length}文字以内 半角英数字のみ\" style=\"font-size:12pt\";>";
                } else {
                    echo "<input id=\"{$textbox_id}\" type=\"text\" size=\"60\" pattern=\"^[0-9a-zA-Z]+$\" maxlength=\"{$max_length}\" placeholder=\"{$max_length}文字以内 半角英数字のみ\" style=\"font-size:12pt\";>";
                }
                break;

            case 4:
                // textareaの横幅が全角32文字分であるため，最大文字数（$max_length）に応じて縦に何行必要かを計算
                $rows = ceil($max_length / 32);                  

                if ($min_length > 0){
                    echo "<textarea id=\"{$textbox_id}\" cols=\"62\" rows=\"{$rows}\" maxlength=\"{$max_length}\" minlength=\"{$min_length}\" placeholder=\"{$min_length}～{$max_length}文字以内\" style=\"resize: none; font-size:12pt;\"></textarea>";
                } else {
                    echo "<textarea id=\"{$textbox_id}\" cols=\"62\" rows=\"{$rows}\" maxlength=\"{$max_length}\" placeholder=\"{$max_length}文字以内\" style=\"resize: none; font-size:12pt;\"></textarea>";
                }
                break;
        }

        // 入力が間違っていた場合にエラー文を表示するため，表示用のブロックエリア（<div>）と太字（<b>）を設定
        echo "<b><div id=\"{$attention_id}\" style=\"color:red\";\"></div></b>";   
        echo "</div>";

        // テキストボックス下に必要に応じて注意文やエラー文を表示するため，以下にjavascriptを記述
        echo <<<EOM
                <script type="text/javascript">            
                window.addEventListener('DOMContentLoaded', function(){
                    const textbox = document.getElementById("{$textbox_id}");
                    const attention_text = document.getElementById("{$attention_id}");                            
        EOM;

        // 入力が必須（required）であった場合，input・textareaタグにrequired属性を追加し，テキストボックスの下に注意文を追加
        if ($required == true){
            echo <<<EOM
                textbox.required = true;
                var new_element = document.createElement("span");
                var new_content = document.createTextNode("※入力必須");
                new_element.appendChild(new_content);
                attention_text.appendChild(new_element);                     
            EOM;
        }

        // 入力エラー文を表示するため，入力形式ごとにキーボードを入力した際のイベントを設定
        switch ($type){
            case 0:
                $format_error = uniqid("format_", mt_rand());
                $count_error = uniqid("count_", mt_rand());
                echo <<<EOM
                    textbox.addEventListener("input",function(){
                        format_element = document.getElementById("{$format_error}");
                        count_element = document.getElementById("{$count_error}");

                        // 小数が入力された際にエラー文を表示
                        if (textbox.value.lastIndexOf('.') != -1){                                    
                            if (format_element == null){                                        
                                var new_element = document.createElement("span");
                                var new_content = document.createTextNode("※整数をご入力ください");
                                new_element.appendChild(new_content);
                                new_element.setAttribute("id", "{$format_error}");
                                new_element.style.display = "block";
                                attention_text.appendChild(new_element);
                            }
                        // 正しく入力を行った場合にエラー文を消去
                        } else {
                            if (format_element != null){
                                format_element.remove();
                            }
                        }

                        // 数値が指定範囲内でなかった場合にエラー文を表示
                        if (textbox.value != "" && (textbox.value > $max_length || textbox.value < $min_length)){
                            if (count_element == null){   
                                var new_element = document.createElement("span");
                                var new_content = document.createTextNode("※整数値{$min_length}～{$max_length}以内をご入力ください");
                                new_element.appendChild(new_content);
                                new_element.setAttribute("id", "{$count_error}");
                                new_element.style.display = "block";
                                attention_text.appendChild(new_element);
                            }                               
                        } else {
                            if (count_element != null){
                                count_element.remove();
                            }
                        }
                    });
                EOM;
                break;
            
            case 1:
                $count_error = uniqid("count_", mt_rand());
                echo <<<EOM
                    textbox.addEventListener("input",function(){
                        count_element = document.getElementById("{$count_error}");

                        // 数値が指定範囲内でなかった場合にエラー文を表示
                        if (textbox.value != "" && (textbox.value > $max_length || textbox.value < $min_length)){
                            if (count_element == null){   
                                var new_element = document.createElement("span");
                                var new_content = document.createTextNode("※{$min_length}～{$max_length}以内の値をご入力ください");
                                new_element.appendChild(new_content);
                                new_element.setAttribute("id", "{$count_error}");
                                new_element.style.display = "block";
                                attention_text.appendChild(new_element);
                            }                               
                        } else {
                            if (count_element != null){
                                count_element.remove();
                            }
                        }
                    });
                EOM;
                break;

            case 2:
                $format_error = uniqid("format_", mt_rand());
                $count_error = uniqid("count_", mt_rand());
                echo <<<EOM
                    textbox.addEventListener("input",function(){
                        format_element = document.getElementById("{$format_error}");
                        count_element = document.getElementById("{$count_error}");

                        // 英字以外が入力された場合にエラー文を表示
                        if (textbox.value != "" && textbox.value.match("^[A-Za-z]+$") == null){                                    
                            if (format_element == null){                                        
                                var new_element = document.createElement("span");
                                var new_content = document.createTextNode("※半角英字のみをご入力ください");
                                new_element.appendChild(new_content);
                                new_element.setAttribute("id", "{$format_error}");
                                new_element.style.display = "block";
                                attention_text.appendChild(new_element);
                            }
                        } else {
                            if (format_element != null){
                                format_element.remove();
                            }
                        }

                        // 文字数が指定範囲内でなかった場合にエラー文を表示
                        if (textbox.value != "" && textbox.value.length < $min_length){
                            if (count_element == null){   
                                var new_element = document.createElement("span");
                                var new_content = document.createTextNode("※{$min_length}文字以上をご入力ください");
                                new_element.appendChild(new_content);
                                new_element.setAttribute("id", "{$count_error}");
                                new_element.style.display = "block";
                                attention_text.appendChild(new_element);
                            }                               
                        } else {
                            if (count_element != null){
                                count_element.remove();
                            }
                        }
                    });
                EOM;
                break;

            case 3:
                $format_error = uniqid("format_", mt_rand());
                $count_error = uniqid("count_", mt_rand());
                echo <<<EOM
                    textbox.addEventListener("input",function(){
                        format_element = document.getElementById("{$format_error}");
                        count_element = document.getElementById("{$count_error}");

                        // 英数字以外が入力された場合にエラー文を表示
                        if (textbox.value != "" && textbox.value.match("^[0-9a-zA-Z]+$") == null){                                    
                            if (format_element == null){                                        
                                var new_element = document.createElement("span");
                                var new_content = document.createTextNode("※半角英数字のみをご入力ください");
                                new_element.appendChild(new_content);
                                new_element.setAttribute("id", "{$format_error}");
                                new_element.style.display = "block";
                                attention_text.appendChild(new_element);
                            }
                        } else {
                            if (format_element != null){
                                format_element.remove();
                            }
                        }

                        // 文字数が指定範囲内でなかった場合にエラー文を表示
                        if (textbox.value != "" && textbox.value.length < $min_length){
                            if (count_element == null){   
                                var new_element = document.createElement("span");
                                var new_content = document.createTextNode("※{$min_length}文字以上をご入力ください");
                                new_element.appendChild(new_content);
                                new_element.setAttribute("id", "{$count_error}");
                                new_element.style.display = "block";
                                attention_text.appendChild(new_element);
                            }                               
                        } else {
                            if (count_element != null){
                                count_element.remove();
                            }
                        }
                    });
                EOM;
                break;
            
            case 4:
                $count_error = uniqid("count_", mt_rand());
                echo <<<EOM
                    textbox.addEventListener("input",function(){
                        count_element = document.getElementById("{$count_error}");

                        // 文字数が指定範囲内でなかった場合にエラー文を表示
                        if (textbox.value != "" && textbox.value.length < $min_length){
                            if (count_element == null){
                                var new_element = document.createElement("span");
                                var new_content = document.createTextNode("※{$min_length}文字以上ご入力ください");
                                new_element.appendChild(new_content);
                                new_element.setAttribute("id", "{$count_error}");
                                new_element.style.display = "block";
                                attention_text.appendChild(new_element);
                            }                               
                        } else {
                            if (count_element != null){
                                count_element.remove();
                            }
                        }
                    });                            
                EOM;
                break;                                        
        }                                   
            echo <<<EOM
                });
                </script>
            EOM;               
    }

    public function textbox_array(string $question, string $supplement, int $type, float $max_length, bool $required, float $min_length = 0){
        return ["textbox", $question, $supplement, $type, $max_length, $required, $min_length];
    }
}