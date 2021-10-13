<?php
namespace Deployer;


// Project name
set('application', 'my_project');

// Project repository
set('repository', 'git@github.com:tarikhagustia/bfx-web-report.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('dash.bullishfx.id')
    ->user('dev_bfx')
    ->set('deploy_path', '/home/dev_bfx/web/report-dev.bullishfx.id/public_html');

// Tasks
task('deploy', function () {
    cd(get('deploy_path'));
    $output = run('git pull && composer install && php artisan optimize');
    writeln($output);
});
