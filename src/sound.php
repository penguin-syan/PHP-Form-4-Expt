<?php
namespace penguin_syan\php_form_4_expt;

/**
 * 音データを再生するための関数
 * 
 * 本関数は，音データのファイルパス，再生回数上限の値を引数として渡すと，
 * 音データを再生する<audio>タグと再生・一時停止ボタン，シークバーが出力される．
 * 音データのファイルパスを配列で複数渡した場合は，<audio>タグがランダムな順番で出力される．
 * 再生ボタンを押すと音声が再生される．
 * 一時停止ボタンを押すと再生されている音声が停止する．
 * 再生回数上限まで音声データを再生した場合，再生不可能となる．
 * 
 * @param string|array $filepass 音データのファイルパス
 * @param int $max_play 音データの最大再生可能回数
 * @param int $sound_number 音データの数
 * @see https://gray-code.com/javascript/view-playback-position-of-audio/
 */

function sound(string|array $filepass, int $max_play){
    // $filepassの型がstringとarrayの場合があるため，$filepassが配列かどうかを判定
    if (is_array($filepass)) {
        // 音データの表示順序をランダムにするため，配列の中身をランダムに並び替え
        shuffle($filepass);
        // 音データの数だけfor文を回して<audio>タグを出力するため，$filepass配列の要素数を$sound_numberに代入
        $sound_number = count($filepass);

        // 音データの数だけaudioタグ，再生ボタン，一時停止ボタン，シークバーを出力
        // javascriptで<audio>の処理を別々に分けるため，タグid名の最後にfor文の値{$i}を連結
        for ($i = 0; $i < $sound_number; $i++){
            echo "<div><audio id=\"sound{$i}\" controlslist=\"nodownload\" src=\"" . $filepass[$i] . "\"></div>";
            echo "<button class=\"play_button\" id=\"btn_play{$i}\">再生</button>";
            echo "<button class=\"stop_button\" id=\"btn_pause{$i}\">一時停止</button>";
            echo "<p><time id=\"playback_position{$i}\">0:00</time><input type=\"range\" id=\"progress{$i}\" value=\"0\" min=\"0\" step=\"1\" disabled><time id=\"end_position{$i}\">0:00</time></p>";
        }
        
        echo <<<EOM
            <script type="text/javascript">

            // 以下，<audio>タグを再生・一時停止ボタンで操作するための関数を記述
            window.addEventListener('DOMContentLoaded', function(){

            // @param array play_elements 再生ボタンの要素配列
            // @param array stop_elements 一時停止ボタンの要素配列
            // 音データを再生中に，他の音データを同時再生させないように，
            // 各ボタンの"disabled"（使用可否）を操作するため，各ボタンの要素をclass名から取得している．
            const play_elements = document.getElementsByClassName("play_button");
            const stop_elements = document.getElementsByClassName("stop_button"); 
            
            // @param array play_times 現在の再生回数
            var play_times = Array({$sound_number});
            play_times.fill(0);
        EOM;

        for ($i = 0; $i < $sound_number; $i++){
            echo <<<EOM
                const btn_play{$i} = document.getElementById("btn_play{$i}");
                const btn_pause{$i} = document.getElementById("btn_pause{$i}");
                const playback_position{$i} = document.getElementById("playback_position{$i}");
                const end_position{$i} = document.getElementById("end_position{$i}");
                const slider_progress{$i} = document.getElementById("progress{$i}");
                const audio_element{$i} = document.getElementById("sound{$i}");
                
                var play_timer{$i} = null;                
                
                // 再生開始したときに実行
                const startTimer{$i} = function(){
                    play_timer{$i} = setInterval(function(){
                    playback_position{$i}.textContent = convertTime(audio_element{$i}.currentTime);
                    slider_progress{$i}.value = Math.floor( (audio_element{$i}.currentTime / audio_element{$i}.duration) * audio_element{$i}.duration);
                    }, 500);
                };
                
                // 停止したときに実行
                const stopTimer{$i} = function(){
                    clearInterval(play_timer{$i});
                    playback_position{$i}.textContent = convertTime(audio_element{$i}.currentTime);
                };
                                
                // 音声ファイルの再生準備が整ったときに実行
                audio_element{$i}.addEventListener('loadeddata', (e)=> {
                    slider_progress{$i}.max = audio_element{$i}.duration;
                
                    playback_position{$i}.textContent = convertTime(audio_element{$i}.currentTime);
                    end_position{$i}.textContent = convertTime(audio_element{$i}.duration);
                });
                
                // 音声ファイルが最後まで再生されたときに実行
                // 再生上限回数に満たした時，再生・一時停止ボタンが押せなくなる
                // 他の音声の再生ボタン，一時停止ボタンが使用可能に
                audio_element{$i}.addEventListener("ended", e => {
                    stopTimer{$i}();
                    play_times[{$i}] += 1;
                    
                    for (let number = 0; number < {$sound_number}; number++){
                    if (play_times[number] >= {$max_play}) {
                        play_elements[number].setAttribute("disabled", true);
                        stop_elements[number].setAttribute("disabled", true);
                    } else {
                        play_elements[number].removeAttribute("disabled");
                        stop_elements[number].removeAttribute("disabled");
                    }
                    }
                    
                    //if (play_times{$i} >= {$max_play}) {
                    //  btn_play{$i}.setAttribute("disabled", true)
                    //  btn_pause{$i}.setAttribute("disabled", true)
                    //}
                    
                });
                
                // 再生ボタンが押されたときに実行され，音声が再生される
                // 他の音声の再生ボタン，一時停止ボタンが使用不可能となる
                btn_play{$i}.addEventListener("click", e => {
                    for (let number = 0; number < {$sound_number}; number++){
                    play_elements[number].setAttribute("disabled", true);
                    stop_elements[number].setAttribute("disabled", true);
                    }
                    play_elements[$i].removeAttribute("disabled");
                    stop_elements[$i].removeAttribute("disabled");
                    audio_element{$i}.play();
                    startTimer{$i}();                      
                });
                
                // 一時停止ボタンが押されたときに実行され，音声が一時停止される
                // 他の音声の再生ボタン，一時停止ボタンが使用可能となる
                btn_pause{$i}.addEventListener("click", e => {
                    for (let number = 0; number < {$sound_number}; number++){
                    play_elements[number].removeAttribute("disabled");
                    stop_elements[number].removeAttribute("disabled");
                    }
                    audio_element{$i}.pause();
                    stopTimer{$i}();
                });
            EOM;
        }   

        echo <<<EOM
            // 再生時間の表記を「mm:ss」に整える
            const convertTime = function(time_position) {
                
                time_position = Math.floor(time_position);
                var res = null;
            
                if( 60 <= time_position ) {
                res = Math.floor(time_position / 60);
                res += ":" + Math.floor(time_position % 60).toString().padStart( 2, '0');
                } else {
                res = "0:" + Math.floor(time_position % 60).toString().padStart( 2, '0');
                }
            
                return res;
            };

            });
            </script>
        EOM;

    } else {      
        echo "<div><audio controlslist=\"nodownload\" src=\"" . $filepass . "\"></div>";
        echo "<button id=\"btn_play\">再生</button>";
        echo "<button id=\"btn_pause\">一時停止</button>";
        echo "<p><time id=\"playback_position\">0:00</time><input type=\"range\" id=\"progress\" value=\"0\" min=\"0\" step=\"1\" disabled><time id=\"end_position\">0:00</time></p>";

        echo <<<EOM
        <script type="text/javascript">        

        window.addEventListener('DOMContentLoaded', function(){

        const btn_play = document.getElementById("btn_play");
        const btn_pause = document.getElementById("btn_pause");
        const playback_position = document.getElementById("playback_position");
        const end_position = document.getElementById("end_position");
        const slider_progress = document.getElementById("progress");
        const audio_element = document.querySelector("audio");
        
        var play_timer = null;
        // @param array play_times 現在の再生回数
        var play_times = 0;
        
        // 再生開始したときに実行
        const startTimer = function(){
            play_timer = setInterval(function(){
            playback_position.textContent = convertTime(audio_element.currentTime);
            slider_progress.value = Math.floor( (audio_element.currentTime / audio_element.duration) * audio_element.duration);
            }, 500);
        };
        
        // 停止したときに実行
        const stopTimer = function(){
            clearInterval(play_timer);
            playback_position.textContent = convertTime(audio_element.currentTime);
        };
        
        // 音声ファイルの再生準備が整ったときに実行
        audio_element.addEventListener('loadeddata', (e)=> {
            slider_progress.max = audio_element.duration;
        
            playback_position.textContent = convertTime(audio_element.currentTime);
            end_position.textContent = convertTime(audio_element.duration);
        });
        
        // 音声ファイルが最後まで再生されたときに実行
        audio_element.addEventListener("ended", e => {
            stopTimer();
            play_times += 1;

            if (play_times >= {$max_play}) {
            btn_play.setAttribute("disabled", true)
            btn_pause.setAttribute("disabled", true)
            }
        });
        
        // 再生ボタンが押されたときに実行
        btn_play.addEventListener("click", e => {
            audio_element.play();
            startTimer();
        });
        
        // 一時停止ボタンが押されたときに実行
        btn_pause.addEventListener("click", e => {
            audio_element.pause();
            stopTimer();
        });
                
        // 再生時間の表記を「mm:ss」に整える
        const convertTime = function(time_position) {
            
            time_position = Math.floor(time_position);
            var res = null;
        
            if( 60 <= time_position ) {
            res = Math.floor(time_position / 60);
            res += ":" + Math.floor(time_position % 60).toString().padStart( 2, '0');
            } else {
            res = "0:" + Math.floor(time_position % 60).toString().padStart( 2, '0');
            }
        
            return res;
        };

        });
    
        </script>
    EOM;
    }
}