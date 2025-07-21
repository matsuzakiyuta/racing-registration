<?php

declare(strict_types=1);

namespace Tests\Unit\Libs\Domains;

use App\Libs\Domains\Birthday;
use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class BirthdayTest extends TestCase
{
    public function test正常な誕生日の作成(): void
    {
        $birthday = new Birthday(new DateTime('2020-01-01'));
        
        $this->assertEquals('2020-01-01', $birthday->toString());
    }

    public function test未来の日付でエラー(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('誕生日は現在日時より前である必要があります');
        
        $futureDate = new DateTime();
        $futureDate->modify('+1 year');
        
        new Birthday($futureDate);
    }

    public function test1900年より前の日付でエラー(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('誕生日は1900年以降である必要があります');
        
        new Birthday(new DateTime('1899-12-31'));
    }

    public function test年齢計算(): void
    {
        $birthday = new Birthday(new DateTime('2020-01-01'));
        $baseDate = new DateTime('2023-01-01');
        
        $age = $birthday->calculateAge($baseDate);
        
        $this->assertEquals(3, $age);
    }

    public function test競走馬年齢計算(): void
    {
        $birthday = new Birthday(new DateTime('2020-03-01'));
        $baseDate = new DateTime('2023-01-01');
        
        $raceAge = $birthday->calculateRaceAge($baseDate);
        
        // 2020年3月生まれの馬は2023年1月時点で3歳（2023年生まれを基準とした年齢計算）
        $this->assertEquals(3, $raceAge);
    }

    public function test年齢カテゴリの取得(): void
    {
        $baseDate = new DateTime('2023-01-01');
        
        $birthday2021 = new Birthday(new DateTime('2021-01-01'));
        $this->assertEquals('2歳', $birthday2021->getAgeCategory($baseDate));
        
        $birthday2020 = new Birthday(new DateTime('2020-01-01'));
        $this->assertEquals('3歳', $birthday2020->getAgeCategory($baseDate));
        
        $birthday2019 = new Birthday(new DateTime('2019-01-01'));
        $this->assertEquals('古馬', $birthday2019->getAgeCategory($baseDate));
        
        $birthday2023 = new Birthday(new DateTime('2023-06-01'));
        $this->assertEquals('当歳', $birthday2023->getAgeCategory($baseDate));
    }

    public function test2歳馬の判定(): void
    {
        $baseDate = new DateTime('2023-01-01');
        
        $birthday2021 = new Birthday(new DateTime('2021-01-01'));
        $this->assertTrue($birthday2021->isTwoYearOld($baseDate));
        
        $birthday2020 = new Birthday(new DateTime('2020-01-01'));
        $this->assertFalse($birthday2020->isTwoYearOld($baseDate));
    }

    public function test3歳馬の判定(): void
    {
        $baseDate = new DateTime('2023-01-01');
        
        $birthday2020 = new Birthday(new DateTime('2020-01-01'));
        $this->assertTrue($birthday2020->isThreeYearOld($baseDate));
        
        $birthday2019 = new Birthday(new DateTime('2019-01-01'));
        $this->assertFalse($birthday2019->isThreeYearOld($baseDate));
    }

    public function test古馬の判定(): void
    {
        $baseDate = new DateTime('2023-01-01');
        
        $birthday2019 = new Birthday(new DateTime('2019-01-01'));
        $this->assertTrue($birthday2019->isOlderHorse($baseDate));
        
        $birthday2020 = new Birthday(new DateTime('2020-01-01'));
        $this->assertFalse($birthday2020->isOlderHorse($baseDate));
    }

    public function test日付の文字列表現(): void
    {
        $birthday = new Birthday(new DateTime('2020-01-01'));
        
        $this->assertEquals('2020-01-01', $birthday->toString());
        $this->assertEquals('2020/01/01', $birthday->toString('Y/m/d'));
    }

    public function test等価性チェック(): void
    {
        $birthday1 = new Birthday(new DateTime('2020-01-01'));
        $birthday2 = new Birthday(new DateTime('2020-01-01'));
        $birthday3 = new Birthday(new DateTime('2020-01-02'));
        
        $this->assertTrue($birthday1->equals($birthday2));
        $this->assertFalse($birthday1->equals($birthday3));
    }

    public function test文字列からの作成(): void
    {
        $birthday = Birthday::fromString('2020-01-01');
        
        $this->assertEquals('2020-01-01', $birthday->toString());
    }
}
