<?php

use Container\RingBuffer;

class RingBufferCest
{
    public function create(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(1);
        $I->assertNotEmpty($ringBuffer);
    }

    public function shouldBeEmpty(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(1);
        $I->assertTrue($ringBuffer->empty());
    }

    public function capacity(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(3);
        $I->assertEquals(3, $ringBuffer->capacity());
    }

    public function sizeShouldBeZeroWhenEmpty(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(3);
        $I->assertTrue($ringBuffer->empty());
        $I->assertEquals(0, $ringBuffer->size());
    }

    public function pushValueSizeShouldIncrease(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(3);
        $I->assertEquals(0, $ringBuffer->size());

        $ringBuffer->push(10);

        $I->assertEquals(1, $ringBuffer->size());
    }

    public function emptyShouldBeFalseWhenFull(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(1);

        $I->assertTrue($ringBuffer->empty());
        $I->assertFalse($ringBuffer->full());

        $ringBuffer->push("foo");

        $I->assertFalse($ringBuffer->empty());
        $I->assertTrue($ringBuffer->full());
    }

    public function popFromEmpty(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(1);
        $I->assertNull($ringBuffer->pop());
    }

    public function pushAndPopSingleValue(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(1);

        $ringBuffer->push(10);

        $I->assertEquals(10, $ringBuffer->pop());
    }

    public function popShouldReduceSize(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(1);
        $ringBuffer->push(10);

        $I->assertEquals(1, $ringBuffer->size());

        $ringBuffer->pop();

        $I->assertEquals(0, $ringBuffer->size());
    }

    public function backShouldNotChangeBuffer(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(1);
        $ringBuffer->push(10);

        $I->assertEquals(1, $ringBuffer->size());

        $I->assertEquals(10, $ringBuffer->tail());

        $I->assertEquals(1, $ringBuffer->size());
    }

    public function pushMultipleTimes(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(1);

        $ringBuffer->push(10);

        $I->assertEquals(1, $ringBuffer->size());
        $I->assertEquals(10, $ringBuffer->tail());

        $ringBuffer->push(20);

        $I->assertEquals(1, $ringBuffer->size());
        $I->assertEquals(20, $ringBuffer->tail());

        $ringBuffer->push(30);

        $I->assertEquals(1, $ringBuffer->size());
        $I->assertEquals(30, $ringBuffer->tail());

        $I->assertEquals(30, $ringBuffer->pop());
        $I->assertEquals(0, $ringBuffer->size());

        $I->assertNull($ringBuffer->tail());
        $I->assertNull($ringBuffer->pop());

        $I->assertEquals(0, $ringBuffer->size());
    }

    public function multiItemBuffer(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(3);

        $I->assertTrue($ringBuffer->empty());

        $ringBuffer->push(10);
        $ringBuffer->push(20);
        $ringBuffer->push(30);

        $I->assertTrue($ringBuffer->full());

        $I->assertEquals(10, $ringBuffer->tail());
        $I->assertEquals(30, $ringBuffer->head());

        $ringBuffer->push(40);

        $I->assertTrue($ringBuffer->full());

        $I->assertEquals(20, $ringBuffer->tail());
        $I->assertEquals(40, $ringBuffer->head());

        $ringBuffer->push(50);

        $I->assertTrue($ringBuffer->full());

        $I->assertEquals(30, $ringBuffer->tail());
        $I->assertEquals(50, $ringBuffer->head());
    }

    public function pushAndPopAllValues(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(9);

        $ringBuffer->push("Hello");
        $ringBuffer->push("!");
        $ringBuffer->push("How");
        $ringBuffer->push("are");
        $ringBuffer->push("You");
        $ringBuffer->push("doing");
        $ringBuffer->push("right");
        $ringBuffer->push("now");
        $ringBuffer->push("?");

        $I->assertEquals("?", $ringBuffer->head());
        $I->assertEquals("Hello", $ringBuffer->tail());

        $I->assertEquals("Hello", $ringBuffer->pop());
        $I->assertEquals("!", $ringBuffer->tail());

        $I->assertEquals("!", $ringBuffer->pop());
        $I->assertEquals("How", $ringBuffer->tail());

        $I->assertEquals("How", $ringBuffer->pop());
        $I->assertEquals("are", $ringBuffer->tail());

        $I->assertEquals("are", $ringBuffer->pop());
        $I->assertEquals("You", $ringBuffer->tail());

        $I->assertEquals("You", $ringBuffer->pop());
        $I->assertEquals("doing", $ringBuffer->tail());

        $I->assertEquals("doing", $ringBuffer->pop());
        $I->assertEquals("right", $ringBuffer->tail());

        $I->assertEquals("right", $ringBuffer->pop());
        $I->assertEquals("now", $ringBuffer->tail());

        $I->assertEquals("now", $ringBuffer->pop());
        $I->assertEquals("?", $ringBuffer->tail());

        $I->assertEquals("?", $ringBuffer->pop());
        $I->assertEquals(null, $ringBuffer->tail());

        $I->assertEquals(null, $ringBuffer->pop());
    }

    public function accessValuesByIndex(UnitTester $I)
    {
        $ringBuffer = new RingBuffer(5);

        $ringBuffer->push("Foo");
        $ringBuffer->push("Bar");
        $ringBuffer->push("Baz");

        $I->assertEquals("Foo", $ringBuffer->at(0));
        $I->assertEquals("Bar", $ringBuffer->at(1));
        $I->assertEquals("Baz", $ringBuffer->at(2));
        $I->assertEquals(null, $ringBuffer->at(3));
        $I->assertEquals(null, $ringBuffer->at(4));
    }
}
