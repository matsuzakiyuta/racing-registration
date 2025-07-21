<?php

declare(strict_types=1);

namespace App\Libs\Domains;

use DateTimeImmutable;

/**
 * 日付ドメインクラス
 */
readonly class Date
{
    public function __construct(
        public DateTimeImmutable $value
    ) {
    }

    /**
     * 年を取得
     */
    public function getYear(): int
    {
        return (int) $this->value->format('Y');
    }

    /**
     * 月を取得
     */
    public function getMonth(): int
    {
        return (int) $this->value->format('n');
    }

    /**
     * 日を取得
     */
    public function getDay(): int
    {
        return (int) $this->value->format('j');
    }

    /**
     * 曜日を取得（0=日曜日, 1=月曜日, ..., 6=土曜日）
     */
    public function getDayOfWeek(): int
    {
        return (int) $this->value->format('w');
    }

    /**
     * 曜日名を取得（日本語）
     */
    public function getDayOfWeekName(): string
    {
        $days = ['日', '月', '火', '水', '木', '金', '土'];
        return $days[$this->getDayOfWeek()];
    }

    /**
     * 日曜日かどうかを判定
     */
    public function isSunday(): bool
    {
        return $this->getDayOfWeek() === 0;
    }

    /**
     * 土曜日かどうかを判定
     */
    public function isSaturday(): bool
    {
        return $this->getDayOfWeek() === 6;
    }

    /**
     * 週末かどうかを判定
     */
    public function isWeekend(): bool
    {
        return $this->isSaturday() || $this->isSunday();
    }

    /**
     * 平日かどうかを判定
     */
    public function isWeekday(): bool
    {
        return !$this->isWeekend();
    }

    /**
     * 月の最初の週末かどうかを判定
     */
    public function isFirstWeekendOfMonth(): bool
    {
        if (!$this->isWeekend()) {
            return false;
        }

        $day = $this->getDay();
        return $day <= 7;
    }

    /**
     * 月の最後の週末かどうかを判定
     */
    public function isLastWeekendOfMonth(): bool
    {
        if (!$this->isWeekend()) {
            return false;
        }

        $lastDay = (int) $this->value->format('t');
        $day = $this->getDay();
        return $day > $lastDay - 7;
    }

    /**
     * 指定した日付より前かどうかを判定
     */
    public function isBefore(Date $other): bool
    {
        return $this->value < $other->value;
    }

    /**
     * 指定した日付より後かどうかを判定
     */
    public function isAfter(Date $other): bool
    {
        return $this->value > $other->value;
    }

    /**
     * 指定した日付と同じかどうかを判定
     */
    public function isSameAs(Date $other): bool
    {
        return $this->value->format('Y-m-d') === $other->value->format('Y-m-d');
    }

    /**
     * 日付の差を日数で取得
     */
    public function diffInDays(Date $other): int
    {
        return (int) $this->value->diff($other->value)->days;
    }

    /**
     * 文字列表現を取得（Y-m-d形式）
     */
    public function toString(): string
    {
        return $this->value->format('Y-m-d');
    }

    /**
     * 日本語形式の文字列表現を取得（Y年m月d日）
     */
    public function toJapaneseString(): string
    {
        return $this->value->format('Y年n月j日');
    }

    /**
     * 表示用文字列を取得（Y年m月d日(曜日)）
     */
    public function toDisplayString(): string
    {
        return $this->toJapaneseString() . '(' . $this->getDayOfWeekName() . ')';
    }

    /**
     * 年度を取得（4月開始）
     */
    public function getFiscalYear(): int
    {
        $year = $this->getYear();
        $month = $this->getMonth();
        
        return $month >= 4 ? $year : $year - 1;
    }

    /**
     * 季節を取得
     */
    public function getSeason(): string
    {
        $month = $this->getMonth();
        
        return match (true) {
            $month >= 3 && $month <= 5 => '春',
            $month >= 6 && $month <= 8 => '夏',
            $month >= 9 && $month <= 11 => '秋',
            default => '冬'
        };
    }

    /**
     * 文字列から日付を作成
     */
    public static function fromString(string $date): self
    {
        return new self(new DateTimeImmutable($date));
    }

    /**
     * 現在の日付を作成
     */
    public static function now(): self
    {
        return new self(new DateTimeImmutable());
    }

    /**
     * 今日の日付を作成（時間を00:00:00に設定）
     */
    public static function today(): self
    {
        return new self(new DateTimeImmutable('today'));
    }
}
