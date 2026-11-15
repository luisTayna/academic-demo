<?php

// Explicit loading works on Windows environments where is_readable() misreports ACLs.
require dirname(__DIR__).'/vendor/autoload.php';
exit((new PHPUnit\TextUI\Application())->run($_SERVER['argv']));
