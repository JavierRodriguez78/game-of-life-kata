<?php

namespace GameOfLife;

/**
 * Class GameOfLife
 */
class GameOfLife
{
    const UNDERPOPULATION_THRESHOLD = 2;
    const OVERPOPULATION_THRESHOLD = 3;

    public function getNextStatus($currentStatus, $aliveNeighbours)
    {
        if (
            $this->itsAlive($currentStatus)
            && $this->itsUnderpopulation($aliveNeighbours)
        ) {
            return 'dead';
        }

        if (
            $this->itsAlive($currentStatus)
            && $this->itsEquilibred($aliveNeighbours)
        ) {
            return 'alive';
        }

        if (
            $this->itsAlive($currentStatus)
            && $this->itsOverpopulation($aliveNeighbours)
        ) {
            return 'dead';
        }

        if ($currentStatus === 'dead' && $aliveNeighbours === 3) {
            return 'alive';
        }
    }

    private function itsUnderpopulation($aliveNeighbours)
    {
        return $aliveNeighbours < self::UNDERPOPULATION_THRESHOLD;
    }

    private function itsEquilibred($aliveNeighbours)
    {
        if (
            $aliveNeighbours >= self::UNDERPOPULATION_THRESHOLD
            && $aliveNeighbours <= self::OVERPOPULATION_THRESHOLD
        ) {
            return true;
        }

        return false;
    }

    private function itsOverpopulation($aliveNeighbours)
    {
        return $aliveNeighbours > self::OVERPOPULATION_THRESHOLD;
    }

    private function itsAlive($currentStatus)
    {
        return $currentStatus === 'alive';
    }
}
