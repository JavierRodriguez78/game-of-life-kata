<?php

namespace spec\GameOfLife;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GameOfLife\GameOfLife;

class GameOfLifeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('GameOfLife\GameOfLife');
    }

    function it_should_die_if_lives_in_underpopulation()
    {
        $this->getNextStatus(GameOfLife::ALIVE, 1)->shouldReturn(GameOfLife::DEAD);
    }

    function it_should_live_if_lives_in_equilibred_population()
    {
        $this->getNextStatus(GameOfLife::ALIVE, 2)->shouldReturn(GameOfLife::ALIVE);
    }

    function it_should_die_if_lives_in_overpopulation()
    {
        $this->getNextStatus(GameOfLife::ALIVE, 4)->shouldReturn(GameOfLife::DEAD);
    }

    function it_should_reborn_if_dead_with_three_living_neighbours()
    {
        $this->getNextStatus(GameOfLife::DEAD, 3)->shouldReturn(GameOfLife::ALIVE);
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
        $expectedResult = [
            [1, 0],
            [0, 1],
            [1, 1]
        ];

        $this->getNeighbours([0, 0])
            ->shouldBeEqualTo($expectedResult);
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

    function it_should_calculate_next_generation()
    {
        $world = [
            [0, 0, 0, 0],
            [0, 1, 0, 0],
            [0, 1, 0, 1],
            [0, 0, 0, 0],
        ];

        $expectedWorld = [
            [0, 0, 0, 0],
            [0, 0, 1, 0],
            [0, 0, 1, 0],
            [0, 0, 0, 0],
        ];

        $this->setWorld($world);

        $this->getNextGeneration();

        $this->getWorld()->shouldBeEqualTo($expectedWorld);
    }
}
