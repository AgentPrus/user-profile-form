<?php
function writeLog($file, $logMessage)
{
    $fp = fopen($file, "a");
    $message = date('d.m.Y - H:i ') . $logMessage . "\r\n";
    fwrite($fp, $message);
    fclose($fp);
}
