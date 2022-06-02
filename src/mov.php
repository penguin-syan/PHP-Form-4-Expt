<?php
namespace penguin_syan\php_form_4_expt;

/**
 * 動画を表示するための関数
 * 
 * 本関数を使用すると，引数として渡された画像を<video>タグを用いて表示する．
 * この時，引数として渡されたパラメータをもとに画像のサイズを設定する．
 * また、引数として渡されたパラメータをもとに再生時に全画面サイズで表示を行う。
 * 引数として渡された画像のpassが配列の場合ランダムな順番で表示する．
 * 
 * 
 *
 * @param string|array $filePass 画像のpass
 * @param int $size 画像の大きさ
 * @param int $max_play 再生可能回数
 */

function video(string|array $filePass, int $size, int $max_play){
    switch ($size){
        case 0:
            $full = "false";
            $width = "45%";
            break;
        case 1:
            $full = "false";
            $width = "60%";
            break;
        case 2:
            $full = "false";
            $width = "80%";
            break;
        case 3:
            $full = "false";
            $width = "98%";
            break;
        case 4:
            $full = "true";
            $width = "45%";
            break;
        case 5:
            $full = "true";
            $width = "60%";
            break;
        case 6:
            $full = "true";
            $width = "80%";
            break;
    }
    
    echo "<div id='videoField'>";
    if (is_array($filePass)) {
        shuffle($filePass);
        $i = 0;
        foreach ($filePass as $file) {
            $max = $max_play;
            
            echo "<div id='video'>";
            echo "<video src=$file width=$width></video>";
            echo "<p id=$i class=playCount>再生可能回数：$max</p>";
            echo "<button id=$i class=playButton>再生</button>";
            echo "</div>";
            $i++;
        }
    } else {
        echo "<div id='video'>";
        echo "<video src=$filePass width=$width></video>";
        echo "<p>$max_play</p>";
        echo "<button>再生</button>";
        echo "</div>";
    }
    echo "</div>";

    echo <<<EOM
    <script type="text/javascript">
        window.onload = function(){
            let videoField = document.getElementById('videoField');
            videoField.oncontextmenu = function () {return true;}

            let cookie = document.cookie.split(';');
            let videos = document.querySelectorAll("#video");
            for (let i = 0; i < videos.length; i++){
                let video = videos[i].children[0];
                let p = videos[i].children[1];
                let btn = videos[i].children[2];
                let reload = false;
                let pNum = p.innerText.slice(-1);
                cookie.forEach(function(value) {
                    value = value.replace(/\s+/g, "");
                    let content = value.split('=');
                    if (content[0] == document.domain + String(i)) {
                        reload = true;
                        pNum = content[1];
                        console.log(pNum);
                    }
                })
                if (reload === false) {
                    document.cookie = document.domain + String(i) + '=' + p.innerText.slice(-1);
                }
                p.innerText = "再生可能回数："+ pNum;
                if (parseInt(pNum)<= 0){
                    btn.disabled = true;
                } else {
                    btn.disabled = false;
                }
                let clickFunc = function() {
                    pNum = parseInt(pNum) - 1;
                    if($full){
                        let width = video.style.width;
                        video.addEventListener("ended", function(){
                            if (parseInt(pNum) > 0){
                                btn.disabled = false;
                            }
                            video.style.width = width;
                        }, false);
                        video.style.width = '98%';
                    }
                    video.play();
                    btn.disabled = true;
                    document.cookie = document.domain + String(i) + '=' + pNum;
                    p.innerText = "再生可能回数："+ pNum;
                }
                btn.addEventListener("click",clickFunc);
            }
        }
    </script>
    EOM;
}