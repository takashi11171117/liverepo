<?php
namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

require 'recipe/laravel.php';
require 'recipe/yarn.php';

// Project name
set('application', 'liverepo');

// Project repository
set('repository', 'git@bitbucket.org:asupara7/liverepo.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

set('branch', 'master');

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('206.189.91.142')
    ->stage('staging')
    ->user('saito')
    ->port(10022)
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->identityFile('~/.ssh/degitalocean')
    ->set('deploy_path', '/var/www/liverepo-demo');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');
before('deploy:symlink', 'artisan:cache:clear');
before('deploy:symlink', 'artisan:config:cache');
after('deploy:update_code', 'yarn:install');

before('deploy:shared','upload:env');
task('upload:env', function () {
    $stage = get('stage');
    if ($stage === 'production') {
        upload('.env.production', '{{deploy_path}}/shared/.env');
    } else if ($stage === 'staging') {
        upload('.env.staging', '{{deploy_path}}/shared/.env');
    }
})->desc('.envをアップロード');

