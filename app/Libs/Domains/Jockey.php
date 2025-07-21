<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 騎手ドメインクラス
 */
readonly class Jockey
{
    /**
     * @param Stat[] $stats
     * @param GradeWin[] $gradeWins
     */
    public function __construct(
        public string $name,
        public array $stats,
        public array $gradeWins
    ) {
    }

    /**
     * 指定年の成績を取得
     */
    public function getStatByYear(int $year): ?Stat
    {
        foreach ($this->stats as $stat) {
            if ($stat->year === $year) {
                return $stat;
            }
        }
        return null;
    }

    /**
     * 最新年の成績を取得
     */
    public function getLatestStat(): ?Stat
    {
        if (empty($this->stats)) {
            return null;
        }

        $latestYear = 0;
        $latestStat = null;

        foreach ($this->stats as $stat) {
            if ($stat->year > $latestYear) {
                $latestYear = $stat->year;
                $latestStat = $stat;
            }
        }

        return $latestStat;
    }

    /**
     * 通算勝利数を取得
     */
    public function getTotalWins(): int
    {
        $totalWins = 0;
        foreach ($this->stats as $stat) {
            $totalWins += $stat->wins;
        }
        return $totalWins;
    }

    /**
     * 通算出走数を取得
     */
    public function getTotalRides(): int
    {
        $totalRides = 0;
        foreach ($this->stats as $stat) {
            $totalRides += $stat->totalRides;
        }
        return $totalRides;
    }

    /**
     * 通算勝率を計算
     */
    public function getOverallWinRate(): float
    {
        $totalRides = $this->getTotalRides();
        if ($totalRides === 0) {
            return 0.0;
        }
        return round(($this->getTotalWins() / $totalRides) * 100, 2);
    }

    /**
     * G1勝利数を取得
     */
    public function getG1Wins(): int
    {
        $g1Wins = 0;
        foreach ($this->gradeWins as $gradeWin) {
            if ($gradeWin->isG1Win()) {
                $g1Wins++;
            }
        }
        return $g1Wins;
    }

    /**
     * 重賞勝利数を取得
     */
    public function getGradeWinsCount(): int
    {
        return count($this->gradeWins);
    }

    /**
     * 重賞騎手かどうかを判定
     */
    public function isGradeJockey(): bool
    {
        return $this->getGradeWinsCount() > 0;
    }

    /**
     * トップジョッキーかどうかを判定（G1勝利あり）
     */
    public function isTopJockey(): bool
    {
        return $this->getG1Wins() > 0;
    }

    /**
     * リーディングジョッキーかどうかを判定（年間50勝以上）
     */
    public function isLeadingJockey(): bool
    {
        $latestStat = $this->getLatestStat();
        return $latestStat !== null && $latestStat->wins >= 50;
    }

    /**
     * 騎手名を取得
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 成績一覧を取得
     */
    public function getStats(): array
    {
        return $this->stats;
    }

    /**
     * 重賞勝利一覧を取得
     */
    public function getGradeWins(): array
    {
        return $this->gradeWins;
    }
}
