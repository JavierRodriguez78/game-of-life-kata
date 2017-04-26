<?php

namespace GameOfLife;

/**
 * Class GameOfLife
 */
class GameOfLife
{
    const UNDERPOPULATION_THRESHOLD = 2;

    public function getNextStatus($currentStatus, $aliveNeighbours)
    {
        if (
            $this->itsAlive($currentStatus)
            && $this->itsUnderpopulation($aliveNeighbours)
        ) {
            return 'dead';
        }
    }

    private function itsUnderpopulation($aliveNeighbours)
    {
        return $aliveNeighbours < self::UNDERPOPULATION_THRESHOLD;
    }

    private function itsAlive($currentStatus)
    {
        return $currentStatus === 'alive';
    }
}
