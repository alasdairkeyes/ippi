<?php

namespace App\Utils;


    /**
     * Returns a non-crypto secure random string
     *
     * @param int $length Length of string
     * @param string optional characters to use
     * @return string
     */

    function randomString($length = 10, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    /**
     * Returns a non-crypto secure password
     *
     * @param int $length Length of string
     * @param string optional characters to use
     * @return string
     */

    function randomPassword($length = 10, $characters = '23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ!$%^&*()-_=+[]{}#~,.<>?') {
        return randomString($length, $characters);
    }


    /**
     * Validates a hostname
     *
     * @param string $hostname Hostname to check
     * @return bool
     */
    function validHostname($hostname) {
        if (preg_match('/^(?=.{1,255}$)[0-9A-Za-z](?:(?:[0-9A-Za-z]|-){0,61}[0-9A-Za-z])?(?:\.[0-9A-Za-z](?:(?:[0-9A-Za-z]|-){0,61}[0-9A-Za-z])?)*\.?$/', $hostname)) {
            return true;
        }
        return false;
    }

?>
