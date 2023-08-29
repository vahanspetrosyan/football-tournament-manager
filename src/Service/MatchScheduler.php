<?php

namespace App\Service;

use ErrorException;

class MatchScheduler
{
    /**
     * @throws ErrorException
     */
    public static function scheduler($teams): array
    {
        // Round-robin tournament
        $totalTeams = count($teams);
        if ($totalTeams % 2 != 0) {
            throw new ErrorException('Make sure you have an even number of teams', 400);
        }

        $schedule = [];
        $rounds = $totalTeams - 1;
        $matchesPerRound = $totalTeams / 2;

        for ($round = 0; $round < $rounds; $round++) {
            $roundMatches = [];
            for ($match = 0; $match < $matchesPerRound; $match++) {
                $home = ($round + $match) % ($totalTeams - 1);
                $away = ($totalTeams - 1 - $match + $round) % ($totalTeams - 1);

                if ($match == 0) {
                    $away = $totalTeams - 1;
                }

                $roundMatches[] = [
                    "Home" => $teams[$home],
                    "Away" => $teams[$away]
                ];
            }
            $schedule[] = $roundMatches;
        }

        return $schedule;

        //$days = [];
        //$away = array_splice($teams, ($totalTeams / 2));
        //$home = $teams;
        //for ($i = 0; $i < count($home) + count($away) - 1; $i++) {
        //    for ($j = 0; $j < count($home); $j++) {
        //        $days[$i][$j]["Home"] = $home[$j];
        //        $days[$i][$j]["Away"] = $away[$j];
        //    }
        //    if (count($home) + count($away) - 1 > 2) {
        //        $newArray = array_splice($home, 1, 1);
        //        array_unshift($away, array_shift($newArray));
        //        $home[] = array_pop($away);
        //    }
        //}
        //return $days;
    }
}
