<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

error_reporting(E_ALL);


// اتصال به دیتابیس
define('DB_Name', ''); // نام دیتابیس
define('DB_User', ''); // نام کاربری دیتابیس
define('DB_Password', ''); // کلمه عبور دیتابیس
define('DB_Host', 'localhost'); // DB Server Name
define('DB_Charset', 'utf8'); // DB Charset Type
define('DB_autoreset', TRUE); // DB Autoreset
///
// Available = [English, Française, Español, italiana, Deutsch, Nederlandse, português, русский, Türk, عربي, فارسي]
define('Language', 'fa'); //->Set your Default Language [en, fr, es, it, de, nl, pr, ru, tr, ar, fa]

define('Debug', TRUE);
