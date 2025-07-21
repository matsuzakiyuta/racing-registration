<?php

declare(strict_types=1);

namespace App\Libs\Domains;

use DateTime;
use InvalidArgumentException;

/**
 * 誕生日value object
 */
readonly class Birthday
{
    public function __construct(
        private DateTime $date
    ) {
        $this->validate();
    }

    /**
     * バリデーション
     */
    private function validate(): void
    {
        $now = new DateTime();
        
        // 未来の日付は無効
        if ($this->date > $now) {
            throw new InvalidArgumentException('誕生日は現在日時より前である必要があります');
        }

        // 1900年より前の日付は無効
        $minimumDate = new DateTime('1900-01-01');
        if ($this->date < $minimumDate) {
            throw new InvalidArgumentException('誕生日は1900年以降である必要があります');
        }
    }

    /**
     * DateTimeオブジェクトを取得
     */
    public function getDate(): DateTime
    {
        return clone $this->date;
    }

    /**
     * 年齢を計算
     */
    public function calculateAge(?DateTime $baseDate = null): int
    {
        $baseDate = $baseDate ?? new DateTime();
        return $baseDate->diff($this->date)->y;
    }

    /**
     * 競走馬の年齢を計算（1月1日基準）
     */
    public function calculateRaceAge(?DateTime $baseDate = null): int
    {
        $baseDate = $baseDate ?? new DateTime();
        $raceYearStart = new DateTime($baseDate->format('Y') . '-01-01');
        
        if ($this->date > $raceYearStart) {
            return $baseDate->format('Y') - $this->date->format('Y') - 1;
        }
        
        return $baseDate->format('Y') - $this->date->format('Y');
    }

    /**
     * 年齢カテゴリを取得
     */
    public function getAgeCategory(?DateTime $baseDate = null): string
    {
        $age = $this->calculateRaceAge($baseDate);
        
        return match (true) {
            $age === 2 => '2歳',
            $age === 3 => '3歳',
            $age >= 4 => '古馬',
            default => '当歳'
        };
    }

    /**
     * 2歳馬かどうかを判定
     */
    public function isTwoYearOld(?DateTime $baseDate = null): bool
    {
        return $this->calculateRaceAge($baseDate) === 2;
    }

    /**
     * 3歳馬かどうかを判定
     */
    public function isThreeYearOld(?DateTime $baseDate = null): bool
    {
        return $this->calculateRaceAge($baseDate) === 3;
    }

    /**
     * 古馬かどうかを判定
     */
    public function isOlderHorse(?DateTime $baseDate = null): bool
    {
        return $this->calculateRaceAge($baseDate) >= 4;
    }

    /**
     * 文字列表現
     */
    public function toString(string $format = 'Y-m-d'): string
    {
        return $this->date->format($format);
    }

    /**
     * 等価性チェック
     */
    public function equals(Birthday $other): bool
    {
        return $this->date->format('Y-m-d') === $other->date->format('Y-m-d');
    }

    /**
     * 文字列から生成
     */
    public static function fromString(string $dateString): self
    {
        return new self(new DateTime($dateString));
    }
}
