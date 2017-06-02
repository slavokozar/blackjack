<?php

namespace theleftovers\blackjack;

class card
{
    // possible suits and values - we will use them to generate the deck
    public static $possible_suits = ['hearts', 'spades', 'clubs', 'diamonds'];
    public static $possible_values = ['2','3','4','5','6','7','8','9','10','J','Q','K','A'];

    // properties of each particular card
    public $suit = null; // hearts, spades, clubs, diamonds
    public $value = null; // 2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A
    public $blackjack_value = null; // 1-11

    public function __construct($suit, $value)
    {
        $this->suit = $suit;
        $this->value = $value;

        $this->blackjack_value = $this->getBlackJackValue();
    }

    public function __toString()
    {
        return '<div class="card">'.$this->suit.' | '.$this->value.'</div>';
    }

    public function getBlackJackValue()
    {
        switch($this->value)
        {
            case '2':
            case '3':
            case '4':
            case '5':
            case '6':
            case '7':
            case '8':
            case '9':
            case '10':
                return (int)$this->value;
                break;
            case 'J':
            case 'Q':
            case 'K':
                return 10;
                break;
            case 'A':
                return 11;
            default:
                return 0; // should not happen
                break;
        }
    }
}