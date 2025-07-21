<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * レースドメインクラス
 */
readonly class Race
{
    /**
     * @param HorseResult[] $result
     */
    public function __construct(
        public string $name,
        public Date $date,
        public Racetrack $track,
        public RaceDistance $distance,
        public Surface $surface,
        public Condition $condition,
        public int $horseCount,
        public Weather $weather,
        public array $result,
        public Grade $grade
    ) {
    }

    /**
     * レースがG1かどうかを判定
     */
    public function isGradeOne(): bool
    {
        return $this->grade->isG1();
    }

    /**
     * レースがG2かどうかを判定
     */
    public function isGradeTwo(): bool
    {
        return $this->grade->isG2();
    }

    /**
     * レースがG3かどうかを判定
     */
    public function isGradeThree(): bool
    {
        return $this->grade->isG3();
    }

    /**
     * レースが重賞かどうかを判定
     */
    public function isGradeRace(): bool
    {
        return $this->grade->isGradeRace();
    }

    /**
     * レースがリステッド競走かどうかを判定
     */
    public function isListedRace(): bool
    {
        return $this->grade->isListed();
    }

    /**
     * レースがオープン特別かどうかを判定
     */
    public function isOpenSpecial(): bool
    {
        return $this->grade->isOpen();
    }

    /**
     * レースが条件戦かどうかを判定
     */
    public function isAllowanceRace(): bool
    {
        return $this->grade->isOther();
    }

    /**
     * 特別競走かどうかを判定
     */
    public function isSpecialRace(): bool
    {
        return $this->grade->isSpecialRace();
    }

    /**
     * レースが芝かどうかを判定
     */
    public function isTurf(): bool
    {
        return $this->surface->isTurf();
    }

    /**
     * レースがダートかどうかを判定
     */
    public function isDirt(): bool
    {
        return $this->surface->isDirt();
    }

    /**
     * レースが障害かどうかを判定
     */
    public function isObstacle(): bool
    {
        return $this->surface->isObstacle();
    }

    /**
     * レースが良馬場かどうかを判定
     */
    public function isGoodTrack(): bool
    {
        return $this->condition->isFirm();
    }

    /**
     * レースが重馬場以上かどうかを判定
     */
    public function isHeavyTrack(): bool
    {
        return $this->condition->isHeavyOrWorse();
    }

    /**
     * レースが悪天候かどうかを判定
     */
    public function isBadWeather(): bool
    {
        return $this->weather->isBadWeather();
    }

    /**
     * 短距離レースかどうかを判定
     */
    public function isSprintRace(): bool
    {
        return $this->distance->isSprint();
    }

    /**
     * マイルレースかどうかを判定
     */
    public function isMileRace(): bool
    {
        return $this->distance->isMile();
    }

    /**
     * 中距離レースかどうかを判定
     */
    public function isMiddleDistanceRace(): bool
    {
        return $this->distance->isMiddleDistance();
    }

    /**
     * 長距離レースかどうかを判定
     */
    public function isLongDistanceRace(): bool
    {
        return $this->distance->isLongDistance();
    }

    /**
     * 関東開催かどうかを判定
     */
    public function isKantoMeeting(): bool
    {
        return $this->track->isKanto();
    }

    /**
     * 関西開催かどうかを判定
     */
    public function isKansaiMeeting(): bool
    {
        return $this->track->isKansai();
    }

    /**
     * 主要競馬場開催かどうかを判定
     */
    public function isMajorTrackMeeting(): bool
    {
        return $this->track->isMajorTrack();
    }

    /**
     * ローカル開催かどうかを判定
     */
    public function isLocalMeeting(): bool
    {
        return $this->track->isLocalMeeting();
    }

    /**
     * レースの格を数値で取得
     */
    public function getGradeValue(): int
    {
        return $this->grade->getValue();
    }

    /**
     * より格が高いかどうかを判定
     */
    public function isHigherGradeThan(Race $other): bool
    {
        return $this->grade->isHigherThan($other->grade);
    }

    /**
     * 同格のレースかどうかを判定
     */
    public function isSameGradeAs(Race $other): bool
    {
        return $this->grade->isSameAs($other->grade);
    }

    /**
     * より格が低いかどうかを判定
     */
    public function isLowerGradeThan(Race $other): bool
    {
        return $this->grade->isLowerThan($other->grade);
    }

    /**
     * レース格付けの表示名を取得
     */
    public function getGradeDisplayName(): string
    {
        return $this->grade->getDisplayName();
    }

    /**
     * 距離適性が似ているかどうかを判定（同じカテゴリ）
     */
    public function hasSimilarDistanceAs(Race $other): bool
    {
        return $this->distance->getCategory() === $other->distance->getCategory();
    }

    /**
     * レースの出走馬数を取得
     */
    public function getRunnerCount(): int
    {
        return count($this->result);
    }

    /**
     * 勝ち馬を取得
     */
    public function getWinner(): ?HorseResult
    {
        foreach ($this->result as $horseResult) {
            if ($horseResult->isWinner()) {
                return $horseResult;
            }
        }
        return null;
    }

    /**
     * 入賞馬（3着以内）を取得
     */
    public function getPlacedHorses(): array
    {
        return array_filter($this->result, fn($horseResult) => $horseResult->isPlaced());
    }

    /**
     * 1番人気馬を取得
     */
    public function getFavorite(): ?HorseResult
    {
        foreach ($this->result as $horseResult) {
            if ($horseResult->isFavorite()) {
                return $horseResult;
            }
        }
        return null;
    }

    /**
     * 人気順で結果を取得
     */
    public function getResultsByPopularity(): array
    {
        $results = $this->result;
        usort($results, fn($a, $b) => $a->popularity <=> $b->popularity);
        return $results;
    }

    /**
     * 着順で結果を取得
     */
    public function getResultsByFinishOrder(): array
    {
        $results = $this->result;
        usort($results, fn($a, $b) => $a->finishPosition <=> $b->finishPosition);
        return $results;
    }

    /**
     * 大波乱レースかどうかを判定（1番人気が5着以下）
     */
    public function isUpsetRace(): bool
    {
        $favorite = $this->getFavorite();
        return $favorite !== null && $favorite->finishPosition >= 5;
    }

    /**
     * 堅い決着かどうかを判定（1-3番人気が3着以内）
     */
    public function isFavoriteFinish(): bool
    {
        $placedHorses = $this->getPlacedHorses();
        $favoriteFinishCount = 0;
        
        foreach ($placedHorses as $horse) {
            if ($horse->popularity !== null && $horse->popularity <= 3) {
                $favoriteFinishCount++;
            }
        }
        
        return $favoriteFinishCount >= 3;
    }

    /**
     * 週末開催かどうかを判定
     */
    public function isWeekendRace(): bool
    {
        return $this->date->isWeekend();
    }

    /**
     * 平日開催かどうかを判定
     */
    public function isWeekdayRace(): bool
    {
        return $this->date->isWeekday();
    }

    /**
     * 日曜日開催かどうかを判定
     */
    public function isSundayRace(): bool
    {
        return $this->date->isSunday();
    }

    /**
     * 土曜日開催かどうかを判定
     */
    public function isSaturdayRace(): bool
    {
        return $this->date->isSaturday();
    }

    /**
     * レース開催年を取得
     */
    public function getYear(): int
    {
        return $this->date->getYear();
    }

    /**
     * レース開催月を取得
     */
    public function getMonth(): int
    {
        return $this->date->getMonth();
    }

    /**
     * レース開催日を取得
     */
    public function getDay(): int
    {
        return $this->date->getDay();
    }

    /**
     * レース開催日の表示文字列を取得
     */
    public function getDateDisplayString(): string
    {
        return $this->date->toDisplayString();
    }

    /**
     * 春開催かどうかを判定
     */
    public function isSpringRace(): bool
    {
        return $this->date->getSeason() === '春';
    }

    /**
     * 夏開催かどうかを判定
     */
    public function isSummerRace(): bool
    {
        return $this->date->getSeason() === '夏';
    }

    /**
     * 秋開催かどうかを判定
     */
    public function isAutumnRace(): bool
    {
        return $this->date->getSeason() === '秋';
    }

    /**
     * 冬開催かどうかを判定
     */
    public function isWinterRace(): bool
    {
        return $this->date->getSeason() === '冬';
    }

    /**
     * 他のレースとの開催日の差を日数で取得
     */
    public function getDaysFromRace(Race $other): int
    {
        return $this->date->diffInDays($other->date);
    }

    /**
     * 指定した日付より前に開催されたかどうかを判定
     */
    public function isHeldBefore(Date $targetDate): bool
    {
        return $this->date->isBefore($targetDate);
    }

    /**
     * 指定した日付より後に開催されたかどうかを判定
     */
    public function isHeldAfter(Date $targetDate): bool
    {
        return $this->date->isAfter($targetDate);
    }
}
