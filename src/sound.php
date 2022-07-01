<?php
namespace penguin_syan\php_form_4_expt;

/**
 * 音データを扱う関数があるクラス
 * 
 * @access public
 * @copyright 2022 HSSLab.
 */
class Sound{

    /**
     * セクションを用いて音データを再生するための関数
     * 
     * @param string|array $filepass 音データのファイルパス
     * @param int $max_play 音データの最大再生可能回数
     * @return array セクション用関数の実行に必要な関数名及び引数の情報
     */
    public function sound_array(string|array $filepass, int $max_play) {
        return ['sound', $filepass, $max_play];
    }
    
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
     * @see https://gray-code.com/javascript/view-playback-position-of-audio/
     */
    
    public function sound(string|array $filepass, int $max_play){
        // $filepassの型がstringとarrayの場合があるため，$filepassが配列かどうかを判定
        if (is_array($filepass)) {
            // 音データの表示順序をランダムにするため，配列の中身をランダムに並び替え
            shuffle($filepass);
            // 音データの数だけfor文を回して<audio>タグを出力するため，$filepass配列の要素数を$sound_numberに代入
            $sound_number = count($filepass);
            
            // 本関数を複数使用した場合にclassの競合を回避するため，ユニークIDを設定
            $play_class = uniqid("play_", mt_rand());
            $stop_class = uniqid("stop_", mt_rand());
            
            // 音データファイルの数だけidを設定するため，IDを初期化
            $audio_id = array();
            $play_id = array();
            $stop_id = array();
            $playback_id = array();
            $end_id = array();
            $progress_id = array();
            
            // 音データの数だけaudioタグ，再生ボタン，一時停止ボタン，シークバーを出力
            for ($i = 0; $i < $sound_number; $i++){
                // 本関数を複数使用した場合にidの競合を回避するため，ユニークIDを設定
                $audio_id[] = uniqid("audio_", mt_rand());
                $play_id[] = uniqid("play_", mt_rand());
                $stop_id[] = uniqid("stop_", mt_rand());
                $playback_id[] = uniqid("playback_", mt_rand());
                $end_id[] = uniqid("end_", mt_rand());
                $progress_id[] = uniqid("progress_", mt_rand());
                
                echo "<div><audio id=\"{$audio_id[$i]}\" controlslist=\"nodownload\" src=\"" . $filepass[$i] . "\"></audio></div>";
                echo "<button class=\"{$play_class}\" id=\"{$play_id[$i]}\" type=\"button\">再生</button>";
                echo "<button class=\"{$stop_class}\" id=\"{$stop_id[$i]}\" type=\"button\">一時停止</button>";
                echo "<p><time id=\"{$playback_id[$i]}\">0:00</time><input type=\"range\" id=\"{$progress_id[$i]}\" value=\"0\" min=\"0\" step=\"1\" disabled><time id=\"{$end_id[$i]}\">0:00</time></p>";
            }
            
            echo <<<EOM
                <script type="text/javascript">
            
                // 以下，<audio>タグを再生・一時停止ボタンで操作するための関数を記述
                window.addEventListener('DOMContentLoaded', function(){
                
                // @param array play_elements 再生ボタンの要素配列
                // @param array stop_elements 一時停止ボタンの要素配列
                // 音データを再生中に，他の音データを同時再生させないように，
                // 各ボタンの"disabled"（使用可否）を操作するため，各ボタンの要素をclass名から取得している．
                const play_elements = document.getElementsByClassName("{$play_class}");
                const stop_elements = document.getElementsByClassName("{$stop_class}"); 
                
                // @param array play_times 現在の再生回数
                var play_times = Array({$sound_number});
                play_times.fill(0);
                EOM;
                
                for ($i = 0; $i < $sound_number; $i++){
                    echo <<<EOM
                    const audio_element{$i} = document.getElementById("{$audio_id[$i]}");
                    const btn_play{$i} = document.getElementById("{$play_id[$i]}");
                    const btn_pause{$i} = document.getElementById("{$stop_id[$i]}");
                    const playback_position{$i} = document.getElementById("{$playback_id[$i]}");
                    const end_position{$i} = document.getElementById("{$end_id[$i]}");
                    const slider_progress{$i} = document.getElementById("{$progress_id[$i]}");                            
                    
                    var play_timer{$i} = null;                
                    
                    // 再生開始したときに実行
                    const startTimer{$i} = function(){
                        play_timer{$i} = setInterval(function(){
                            playback_position{$i}.textContent = convertTime(audio_element{$i}.currentTime);
                            slider_progress{$i}.value = Math.floor( (audio_element{$i}.currentTime / audio_element{$i}.duration) * audio_element{$i}.duration);
                        }, 100);
                    };
                    
                    // 停止したときに実行
                    const stopTimer{$i} = function(){
                        clearInterval(play_timer{$i});
                        playback_position{$i}.textContent = convertTime(audio_element{$i}.currentTime);
                    };
                    
                    // 音声ファイルの再生準備が整ったときに実行
                    audio_element{$i}.addEventListener('loadeddata', (e)=> {
                        slider_progress{$i}.max = Math.floor(audio_element{$i}.duration);
                        
                        playback_position{$i}.textContent = convertTime(audio_element{$i}.currentTime);
                        end_position{$i}.textContent = convertTime(audio_element{$i}.duration);
                    });
                    
                    // 音声ファイルが最後まで再生されたときに実行
                    // 再生上限回数に満たした時，再生・一時停止ボタンが押せなくなる
                    // 他の音声の再生ボタン，一時停止ボタンが使用可能に
                    audio_element{$i}.addEventListener("ended", e => {
                        stopTimer{$i}();
                        slider_progress{$i}.value = audio_element{$i}.duration;
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
            // 本関数を複数使用した場合にIDの競合を回避するため，ユニークIDを設定．
            $audio_id = uniqid("audio_", mt_rand());
            $play_id = uniqid("play_", mt_rand());
            $stop_id = uniqid("stop_", mt_rand());
            $playback_id = uniqid("playback_", mt_rand());
            $end_id = uniqid("end_", mt_rand());
            $progress_id = uniqid("progress_", mt_rand());
            
            echo "<div><audio id=\"{$audio_id}\" controlslist=\"nodownload\" src=\"" . $filepass . "\"></div>";
            echo "<button id=\"{$play_id}\" type=\"button\">再生</button>";
            echo "<button id=\"{$stop_id}\" type=\"button\">一時停止</button>";
            echo "<p><time id=\"{$playback_id}\">0:00</time><input type=\"range\" id=\"{$progress_id}\" value=\"0\" min=\"0\" step=\"1\" disabled><time id=\"{$end_id}\">0:00</time></p>";
            
            echo <<<EOM
            <script type="text/javascript">
            
            window.addEventListener('DOMContentLoaded', function(){            
                const audio_element = document.getElementById("$audio_id");
                const btn_play = document.getElementById("{$play_id}");
                const btn_pause = document.getElementById("{$stop_id}");
                const playback_position = document.getElementById("{$playback_id}");
                const end_position = document.getElementById("{$end_id}");
                const slider_progress = document.getElementById("{$progress_id}");
                
                var play_timer = null;
                // @param array play_times 現在の再生回数
                var play_times = 0;
                
                // 再生開始したときに実行
                const startTimer = function(){
                    play_timer = setInterval(function(){
                        playback_position.textContent = convertTime(audio_element.currentTime);
                        slider_progress.value = Math.floor( (audio_element.currentTime / audio_element.duration) * audio_element.duration);
                    }, 100);                          
                };
                
                // 停止したときに実行
                const stopTimer = function(){
                    clearInterval(play_timer);
                    playback_position.textContent = convertTime(audio_element.currentTime);
                };
                
                // 音声ファイルの再生準備が整ったときに実行
                audio_element.addEventListener('loadeddata', (e)=> {
                    slider_progress.max = Math.floor(audio_element.duration);
                    
                    playback_position.textContent = convertTime(audio_element.currentTime);
                    end_position.textContent = convertTime(audio_element.duration);
                });
                
                // 音声ファイルが最後まで再生されたときに実行
                audio_element.addEventListener("ended", e => {
                    stopTimer();
                    slider_progress.value = audio_element.duration;
                    play_times += 1;
                    
                    if (play_times >= {$max_play}) {
                        btn_play.setAttribute("disabled", true);
                        btn_pause.setAttribute("disabled", true);
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
}