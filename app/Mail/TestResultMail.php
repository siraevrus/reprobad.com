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

        $allClearPhrases = [];
        if (! $hasRecommendations) {
            $idx = [1 => 100, 2 => 100, 3 => 100, 4 => 100];
            $allClearPhrases = $calc->pickRandomAllClearPhrases();
        } else {
            $IDX = is_array($r['IDX'] ?? null) ? $r['IDX'] : [];
            $idx = [];
            for ($i = 1; $i <= 4; $i++) {
                $blk = \Illuminate\Support\Arr::get($r, 'blocks.'.$i, []);
                $blk = is_array($blk) ? $blk : [];
                $idx[$i] = (int) ($blk['idx'] ?? $IDX[$i] ?? $IDX[(string) $i] ?? 0);
            }
        }

        return $this->view('mail.test-result')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Система РЕПРО: Результаты теста «Репродуктивное здоровье»')
            ->with([
                'testResult' => $this->testResult,
                'ibhb' => $calc->displayIbhbForResults($r),
                'idx' => $idx,
                'items' => $r['items'] ?? [],
                'allClearPhrases' => $allClearPhrases,
            ]);
    }
}
