<?php

namespace GameOfLife;

/**
 * Class GameOfLife
 */
class GameOfLife
{
    const UNDERPOPULATION_THRESHOLD = 2;
    const OVERPOPULATION_THRESHOLD = 3;
    const REBORN_CONDITION = 3;

    private $world;

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

        if (
            !$this->itsAlive($currentStatus)
            && $this->shouldReborn($aliveNeighbours)
        ) {
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

    private function shouldReborn($aliveNeighbours)
    {
        return $aliveNeighbours === self::REBORN_CONDITION;
    }

    private function itsAlive($currentStatus)
    {
        return $currentStatus === 'alive';
    }

    public function initializeWorld($width, $height)
    {
        $world = [];

        for ($h = 0; $h < $height; $h++) {
            $row = [];
            for ($w = 0; $w < $width; $w++) {
                $row[] = 0;
            }

            $world[] = $row;
        }

        $this->world = $world;
    }

    public function getWorld()
    {
        return $this->world;
    }

    public function setWorld($world)
    {
        $this->world = $world;
    }

    public function getNeighbours($cellCoordinates)
    {
        list($x, $y) = $cellCoordinates;
        $maxHeight = count($this->world);
        $maxWidth = count($this->world[0]);
        $neighbours = [];

        foreach (range(max(0, $y - 1), min($y + 1, $maxHeight - 1)) as $cy) {
            foreach (range(max(0, $x - 1), min($x + 1, $maxWidth - 1)) as $cx) {
                if (!($x === $cx && $y === $cy)) {
                    $neighbours[] = [$cx, $cy];
                }
            }
        }

        return $neighbours;
    }
}
