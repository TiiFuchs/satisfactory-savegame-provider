<?php

namespace Deployer;

localhost()
    ->set('savegame_dir', '/Users/tii/Library/Containers/com.isaacmarovitz.Whisky/Bottles/BA9B9F4C-A2E5-4876-A71A-DBE7E0890114/drive_c/users/crossover/AppData/Local/FactoryGame/Saved/SaveGames/76561198025164260');

set('docker_image', 'tiifuchs/satisfactory-savegame-provider');
set('docker_run_name', 'satisfactory-savegame-provider-dev');

desc('Stop Running Docker Image');
task('stop', function () {
    run('docker stop {{docker_run_name}} || true');
});

desc('Builds Docker Image');
task('build', function () {
    run('docker build -t {{docker_image}}:dev -f docker/Dockerfile .', timeout: null);
})->verbose();

desc('Run Docker Container Locally');
task('start', function () {
    run('docker run --rm --name {{docker_run_name}} -d -p 8000:8000 -v {{savegame_dir}}:/saves -v ./:/app {{docker_image}}:dev');
})
    ->addBefore('stop')
    ->addBefore('build');
