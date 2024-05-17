<?php
    $target = '../storage/app/public';
    $link = 'storage';

    if (symlink($target, $link)) {
        echo 'Symbolic link created successfully.';
    } else {
        echo 'Failed to create symbolic link.';
    }
?>
