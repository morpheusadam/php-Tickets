<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

require_once (dirname(__file__) . '/controller/core.php');
$Run_Theme = new Run_Theme();
$Run_Theme->theme_functions();
$Run_Theme->run_themeIndex();
