<?php

use LaraDumps\LaraDumps\Actions\Config;

it('updates the config non-interactively', function () {
    $this->artisan('ds:init --no-interaction --host=1.2.3.4 --port=2022 --send_queries=true --send_http_client_requests=true --send_jobs=true --send_commands=true --send_cache=true --send_logs=true --livewire_events=true --livewire_validation=true --livewire_autoclear=true --send_livewire=true --auto_invoke=true --ide=atom');

    expect(Config::get('host'))->toBe('1.2.3.4')
        ->and(Config::get('port'))->toBe('2022')
        ->and(Config::get('send_queries'))->toBeTrue()
        ->and(Config::get('send_http_client_requests'))->toBeTrue()
        ->and(Config::get('send_jobs'))->toBeTrue()
        ->and(Config::get('send_commands'))->toBeTrue()
        ->and(Config::get('send_cache'))->toBeTrue()
        ->and(Config::get('send_log_applications'))->toBeTrue()
        ->and(Config::get('send_livewire_components'))->toBeTrue()
        ->and(Config::get('send_livewire_events'))->toBeTrue()
        ->and(Config::get('auto_clear_on_page_reload'))->toBeTrue()
        ->and(Config::get('auto_invoke_app'))->toBeTrue()
        ->and(Config::get('preferred_ide'))->toBe('atom');

    $this->artisan('ds:init --no-interaction --host=5.6.7.8 --port=2023 --send_queries=false --send_http_client_requests=false --send_jobs=false --send_commands=false --send_cache=false --send_logs=false --send_livewire=false --livewire_events=false  --livewire_validation=false --livewire_autoclear=false --auto_invoke=false  --ide=vscode');
});

it('updates the config through the wizard', function () {
    $this->artisan('ds:init')
        ->expectsQuestion('Select the App host address', '0.0.0.1')
        ->expectsQuestion('Enter the App Port', '1212')
        ->expectsQuestion('Allow dumping <comment>SQL Queries</comment> to the App?', true)
        ->expectsQuestion('Allow dumping <comment>HTTP Client Requests</comment> to the App?', true)
        ->expectsQuestion('Allow dumping <comment>Jobs</comment> to the App?', true)
        ->expectsQuestion('Allow dumping <comment>Commands</comment> to the App?', true)
        ->expectsQuestion('Allow dumping <comment>Cache</comment> to the App?', true)
        ->expectsQuestion('Allow dumping <comment>Laravel Logs</comment> to the App?', false)
        ->expectsQuestion('Allow dumping <comment>Livewire components</comment> to the App?', true)
        ->expectsQuestion('Allow dumping <comment>Livewire Events</comment> & <comment>Browser Events (dispatch)</comment> to the App?', true)
        ->expectsQuestion('Enable <comment>Auto-clear</comment> APP History on page reload?', true)
        ->expectsQuestion('Would you like to invoke the App window on every Dump?', true)
        ->expectsQuestion('What is your preferred IDE for this project?', 'phpstorm');

    expect(Config::get('host'))->toBe('0.0.0.1')
        ->and(Config::get('port'))->toBe('1212')
        ->and(Config::get('send_queries'))->toBeTrue()
        ->and(Config::get('send_http_client_requests'))->toBeTrue()
        ->and(Config::get('send_jobs'))->toBeTrue()
        ->and(Config::get('send_commands'))->toBeTrue()
        ->and(Config::get('send_cache'))->toBeTrue()
        ->and(Config::get('send_log_applications'))->toBeFalse()
        ->and(Config::get('send_livewire_components'))->toBeTrue()
        ->and(Config::get('auto_clear_on_page_reload'))->toBeTrue()
        ->and(Config::get('auto_invoke_app'))->toBeTrue()
        ->and(Config::get('preferred_ide'))->toBe('phpstorm');

    // The config file already exists from the previous ds:init
    // and the user should be prompted with the option to delete it.
    $this->artisan('ds:init')
        ->expectsQuestion('Select the App host address', 'other')
        ->expectsQuestion('Enter the App Host', '5.7.9.11')
        ->expectsQuestion('Enter the App Port', '5555')
        ->expectsQuestion('Allow dumping <comment>SQL Queries</comment> to the App?', false)
        ->expectsQuestion('Allow dumping <comment>HTTP Client Requests</comment> to the App?', false)
        ->expectsQuestion('Allow dumping <comment>Jobs</comment> to the App?', false)
        ->expectsQuestion('Allow dumping <comment>Commands</comment> to the App?', false)
        ->expectsQuestion('Allow dumping <comment>Cache</comment> to the App?', false)
        ->expectsQuestion('Allow dumping <comment>Laravel Logs</comment> to the App?', true)
        ->expectsQuestion('Allow dumping <comment>Livewire components</comment> to the App?', false)
        ->expectsQuestion('Allow dumping <comment>Livewire Events</comment> & <comment>Browser Events (dispatch)</comment> to the App?', false)
        ->expectsQuestion('Enable <comment>Auto-clear</comment> APP History on page reload?', false)
        ->expectsQuestion('Would you like to invoke the App window on every Dump?', false)
        ->expectsQuestion('What is your preferred IDE for this project?', 'atom');

    expect(Config::get('host'))->toBe('5.7.9.11')
        ->and(Config::get('port'))->toBe('5555')
        ->and(Config::get('send_queries'))->toBeFalse()
        ->and(Config::get('send_http_client_requests'))->toBeFalse()
        ->and(Config::get('send_jobs'))->toBeFalse()
        ->and(Config::get('send_commands'))->toBeFalse()
        ->and(Config::get('send_cache'))->toBeFalse()
        ->and(Config::get('send_log_applications'))->toBeTrue()
        ->and(Config::get('send_livewire_components'))->toBeFalse()
        ->and(Config::get('auto_clear_on_page_reload'))->toBeFalse()
        ->and(Config::get('auto_invoke_app'))->toBeFalse()
        ->and(Config::get('preferred_ide'))->toBe('atom');
});
