<?php

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('crm:followups:overdue-digest {--date=}', function () {
    $targetDate = $this->option('date')
        ? Carbon::parse($this->option('date'))->endOfDay()
        : now()->endOfDay();

    $overdueActivities = Activity::query()
        ->with('lead.assignedUser:id,name,email')
        ->whereNotNull('next_follow_up')
        ->where('next_follow_up', '<', $targetDate)
        ->orderBy('next_follow_up')
        ->get();

    if ($overdueActivities->isEmpty()) {
        $this->info('Tidak ada overdue follow-up.');
        return;
    }

    $groupedBySales = $overdueActivities
        ->filter(fn (Activity $activity) => $activity->lead?->assignedUser)
        ->groupBy(fn (Activity $activity) => $activity->lead->assignedUser->id);

    foreach ($groupedBySales as $activities) {
        $sales = $activities->first()->lead->assignedUser;
        $count = $activities->count();

        $lines = $activities->map(function (Activity $activity): string {
            $leadName = $activity->lead?->nama_client ?? 'Unknown Lead';
            $nextFollowUp = optional($activity->next_follow_up)->format('d M Y H:i');
            return "- {$leadName} ({$nextFollowUp})";
        })->implode("\n");

        $message = "Reminder overdue follow-up untuk {$sales->name}\n"
            ."Total overdue: {$count}\n"
            ."Daftar:\n{$lines}";

        Log::info('CRM overdue follow-up digest', [
            'sales_id' => $sales->id,
            'sales_name' => $sales->name,
            'overdue_count' => $count,
        ]);

        if (! empty($sales->email)) {
            Mail::raw($message, function ($mail) use ($sales): void {
                $mail->to($sales->email)
                    ->subject('CRM Overdue Follow-up Digest');
            });
        }

        $webhookUrl = config('services.crm.followup_webhook_url');

        if (! empty($webhookUrl)) {
            try {
                Http::timeout(10)->retry(2, 200)->post($webhookUrl, [
                    'channel' => 'wa-placeholder',
                    'type' => 'overdue_followup_digest',
                    'sales' => [
                        'id' => $sales->id,
                        'name' => $sales->name,
                        'email' => $sales->email,
                    ],
                    'overdue_count' => $count,
                    'message' => $message,
                    'sent_at' => now()->toIso8601String(),
                ])->throw();
            } catch (\Throwable $exception) {
                Log::warning('CRM overdue webhook dispatch failed', [
                    'sales_id' => $sales->id,
                    'error' => $exception->getMessage(),
                ]);

                $this->warn("Webhook gagal untuk {$sales->name}: {$exception->getMessage()}");
            }
        }

        $this->line("{$sales->name}: {$count} overdue follow-up");
    }
})->purpose('Kirim digest overdue follow-up per sales (log dan email)');

Schedule::command('crm:followups:overdue-digest')->dailyAt('08:00');
