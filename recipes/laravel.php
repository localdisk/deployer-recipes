<?php

require 'recipe/common.php';

// Laravel shared dirs
set('shared_dirs', [
    'storage/app',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

// Laravel 5 shared file
set('shared_files', ['.env']);

// Laravel writable dirs
set('writable_dirs', ['storage', 'vendor']);

// migrate
task('database:migrate', function () {
    run('php {{release_path}}/' . 'artisan migrate');
})->desc('Migrate database');

// optimize
task('deploy:optimize', function () {
    run('php {{release_path}}/' . 'artisan optimize');
    run('php {{release_path}}/' . 'artisan route:cache');
    run('php {{release_path}}/' . 'artisan config:cache');
})->desc('Optimize Application');

// deploy task
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:vendors',
    'deploy:shared',
    'deploy:writable',
    'deploy:copyenv',
    'deploy:optimize',
    'deploy:symlink',
])->desc('Deploy your project');
after('deploy', 'success');