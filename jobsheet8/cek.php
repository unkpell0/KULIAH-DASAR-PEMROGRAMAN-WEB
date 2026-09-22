<?php
header('Content-Type: text/plain');
var_dump(getenv('DB_USER'));
var_dump(strlen((string) getenv('DB_PASS')));
var_dump(getenv('DB_PORT'), getenv('DB_NAME'), getenv('DB_SSLMODE'));