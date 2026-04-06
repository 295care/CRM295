<?php

namespace Tests\Feature\Console;

use Illuminate\Console\Scheduling\Schedule;
use Tests\TestCase;

class ScheduleRegistrationTest extends TestCase
{
    public function test_overdue_digest_command_is_registered_in_scheduler(): void
    {
        $schedule = $this->app->make(Schedule::class);

        $hasDigestSchedule = collect($schedule->events())
            ->contains(fn ($event): bool => str_contains($event->getSummaryForDisplay(), 'crm:followups:overdue-digest'));

        $this->assertTrue($hasDigestSchedule, 'Scheduler belum mendaftarkan command crm:followups:overdue-digest.');
    }
}
