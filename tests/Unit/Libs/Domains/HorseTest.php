<?php

declare(strict_types=1);

namespace Tests\Unit\Libs\Domains;

use App\Libs\Domains\Birthday;
use App\Libs\Domains\Gender;
use App\Libs\Domains\Horse;
use App\Libs\Domains\RunningStyle;
use DateTime;
use PHPUnit\Framework\TestCase;

class HorseTest extends TestCase
{
    private Horse $horse;

    protected function setUp(): void
    {
        $this->horse = new Horse(
            name: 'ディープインパクト',
            gender: Gender::MALE,
            birthday: new Birthday(new DateTime('2002-03-25')),
            runningStyle: RunningStyle::STALKER
        );
    }

    public function test馬の基本情報(): void
    {
        $this->assertEquals('ディープインパクト', $this->horse->name);
        $this->assertEquals(Gender::MALE, $this->horse->gender);
        $this->assertEquals(RunningStyle::STALKER, $this->horse->runningStyle);
    }

    public function test性別判定(): void
    {
        $this->assertTrue($this->horse->isMale());
        $this->assertFalse($this->horse->isFemale());
        $this->assertFalse($this->horse->isGelding());
    }

    public function test牝馬の性別判定(): void
    {
        $femaleHorse = new Horse(
            name: 'アーモンドアイ',
            gender: Gender::FEMALE,
            birthday: new Birthday(new DateTime('2015-03-10')),
            runningStyle: RunningStyle::STALKER
        );

        $this->assertFalse($femaleHorse->isMale());
        $this->assertTrue($femaleHorse->isFemale());
        $this->assertFalse($femaleHorse->isGelding());
    }

    public function testせん馬の性別判定(): void
    {
        $geldingHorse = new Horse(
            name: 'テストホース',
            gender: Gender::GELDING,
            birthday: new Birthday(new DateTime('2020-01-01')),
            runningStyle: RunningStyle::FRONT_RUNNER
        );

        $this->assertFalse($geldingHorse->isMale());
        $this->assertFalse($geldingHorse->isFemale());
        $this->assertTrue($geldingHorse->isGelding());
    }

    public function test年齢カテゴリの取得(): void
    {
        $baseDate = new DateTime('2025-01-01');
        
        $twoYearOld = new Horse(
            name: 'テスト2歳馬',
            gender: Gender::MALE,
            birthday: new Birthday(new DateTime('2023-03-01')),
            runningStyle: RunningStyle::FRONT_RUNNER
        );
        
        $this->assertEquals('2歳', $twoYearOld->getAgeCategory());
    }

    public function test2歳馬の判定(): void
    {
        $baseDate = new DateTime('2025-01-01');
        
        $twoYearOld = new Horse(
            name: 'テスト2歳馬',
            gender: Gender::MALE,
            birthday: new Birthday(new DateTime('2023-03-01')),
            runningStyle: RunningStyle::FRONT_RUNNER
        );
        
        $this->assertTrue($twoYearOld->isTwoYearOld());
        $this->assertFalse($twoYearOld->isThreeYearOld());
        $this->assertFalse($twoYearOld->isOlderHorse());
    }

    public function test3歳馬の判定(): void
    {
        $threeYearOld = new Horse(
            name: 'テスト3歳馬',
            gender: Gender::MALE,
            birthday: new Birthday(new DateTime('2022-03-01')),
            runningStyle: RunningStyle::CLOSER
        );
        
        $this->assertFalse($threeYearOld->isTwoYearOld());
        $this->assertTrue($threeYearOld->isThreeYearOld());
        $this->assertFalse($threeYearOld->isOlderHorse());
    }

    public function test古馬の判定(): void
    {
        $olderHorse = new Horse(
            name: 'テスト古馬',
            gender: Gender::MALE,
            birthday: new Birthday(new DateTime('2020-03-01')),
            runningStyle: RunningStyle::DEEP_CLOSER
        );
        
        $this->assertFalse($olderHorse->isTwoYearOld());
        $this->assertFalse($olderHorse->isThreeYearOld());
        $this->assertTrue($olderHorse->isOlderHorse());
    }

    public function test脚質判定(): void
    {
        $this->assertFalse($this->horse->isFrontRunner());
        $this->assertTrue($this->horse->isStalker());
        $this->assertFalse($this->horse->isCloser());
        $this->assertFalse($this->horse->isDeepCloser());
    }

    public function test前につけるタイプの判定(): void
    {
        $this->assertTrue($this->horse->isEarlySpeed());
        $this->assertFalse($this->horse->isLateSpeed());
    }

    public function test後方からのタイプの判定(): void
    {
        $closerHorse = new Horse(
            name: 'テスト差し馬',
            gender: Gender::MALE,
            birthday: new Birthday(new DateTime('2020-01-01')),
            runningStyle: RunningStyle::CLOSER
        );

        $this->assertFalse($closerHorse->isEarlySpeed());
        $this->assertTrue($closerHorse->isLateSpeed());
    }

    public function testゲッターメソッド(): void
    {
        $this->assertEquals('ディープインパクト', $this->horse->getName());
        $this->assertEquals(Gender::MALE, $this->horse->getGender());
        $this->assertInstanceOf(Birthday::class, $this->horse->getBirthday());
        $this->assertEquals(RunningStyle::STALKER, $this->horse->getRunningStyle());
    }

    public function test年齢計算(): void
    {
        $baseDate = new DateTime('2025-01-01');
        
        // 2002年生まれの馬の2025年時点での競走年齢
        $raceAge = $this->horse->calculateRaceAge();
        $this->assertIsInt($raceAge);
        $this->assertGreaterThan(0, $raceAge);
    }
}
