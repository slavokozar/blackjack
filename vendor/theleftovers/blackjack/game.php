<?php

namespace theleftovers\blackjack;

class game
{
    public $deck = []; // cards in the deck
    public $player_cards = []; // cards in front of player
    public $result = null; // won | lost | draw | null |

    public function generateDeck()
    {
        $deck = [];
        foreach(card::$possible_suits as $suit)
        {
            foreach(card::$possible_values as $value)
            { 
                $card = new card($suit, $value);

                $deck[] = $card;
            }
        }
        $this->deck = $deck;
    }

    public function shuffleDeck()
    {
        shuffle($this->deck);
    }

    public function displayDeck()
    {
        foreach($this->deck as $card)
        {
            echo $card;
        }
    }

    /**
     * shift the first card off the deck and return it
     */
    public function getTopCardFromDeck()
    {
        return array_shift($this->deck);
    }

    /**
     * takes the top card from the deck and adds it to the
     * cards on the table
     */
    public function moveTopCardToTable()
    {
        $this->player_cards[] = $this->getTopCardFromDeck();
    }

    /**
     * takes all the data from this object and creates a JSON
     * string
     */
    public function toJson()
    {
        // gather data that we want to encode into JSON
        $data = [
            'deck' => $this->deck,
            'player_cards' => $this->player_cards,
            'result' => $this->result
        ];

        // turn the gathered data into JSON string
        $json = json_encode($data);
        
        // return the string
        return $json;
    }

    public function fromJson($json)
    {
        // decode the JSON string (as associative arrays)
        $data = json_decode($json, true);

        // empty the deck and the player cards
        $this->deck = [];
        $this->player_cards = [];

        $this->result = $data['result'];

        foreach($data['deck'] as $card_array)
        {
            // create a card object for the card data
            $card = new card($card_array['suit'], $card_array['value']);
            
            // add the card object to the deck of this game object
            $this->deck[] = $card;
        }

        foreach($data['player_cards'] as $card_array)
        {
            // create a card object for the card data
            $card = new card($card_array['suit'], $card_array['value']);
            
            // add the card object to the player_cards of this game object
            $this->player_cards[] = $card;
        }
    }
}