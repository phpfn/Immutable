<?php

/**
 * This file is part of Immutable package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Immutable\Tests;

use PHPUnit\Framework\TestCase;
use Serafim\Immutable\Immutable;
use Serafim\Immutable\Exception\ContextException;

/**
 * @return void
 */
function out_of_context(): void
{
    Immutable::execute(static function () {
        throw new \LogicException('This code should not have been executed');
    });
}

/**
 * Class InvalidContextTestCase
 */
class InvalidContextTestCase extends TestCase
{
    /**
     * @var string
     */
    private const EXPECTED_EXCEPTION_MESSAGE =
        'Can not create an immutable object, because \Closure argument does ' .
        'not contain the context. Make sure the \Closure is not static ' .
        'and/or used inside an object';

    /**
     * @return void
     */
    public function testStaticContext(): void
    {
        $this->expectException(ContextException::class);
        $this->expectExceptionMessage(self::EXPECTED_EXCEPTION_MESSAGE);
        $this->expectExceptionCode(2);

        Immutable::execute(static function () {
            $this->throwException(new \LogicException('This code should not have been executed'));
        });
    }

    /**
     * @return void
     */
    public function testOutOfContext(): void
    {
        $this->expectException(ContextException::class);
        $this->expectExceptionMessage(self::EXPECTED_EXCEPTION_MESSAGE);
        $this->expectExceptionCode(2);

        out_of_context();
    }

    /**
     * @return void
     */
    public function testBadFunction(): void
    {
        $this->markTestIncomplete('I dont know how to test this case =)))');
    }
}
