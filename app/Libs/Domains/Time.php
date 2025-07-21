<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 走破タイムドメインクラス
 */
readonly class Time
{
    public function __construct(
        public string $value
    ) {
    }

    /**
     * タイムを秒に変換
     */
    public function toSeconds(): ?float
    {
        // "1:23.4" → 83.4秒 のような変換
        if (preg_match('/(\d+):(\d+)\.(\d+)/', $this->value, $matches)) {
            return (float)$matches[1] * 60 + (float)$matches[2] + (float)$matches[3] / 10;
        }

        // "23.4" → 23.4秒 のような変換（1分未満）
        if (preg_match('/(\d+)\.(\d+)/', $this->value, $matches)) {
            return (float)$matches[1] + (float)$matches[2] / 10;
        }

        return null;
    }

    /**
     * 分を取得
     */
    public function getMinutes(): int
    {
        if (preg_match('/(\d+):/', $this->value, $matches)) {
            return (int)$matches[1];
        }
        return 0;
    }

    /**
     * 秒を取得（分を除く）
     */
    public function getSeconds(): float
    {
        if (preg_match('/(\d+):(\d+)\.(\d+)/', $this->value, $matches)) {
            return (float)$matches[2] + (float)$matches[3] / 10;
        }

        if (preg_match('/(\d+)\.(\d+)/', $this->value, $matches)) {
            return (float)$matches[1] + (float)$matches[2] / 10;
        }

        return 0.0;
    }

    /**
     * 他のタイムと比較（速いかどうか）
     */
    public function isFasterThan(Time $other): bool
    {
        $thisSeconds = $this->toSeconds();
        $otherSeconds = $other->toSeconds();

        if ($thisSeconds === null || $otherSeconds === null) {
            return false;
        }

        return $thisSeconds < $otherSeconds;
    }

    /**
     * 他のタイムと比較（遅いかどうか）
     */
    public function isSlowerThan(Time $other): bool
    {
        $thisSeconds = $this->toSeconds();
        $otherSeconds = $other->toSeconds();

        if ($thisSeconds === null || $otherSeconds === null) {
            return false;
        }

        return $thisSeconds > $otherSeconds;
    }

    /**
     * 他のタイムとの差を取得（秒）
     */
    public function getDifferenceInSeconds(Time $other): ?float
    {
        $thisSeconds = $this->toSeconds();
        $otherSeconds = $other->toSeconds();

        if ($thisSeconds === null || $otherSeconds === null) {
            return null;
        }

        return $thisSeconds - $otherSeconds;
    }

    /**
     * レコードタイムかどうかを判定（例：1分30秒以下）
     */
    public function isRecordTime(int $distanceMeters): bool
    {
        $seconds = $this->toSeconds();
        if ($seconds === null) {
            return false;
        }

        // 距離別の基準タイム（秒）
        $recordThresholds = [
            1200 => 69.0,  // 1分09秒
            1400 => 81.0,  // 1分21秒
            1600 => 93.0,  // 1分33秒
            1800 => 105.0, // 1分45秒
            2000 => 117.0, // 1分57秒
            2400 => 144.0, // 2分24秒
        ];

        foreach ($recordThresholds as $distance => $threshold) {
            if ($distanceMeters <= $distance) {
                return $seconds <= $threshold;
            }
        }

        return false;
    }

    /**
     * 文字列表現を取得
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * 文字列からTimeオブジェクトを作成
     */
    public static function fromString(string $timeString): self
    {
        return new self($timeString);
    }
}
