<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

global $Users;
$Users->facebook_login();
$Users->linked_login();
$Users->google_login();
echo ($Users->users_msg) ? $Users->users_msg . '<div class="clear-10"></div>' : '';

