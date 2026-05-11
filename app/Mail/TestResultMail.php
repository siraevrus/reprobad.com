<?php

namespace App\Mail;

use App\Models\TestResult;
use App\Services\TestCalculationService;
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
        $calc = app(TestCalculationService::class);
        $r = $calc->resultsForView($this->testResult->results ?? []);
        $hasRecommendations = in_array(true, $calc->blocksWithRecommendationContent($r), true);

        return $this->view('mail.test-result')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Система РЕПРО: Результаты теста «Репродуктивное здоровье»')
            ->with([
                'testResult' => $this->testResult,
                'r' => $r,
                'ibhb' => $calc->displayIbhbForResults($r),
                'hasRecommendations' => $hasRecommendations,
                'allClearPhrases' => $calc->pickRandomAllClearPhrases(),
            ]);
    }
}
