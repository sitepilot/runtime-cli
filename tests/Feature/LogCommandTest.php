<?php

test('log info', function () {
    $this->artisan('log "This is a info message"')
        ->assertExitCode(0);
});

test('log error', function () {
    $this->artisan("log 'This is an error message' --type=error")
        ->assertExitCode(0);
});

test('log warning', function () {
    $this->artisan('log "This is a warning message" --type=warning')
        ->assertExitCode(0);
});
