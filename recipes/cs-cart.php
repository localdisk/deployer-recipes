<?php

require 'recipe/common.php';

// writable dirs
set('writable_dirs', [
    'cscart/design',
    'cscart/images',
    'cscart/var',
]);

// shared file
set('shared_files', ['cscart/config.local.php']);

// cache clear
task('cs-cart:cleanup', function () {
    $current  = env('current');
    $cacheDir = $current . '/cscart/var/cache';
    run("if [ -d $(echo $cacheDir) ]; then rm -rf $cacheDir/*; fi");
})->desc('Cache cleanup.');

// initialize set up. copy config.local.php
task('cs-cart:init', function() {
    $configPath = "{{deploy_path}}/shared/cscart";
    run("mkdir -p $configPath");
    run("if [ ! -f $(echo $configPath/config.local.php) ]; then cp {{release_path}}/cscart/config.local.php $configPath/config.local.php; fi");
    run("chmod 666 $configPath/config.local.php");

});

// main
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'cs-cart:init',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
])->desc('Deploy your project');
after('deploy', 'success');
