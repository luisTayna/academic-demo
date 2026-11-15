<?php
namespace App\Academic;

final class ConsoleKernel extends \Illuminate\Foundation\Console\Kernel
{
    protected $commands = [SetupCommand::class, VerifyCommand::class];
    protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule): void {}
}
