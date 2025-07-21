<?php

declare(strict_types=1);

namespace Tests\Unit\Libs\Domains;

use App\Libs\Domains\Condition;
use PHPUnit\Framework\TestCase;

class ConditionTest extends TestCase
{
    public function test良馬場の判定(): void
    {
        $condition = Condition::FIRM;
        
        $this->assertTrue($condition->isFirm());
        $this->assertFalse($condition->isGood());
        $this->assertFalse($condition->isYielding());
        $this->assertFalse($condition->isSoft());
    }

    public function test稍重馬場の判定(): void
    {
        $condition = Condition::GOOD;
        
        $this->assertFalse($condition->isFirm());
        $this->assertTrue($condition->isGood());
        $this->assertFalse($condition->isYielding());
        $this->assertFalse($condition->isSoft());
    }

    public function test重馬場の判定(): void
    {
        $condition = Condition::YIELDING;
        
        $this->assertFalse($condition->isFirm());
        $this->assertFalse($condition->isGood());
        $this->assertTrue($condition->isYielding());
        $this->assertFalse($condition->isSoft());
    }

    public function test不良馬場の判定(): void
    {
        $condition = Condition::SOFT;
        
        $this->assertFalse($condition->isFirm());
        $this->assertFalse($condition->isGood());
        $this->assertFalse($condition->isYielding());
        $this->assertTrue($condition->isSoft());
    }

    public function test重馬場以上の判定(): void
    {
        $this->assertFalse(Condition::FIRM->isHeavyOrWorse());
        $this->assertFalse(Condition::GOOD->isHeavyOrWorse());
        $this->assertTrue(Condition::YIELDING->isHeavyOrWorse());
        $this->assertTrue(Condition::SOFT->isHeavyOrWorse());
    }

    public function test水分を含んだ馬場の判定(): void
    {
        $this->assertFalse(Condition::FIRM->isWet());
        $this->assertTrue(Condition::GOOD->isWet());
        $this->assertTrue(Condition::YIELDING->isWet());
        $this->assertTrue(Condition::SOFT->isWet());
    }

    public function test馬場状態の数値取得(): void
    {
        $this->assertEquals(1, Condition::FIRM->getNumericValue());
        $this->assertEquals(2, Condition::GOOD->getNumericValue());
        $this->assertEquals(3, Condition::YIELDING->getNumericValue());
        $this->assertEquals(4, Condition::SOFT->getNumericValue());
    }

    public function test馬場状態の比較(): void
    {
        $firm = Condition::FIRM;
        $good = Condition::GOOD;
        $yielding = Condition::YIELDING;
        $soft = Condition::SOFT;

        // より重い馬場状態かどうか
        $this->assertTrue($good->isHeavierThan($firm));
        $this->assertTrue($yielding->isHeavierThan($good));
        $this->assertTrue($soft->isHeavierThan($yielding));
        $this->assertFalse($firm->isHeavierThan($good));

        // より軽い馬場状態かどうか
        $this->assertTrue($firm->isLighterThan($good));
        $this->assertTrue($good->isLighterThan($yielding));
        $this->assertTrue($yielding->isLighterThan($soft));
        $this->assertFalse($good->isLighterThan($firm));

        // 同じ馬場状態かどうか
        $this->assertTrue($firm->isSameAs($firm));
        $this->assertTrue($good->isSameAs($good));
        $this->assertFalse($firm->isSameAs($good));
    }

    public function test理想的な馬場状態の判定(): void
    {
        $this->assertTrue(Condition::FIRM->isIdeal());
        $this->assertTrue(Condition::GOOD->isIdeal());
        $this->assertFalse(Condition::YIELDING->isIdeal());
        $this->assertFalse(Condition::SOFT->isIdeal());
    }

    public function test厳しい馬場状態の判定(): void
    {
        $this->assertFalse(Condition::FIRM->isTough());
        $this->assertFalse(Condition::GOOD->isTough());
        $this->assertTrue(Condition::YIELDING->isTough());
        $this->assertTrue(Condition::SOFT->isTough());
    }

    public function test馬場状態の値(): void
    {
        $this->assertEquals('良', Condition::FIRM->value);
        $this->assertEquals('稍重', Condition::GOOD->value);
        $this->assertEquals('重', Condition::YIELDING->value);
        $this->assertEquals('不良', Condition::SOFT->value);
    }
}
