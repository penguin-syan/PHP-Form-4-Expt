<?php
namespace penguin_syan\php_form_4_expt;

/**
 * テキストボックスの入力形式を指定する際のパラメータ用クラス
 * 
 * @access public
 * @copyright 2022 HSSLab
 */
class InputTextType {
    const INTEGER = 0;
    const DECIMAL = 1;
    const ALPHABET = 2;
    const ALPHANUMERICAL = 3;
    const ARBITRARY = 4;
}