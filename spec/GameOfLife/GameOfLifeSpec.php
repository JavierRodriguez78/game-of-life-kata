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

    function it_should_live_if_lives_in_equilibred_population()
    {
        $this->getNextStatus('alive', 2)->shouldReturn('alive');
    }

    function it_should_die_if_lives_in_overpopulation()
    {
        $this->getNextStatus('alive', 4)->shouldReturn('dead');
    }

    function it_should_reborn_if_dead_with_three_living_neighbours()
    {
        $this->getNextStatus('dead', 3)->shouldReturn('alive');
    }

    function it_should_initialize_an_empty_world()
    {
        $this->initializeWorld(2, 3)->shouldReturn(null);
        $expectedWorld = [[0, 0], [0, 0], [0, 0]];
        $this->getWorld()->shouldReturn($expectedWorld);
    }

    function it_should_get_cell_neighbours_list()
    {
        $world = [
            [0, 0, 0, 0],
            [0, 0, 0, 0],
            [0, 0, 0, 0],
            [0, 0, 0, 0],
        ];

        $this->setWorld($world);

        $this->getNeighbours([0, 0])->shouldReturn([
            [1, 0],
            [0, 1],
            [1, 1]
        ]);
    }

    function it_should_get_count_cell_alive_neighbours()
    {
        $world = [
            [0, 0, 0, 0],
            [0, 1, 0, 0],
            [0, 1, 0, 1],
            [0, 0, 0, 0],
        ];

        $this->setWorld($world);

        $this->countAliveNeighbours([2, 2])->shouldReturn(3);
    }
}
