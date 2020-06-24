<?php

namespace App\Mail;

class MyMail {
    public static function send($to, $message, $subject) {

        $headers = "From: " . strip_tags('juliaokatal@gmail.com') . "\r\n";
        $headers .= "Reply-To: ". strip_tags('juliaokatal@gmail.com') . "\r\n";
        $headers .= "CC: juliaokatal@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if(mail($to, $subject, $message, $headers)) return true;
        return false;
    }
}