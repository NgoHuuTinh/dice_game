<?php

function rollDice($numDice)
{
    $dice = [];
    for ($i = 0; $i < $numDice; $i++) {
        $dice[] = rand(1, 6);
    }
    return $dice;
}

function playDiceGame($numPlayers, $numDice)
{
    $players = array_fill(1, $numPlayers, $numDice);
    $points = array_fill(1, $numPlayers, 0);

    while (count($players) > 1) {
        echo "=================================\n";
        echo "Current standings:\n";
        foreach ($points as $player => $score) {
            echo "Player #$player: $score points\n";
        }
        echo "=================================\n";
        echo "Rolling the dice...\n";

        foreach ($players as $player => $numDice) {
            $rolls = rollDice($numDice);
            echo "Player #$player rolls: " . implode(', ', $rolls) . "\n";

            $newRolls = [];
            foreach ($rolls as $roll) {
                if ($roll == 6) {
                    $points[$player]++;
                } elseif ($roll == 1) {
                    $nextPlayer = $player < $numPlayers ? $player + 1 : 1;
                    $players[$nextPlayer]++;
                } else {
                    $newRolls[] = $roll;
                }
            }

            $players[$player] = count($newRolls);
        }

        $players = array_filter($players, function ($numDice) {
            return $numDice > 0;
        });
    }

    $winner = array_keys($points, max($points))[0];
    echo "=================================\n";
    echo "Game over! Player #$winner wins with {$points[$winner]} points!\n";
}

// Example usage:
$numPlayers = intval(readline("Enter the number of players: "));
$numDice = intval(readline("Enter the number of dice per player: "));
playDiceGame($numPlayers, $numDice);
