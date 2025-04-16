<?php
echo "<pre>";
$output = shell_exec("bash extract_vendor.sh 2>&1");
echo $output;
echo "</pre>";
?>
