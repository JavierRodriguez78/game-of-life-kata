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
    const ALIVE = 1;
    const DEAD = 0;

    private $world;

    public function getNextStatus($currentStatus, $aliveNeighbours)
    {
        if (
            $this->itsAlive($currentStatus)
            && $this->itsUnderpopulation($aliveNeighbours)
        ) {
            return self::DEAD;
        }

        if (
            $this->itsAlive($currentStatus)
            && $this->itsEquilibred($aliveNeighbours)
        ) {
            return self::ALIVE;
        }

        if (
            $this->itsAlive($currentStatus)
            && $this->itsOverpopulation($aliveNeighbours)
        ) {
            return self::DEAD;
        }

        if (
            !$this->itsAlive($currentStatus)
            && $this->shouldReborn($aliveNeighbours)
        ) {
            return self::ALIVE;
        } else {
            return self::DEAD;
        }
    }

    private function itsUnderpopulation($aliveNeighbours)
    {
        return $aliveNeighbours < self::UNDERPOPULATION_THRESHOLD;
    }

    private function itsEquilibred($aliveNeighbours)
    {
        if (
            $aliveNeighbours == self::UNDERPOPULATION_THRESHOLD
            || $aliveNeighbours == self::OVERPOPULATION_THRESHOLD
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
        return $currentStatus === self::ALIVE;
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

    public function countAliveNeighbours($cellCoordinates)
    {
        $neighbours = $this->getNeighbours($cellCoordinates);
        $alive = 0;

        foreach ($neighbours as $neighbour) {
            list($x, $y) = $neighbour;

            if ($this->itsAlive($this->world[$y][$x])) {
                $alive++;
            }
        }

        return $alive;
    }

    public function getNextGeneration()
    {
        $maxHeight = count($this->world);
        $maxWidth = count($this->world[0]);
        $nextWorld = [];

        for ($y = 0; $y < $maxHeight; $y++) {
            $newRow = [];
            for ($x = 0; $x < $maxWidth; $x++) {
                $newRow[] = $this->getNextStatus($this->world[$y][$x], $this->countAliveNeighbours([$x, $y]));
            }
            $nextWorld[] = $newRow;
        }

        $this->setWorld($nextWorld);
    }
}
