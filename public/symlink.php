<?php
$target = dirname(__DIR__) . '/storage';
$link = __DIR__ . '/storage';

if (symlink($target, $link)) {
    echo "Symlink created successfully.";
} else {
    echo "Failed to create symlink.";
}
?>