<?php

class GameOfLife
{
    private $width;
    private $height;
    private $board;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->initializeBoard();
    }

    private function initializeBoard()
    {
        $this->board = array_fill(0, $this->height, array_fill(0, $this->width, 0));
    }

    public function setCell($x, $y, $state)
    {
        $this->board[$y][$x] = $state;
    }

    public function printBoard()
    {
        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                echo $this->board[$y][$x] ? '■ ' : '□ ';
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    public function evolve()
    {
        $newBoard = $this->board;

        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                $neighbors = $this->countLiveNeighbors($x, $y);

                if ($this->board[$y][$x]) {
                    if ($neighbors < 2 || $neighbors > 3) {
                        $newBoard[$y][$x] = 0;
                    }
                } else {
                    if ($neighbors === 3) {
                        $newBoard[$y][$x] = 1;
                    }
                }
            }
        }

        $this->board = $newBoard;
    }

    private function countLiveNeighbors($x, $y)
    {
        $count = 0;

        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                $neighborX = $x + $i;
                $neighborY = $y + $j;

                if ($i == 0 && $j == 0) {
                    continue; 
                }

                if ($neighborX >= 0 && $neighborX < $this->width && $neighborY >= 0 && $neighborY < $this->height) {
                    $count += $this->board[$neighborY][$neighborX];
                }
            }
        }

        return $count;
    }
}

$game = new GameOfLife(25, 25);

$game->setCell(12, 12, 1);
$game->setCell(13, 13, 1);
$game->setCell(11, 14, 1);
$game->setCell(12, 14, 1);
$game->setCell(13, 14, 1);

for ($i = 0; $i < 10; $i++) {
    $game->printBoard();
    $game->evolve();
}
