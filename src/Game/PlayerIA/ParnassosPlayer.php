<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class ParnassosPlayers
 * @package Hackathon\PlayerIA
 * @author Nathan Tournant
 */
class ParnassosPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;

    public function getChoice()
    {
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Choice           ?    $this->result->getLastChoiceFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Choice ?    $this->result->getLastChoiceFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get all the Choices          ?    $this->result->getChoicesFor($this->mySide)
        // How to get the opponent Last Choice ?    $this->result->getChoicesFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get the stats                ?    $this->result->getStats()
        // How to get the stats for me         ?    $this->result->getStatsFor($this->mySide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // How to get the stats for the oppo   ?    $this->result->getStatsFor($this->opponentSide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // -------------------------------------    -----------------------------------------------------
        // How to get the number of round      ?    $this->result->getNbRound()
        // -------------------------------------    -----------------------------------------------------
        // How can i display the result of each round ? $this->prettyDisplay()
        // -------------------------------------    -----------------------------------------------------

        if ($this->result->getNbRound() == 0) {
            return parent::rockChoice();
        }

        if ($this->result->getNbRound()%10 >= 8 && $this->result->getLastScoreFor($this->mySide) <= 1){
            return $this->getOpposite($this->result->getLastChoiceFor($this->mySide));
        }

        return $this->getOpposite(
            $this->getNextMove(
                $this->result->getChoicesFor($this->opponentSide)
            )
        );
    }

    private function getOpposite($choice) {
        switch ($choice)
        {
            case parent::scissorsChoice():
                return parent::rockChoice();
            case parent::paperChoice():
                return parent::scissorsChoice();
            case parent::rockChoice():
            default:
                return parent::paperChoice();

        }
    }
    private function getNextMove($pastChoices) {
        $rock = 0;
        $paper = 0;
        $scissors = 0;
        foreach ($pastChoices as $key => $value) {
            $coef = 1 * (int)$key/300;
            switch ($value) {
                case 'rock':
                    $rock += $coef;
                    break;
                case 'scissors':
                    $scissors += $coef;
                    break;
                case 'paper':
                default:
                    $paper += $coef;
            }
        }
        return max($rock, $paper, $scissors);
    }
};
