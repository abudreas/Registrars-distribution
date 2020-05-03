<?php
ob_start();

include  __DIR__ . '/templates/contact.html.php';

$output = ob_get_clean();

include  __DIR__ . '/templates/layout.html.php';