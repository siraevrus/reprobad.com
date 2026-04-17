<?php

namespace App\Mail;

use App\Models\TestResult;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $testResult;

    public function __construct(TestResult $testResult)
    {
        $this->testResult = $testResult;
    }

    public function build()
    {
        $r = $this->testResult->results ?? [];

        return $this->view('mail.test-result')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Система РЕПРО: Результаты теста «Репродуктивное здоровье»')
            ->with([
                'testResult' => $this->testResult,
                'ibhb' => (int) ($r['ibhb'] ?? 0),
                'idx' => $r['IDX'] ?? [],
                'items' => $r['items'] ?? [],
            ]);
    }
}
