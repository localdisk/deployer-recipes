<?php

require 'recipe/common.php';

// writable dirs
set('writable_dirs', [
    'cscart/design',
    'cscart/images',
    'cscart/var',
]);

// shared file
set('shared_files', ['config.local.php']);

task('cs-cart:cleanup', function () {
    $current  = env('current');
    $cacheDir = $current . '/cscart/var/cache';
    run("if [ -d $(echo $cacheDir) ]; then rm -rf $cacheDir/*; fi");
})->desc('Cache cleanup.');


// main
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
])->desc('Deploy your project');
after('deploy', 'success');
