<?php

namespace GameOfLife;

/**
 * Class GameOfLife
 */
class GameOfLife
{
    public function getNextStatus($currentStatus, $aliveNeighbours)
    {
        if ($currentStatus === 'alive' && $aliveNeighbours < 2)
        {
            return 'dead';
        }
    }
}
