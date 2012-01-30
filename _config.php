<?php

/**
 *
 * Every deployment gets different credentials for each Add-on. Providers
 * can change these credentials at any time. It is therefor required to read
 * the credentials from the provided JSON file to keep the application running
 * in case the credentials change.
 *
 * The path to the JSON file can be found in the CRED_FILE environment variable.
 *
 */

# read the credentials file
$string = file_get_contents($_ENV['CRED_FILE'], false);
if ($string == false) {
    die('FATAL: Could not read credentials file');
}

# the file contains a JSON string, decode it and return an associative array
$creds = json_decode($string, true);

# use credentials to set the configuration for MySQL
$config = array(
    'MYSQL_HOSTNAME' => $creds['MYSQLS']['MYSQLS_HOSTNAME'],
    'MYSQL_DATABASE' => $creds['MYSQLS']['MYSQLS_DATABASE'],
    'MYSQL_USERNAME' => $creds['MYSQLS']['MYSQLS_USERNAME'],
    'MYSQL_PASSWORD' => $creds['MYSQLS']['MYSQLS_PASSWORD']
);

?>
