<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 馬のレース結果ドメインクラス
 */
readonly class HorseResult
{
    /**
     * @param CornerOrder[] $cornerOrders
     */
    public function __construct(
        public int $horseNumber,
        public int $frameNumber,
        public int $finishPosition,
        public int $odds,
        public Horse $horse,
        public Jockey $jockey,
        public Trainer $trainer,
        public int $popularity,
        public Time $time,
        public int $weight,
        public bool $isDisqualified,
        public bool $isWithdrawn,
        public array $cornerOrders,
        public string $margin
    ) {
    }

    /**
     * 1着かどうかを判定
     */
    public function isWinner(): bool
    {
        return $this->finishPosition === 1;
    }

    /**
     * 2着かどうかを判定
     */
    public function isSecond(): bool
    {
        return $this->finishPosition === 2;
    }

    /**
     * 3着かどうかを判定
     */
    public function isThird(): bool
    {
        return $this->finishPosition === 3;
    }

    /**
     * 入賞（3着以内）かどうかを判定
     */
    public function isPlaced(): bool
    {
        return $this->finishPosition <= 3;
    }

    /**
     * 掲示板（5着以内）かどうかを判定
     */
    public function isInBoard(): bool
    {
        return $this->finishPosition <= 5;
    }

    /**
     * 人気通りの結果かどうかを判定
     */
    public function isAsExpected(): bool
    {
        return $this->finishPosition === $this->popularity;
    }

    /**
     * 人気を上回ったかどうかを判定
     */
    public function outperformedExpectation(): bool
    {
        return $this->finishPosition < $this->popularity;
    }

    /**
     * 人気を下回ったかどうかを判定
     */
    public function underperformedExpectation(): bool
    {
        return $this->finishPosition > $this->popularity;
    }

    /**
     * 1番人気かどうかを判定
     */
    public function isFavorite(): bool
    {
        return $this->popularity === 1;
    }

    /**
     * 大穴（10番人気以下）かどうかを判定
     */
    public function isLongshot(): bool
    {
        if ($this->popularity === null) {
            return false;
        }
        return $this->popularity >= 10;
    }

    /**
     * 高配当（10倍以上）かどうかを判定
     */
    public function isHighPayout(): bool
    {
        return $this->odds >= 10;
    }

    /**
     * 失格したかどうかを判定
     */
    public function isDisqualified(): bool
    {
        return $this->isDisqualified;
    }

    /**
     * 競走除外されたかどうかを判定
     */
    public function isWithdrawn(): bool
    {
        return $this->isWithdrawn;
    }

    /**
     * 正常に完走したかどうかを判定
     */
    public function isNormalFinish(): bool
    {
        return !$this->isDisqualified && !$this->isWithdrawn;
    }

    /**
     * 内枠（1-3枠）かどうかを判定
     */
    public function isInnerFrame(): bool
    {
        return $this->frameNumber <= 3;
    }

    /**
     * 中枠（4-6枠）かどうかを判定
     */
    public function isMiddleFrame(): bool
    {
        return $this->frameNumber >= 4 && $this->frameNumber <= 6;
    }

    /**
     * 外枠（7枠以上）かどうかを判定
     */
    public function isOuterFrame(): bool
    {
        return $this->frameNumber >= 7;
    }

    /**
     * 指定したコーナーでの順位を取得
     */
    public function getCornerOrder(int $corner): ?int
    {
        foreach ($this->cornerOrders as $cornerOrder) {
            if ($cornerOrder->corner === $corner) {
                return $cornerOrder->order;
            }
        }
        return null;
    }

    /**
     * 4コーナーから最終順位までの着順変動を取得
     */
    public function getFinishingMove(): ?int
    {
        $fourthCornerOrder = $this->getCornerOrder(4);
        if ($fourthCornerOrder === null) {
            return null;
        }

        return $fourthCornerOrder - $this->finishPosition;
    }

    /**
     * 上がり（直線で順位を上げた）かどうかを判定
     */
    public function hasStrongFinish(): bool
    {
        $move = $this->getFinishingMove();
        return $move !== null && $move > 0;
    }

    /**
     * 走破タイムを秒に変換
     */
    public function getTimeInSeconds(): ?float
    {
        return $this->time->toSeconds();
    }

    /**
     * タイムの文字列表現を取得
     */
    public function getTimeString(): string
    {
        return $this->time->toString();
    }

    /**
     * 他の結果とタイム比較（速いかどうか）
     */
    public function isFasterThan(HorseResult $other): bool
    {
        return $this->time->isFasterThan($other->time);
    }

    /**
     * 着差の文字列表現を取得
     */
    public function getMarginString(): string
    {
        return $this->margin;
    }

    /**
     * 騎手名を取得
     */
    public function getJockeyName(): string
    {
        return $this->jockey->getName();
    }

    /**
     * 牝馬が出走しているかどうかを判定
     */
    public function isFemaleHorse(): bool
    {
        return $this->horse->isFemale();
    }
}
