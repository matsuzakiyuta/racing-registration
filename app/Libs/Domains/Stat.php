<?php

declare(strict_types=1);

namespace App\Libs\Domains;

use InvalidArgumentException;

/**
 * 成績統計value object
 */
readonly class Stat
{
    public function __construct(
        public int $totalRides,
        public int $wins,
        public int $place,
        public int $shows,
        public int $top3Finishes,
        public int $year
    ) {
        $this->validate();
    }

    /**
     * バリデーション
     */
    private function validate(): void
    {
        if ($this->totalRides < 0) {
            throw new InvalidArgumentException('総出走数は0以上である必要があります');
        }

        if ($this->wins < 0 || $this->wins > $this->totalRides) {
            throw new InvalidArgumentException('勝利数は0以上、総出走数以下である必要があります');
        }

        if ($this->place < 0 || $this->place > $this->totalRides) {
            throw new InvalidArgumentException('2着数は0以上、総出走数以下である必要があります');
        }

        if ($this->shows < 0 || $this->shows > $this->totalRides) {
            throw new InvalidArgumentException('3着数は0以上、総出走数以下である必要があります');
        }

        if ($this->top3Finishes < 0 || $this->top3Finishes > $this->totalRides) {
            throw new InvalidArgumentException('3着以内数は0以上、総出走数以下である必要があります');
        }

        if ($this->year < 1900 || $this->year > 2100) {
            throw new InvalidArgumentException('年は1900年から2100年の範囲である必要があります');
        }
    }

    /**
     * 勝率を計算
     */
    public function getWinRate(): float
    {
        if ($this->totalRides === 0) {
            return 0.0;
        }
        return round(($this->wins / $this->totalRides) * 100, 2);
    }

    /**
     * 連対率を計算（1着+2着）
     */
    public function getPlaceRate(): float
    {
        if ($this->totalRides === 0) {
            return 0.0;
        }
        return round((($this->wins + $this->place) / $this->totalRides) * 100, 2);
    }

    /**
     * 複勝率を計算（1着+2着+3着）
     */
    public function getShowRate(): float
    {
        if ($this->totalRides === 0) {
            return 0.0;
        }
        return round($this->top3Finishes / $this->totalRides * 100, 2);
    }

    /**
     * 着外数を計算
     */
    public function getUnplacedCount(): int
    {
        return $this->totalRides - $this->top3Finishes;
    }

    /**
     * 着外率を計算
     */
    public function getUnplacedRate(): float
    {
        if ($this->totalRides === 0) {
            return 0.0;
        }
        return round(($this->getUnplacedCount() / $this->totalRides) * 100, 2);
    }

    /**
     * 成績が優秀かどうかを判定（勝率20%以上）
     */
    public function isExcellent(): bool
    {
        return $this->getWinRate() >= 20.0;
    }

    /**
     * 成績が良好かどうかを判定（勝率10%以上）
     */
    public function isGood(): bool
    {
        return $this->getWinRate() >= 10.0;
    }

    /**
     * データが存在するかどうかを判定
     */
    public function hasData(): bool
    {
        return $this->totalRides > 0;
    }

    /**
     * 年数による成績カテゴリを取得
     */
    public function getYearCategory(): string
    {
        $currentYear = (int)date('Y');
        $yearsAgo = $currentYear - $this->year;

        return match (true) {
            $yearsAgo === 0 => '今年',
            $yearsAgo === 1 => '昨年',
            $yearsAgo <= 3 => '近年',
            default => '過去'
        };
    }

    /**
     * 成績サマリーを文字列で取得
     */
    public function getSummary(): string
    {
        return sprintf(
            '%d戦%d勝%d着%d着（勝率%.1f%%）',
            $this->totalRides,
            $this->wins,
            $this->place,
            $this->shows,
            $this->getWinRate()
        );
    }
}
