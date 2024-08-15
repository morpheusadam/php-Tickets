<?php

class db_config {

    public static $dbname = DB_Name; // Your database name
    public static $dbuser = DB_User; // Your database username
    public static $dbpass = DB_Password; // // Your database password
    public static $dbhost = DB_Host; // Your database host, 'localhost' is default.
    public static $dbencoding = DB_Charset; // Your database encoding, default is 'utf8'. Do not change, if not sure.
    public static $autoreset = DB_autoreset; // Auto-resets conditions when you try to set new (after some db action, true is recommended);

}
