<?php

namespace Deployer;

//set('default_selector', 'prod');

/*************
 * Prod Deploy
 *************/

require 'recipe/composer.php';

set('repository', 'git@github.com:TiiFuchs/satisfactory-savegame-provider.git');

add('shared_files', ['.env']);

host('prod')
    ->setHostname('satisfactory.tii.one')
    ->setRemoteUser('www-data')
    ->setDeployPath('~/html');

/************************
 * Local Docker Shortcuts
 ************************/

set('docker_image', 'tiifuchs/satisfactory-savegame-provider');
set('docker_run_name', 'satisfactory-savegame-provider-dev');
set('savegame_dir', '/Users/tii/Library/Containers/com.isaacmarovitz.Whisky/Bottles/BA9B9F4C-A2E5-4876-A71A-DBE7E0890114/drive_c/users/crossover/AppData/Local/FactoryGame/Saved/SaveGames/76561198025164260');

desc('Stop Running Docker Image');
task('stop', function () {
    runLocally('docker stop {{docker_run_name}} || true');
});

desc('Builds Docker Image');
task('build', function () {
    runLocally('docker build -t {{docker_image}}:dev -f docker/Dockerfile .');
})->verbose();

task('start', function () {
    runLocally('docker run --rm --name {{docker_run_name}} -d -p 8000:8000 -v {{savegame_dir}}:/saves -v ./:/app {{docker_image}}:dev');
})->hidden();

desc('Run Docker Container Locally');
task('dev', [
    'build',
    'stop',
    'start',
]);
