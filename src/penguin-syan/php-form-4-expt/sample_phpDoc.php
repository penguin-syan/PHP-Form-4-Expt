<?php
/**
 *  関数の概要
 *
 * @param int $id ユーザID
 * @param string $name ユーザ名
 * @return string 入力されたユーザIDとユーザ名を出力
 */
function sample_func(int $id, string $name){
    return "ユーザIDが".$id."の人は".$name."さんです．";
}