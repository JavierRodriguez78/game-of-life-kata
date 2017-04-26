<?php

namespace spec\GameOfLife;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GameOfLifeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('GameOfLife\GameOfLife');
    }

    function it_should_die_if_lives_in_underpopulation()
    {
        $this->getNextStatus('alive', 1)->shouldReturn('dead');
    }
}
