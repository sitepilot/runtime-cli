<?php

use LaravelZero\Framework\Exceptions\ConsoleException;

test('generate config command', function () {
    $this->artisan('config:generate ./tests/Files/Templates ./storage/config --configFile ./tests/Files/config.yml --mergeFile ./tests/Files/merge.yml,./tests/Files/merge2.yml')
         ->assertExitCode(0);
    
    $this->assertTrue(file_exists('./storage/config/test-1.conf'));
    $this->assertTrue(file_exists('./storage/config/test-2.conf'));
    
    expect(file_get_contents('./storage/config/test-1.conf'))->toContain('nginxMaxRequestSize: 35');
    expect(file_get_contents('./storage/config/test-2.conf'))->toContain('nginxMaxRequestSize: 35');
});

test('invalid source location exception', function() {
    $this->expectException(ConsoleException::class);
    $this->artisan('config:generate ./tests/Files/Templates2 ./storage/config');
});

test('invalid destination location exception', function() {
    $this->expectException(ConsoleException::class);
    $this->artisan('config:generate ./tests/Files/Templates ./storage/config2');
});