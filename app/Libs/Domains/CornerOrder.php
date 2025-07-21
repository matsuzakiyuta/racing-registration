<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * コーナー順位ドメインクラス
 */
readonly class CornerOrder
{
    public function __construct(
        public int $corner,
        public int $order
    ) {
    }

    /**
     * 1コーナーかどうかを判定
     */
    public function isFirstCorner(): bool
    {
        return $this->corner === 1;
    }

    /**
     * 2コーナーかどうかを判定
     */
    public function isSecondCorner(): bool
    {
        return $this->corner === 2;
    }

    /**
     * 3コーナーかどうかを判定
     */
    public function isThirdCorner(): bool
    {
        return $this->corner === 3;
    }

    /**
     * 4コーナーかどうかを判定
     */
    public function isFourthCorner(): bool
    {
        return $this->corner === 4;
    }

    /**
     * 先頭通過かどうかを判定
     */
    public function isLeading(): bool
    {
        return $this->order === 1;
    }

    /**
     * 2番手通過かどうかを判定
     */
    public function isSecond(): bool
    {
        return $this->order === 2;
    }

    /**
     * 3番手通過かどうかを判定
     */
    public function isThird(): bool
    {
        return $this->order === 3;
    }

    /**
     * 上位通過かどうかを判定（3位以内）
     */
    public function isTopThree(): bool
    {
        return $this->order <= 3;
    }

    /**
     * 前半通過かどうかを判定（上位半分）
     */
    public function isFrontHalf(int $totalHorses): bool
    {
        return $this->order <= ($totalHorses / 2);
    }

    /**
     * 後方通過かどうかを判定（下位半分）
     */
    public function isBackHalf(int $totalHorses): bool
    {
        return !$this->isFrontHalf($totalHorses);
    }
}
