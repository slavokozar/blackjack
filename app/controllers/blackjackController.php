<?php

namespace app\controllers;

use \codingbootcamp\tinymvc\request;
use \codingbootcamp\tinymvc\view;
use \codingbootcamp\tinymvc\config;
use theleftovers\blackjack\game;
use theleftovers\blackjack\database;

class blackjackController
{
    public function index()
    {
        if($_POST) // if the form was submitted
        {
            $game = new game();
            $game->generateDeck();
            $game->shuffleDeck();
            $json = $game->toJson();

            // create a new game
            database::query("
                INSERT
                INTO `games`
                (`started_at`, `data`)
                VALUES
                (NOW(), ?)
            ", [$json]);

        }

        // form to start new game
        $new_game_form = new view('blackjack/new_game_form');

        $list_of_games = new view('blackjack/list_of_games');
        $list_of_games->url = config::get('app.url');

        $statement = database::query("
            SELECT *
            FROM `games`
            WHERE `games`.`finished_at` IS NULL
            ORDER BY `games`.`started_at` DESC
        ");
        $games = $statement->fetchAll();
        $list_of_games->games = $games;
        
        // the document
        $document = new view('document');
        $document->content = $new_game_form. $list_of_games;
        $document->url = config::get('app.url');

        return $document;
    }

    public function play()
    {
        $game_id = request::get('id', null);

        $statement = database::query("
            SELECT *
            FROM `games`
            WHERE `games`.`id` = ?
            LIMIT 0, 1
        ", [$game_id]);

        $game_array = $statement->fetch();

        $game = new game();
        $game->fromJson($game_array['data']);

        $cards_on_table = new view('blackjack/cards_on_table');
        $cards_on_table->cards = $game->player_cards;
        $cards_on_table->url = config::get('app.url');

        $play_actions =  new view('blackjack/play_actions');
        $play_actions->game_id = $game_id;
        $play_actions->url = config::get('app.url');

        echo $cards_on_table . $play_actions;
        die();

        $document = new view('document');
        $document->content = '';

        return $document;
    }


    public function hit(){
        $game_id = request::get('id', null);

        $statement = database::query("
            SELECT *
            FROM `games`
            WHERE `games`.`id` = ? AND `games`.`finished_at` IS NULL
            LIMIT 0, 1
        ", [$game_id]);

        $game_array = $statement->fetch();

        if($game_array == null){
            $status = [
                'result' => 'null'
            ];
            echo json_encode($status);
            die();
        }


        $game = new game();
        $game->fromJson($game_array['data']);

        if($game->result != null){
            $status = [
                'result' => $game->result
            ];
            echo json_encode($status);
            die();
        }

        $game->moveTopCardToTable();

        $player_sum = 0;
        foreach($game->player_cards as $card){
            $player_sum += $card->blackjack_value;
        }

        if($player_sum == 21){
            $game->result = 'won';
        }elseif($player_sum > 21){
            $game->result = 'lost';
        }

        database::query("
              UPDATE `games`
              SET `data` = ?
              WHERE `games`.`id` = ?",
            [$game->toJson(), $game_id]);

        $status = [
            'player_cards' => $game->player_cards,
            'result' => $game->result
        ];

        echo json_encode($status);
    }

    public function stand(){
        $game_id = request::get('id', null);

        $statement = database::query("
            SELECT *
            FROM `games`
            WHERE `games`.`id` = ? AND `games`.`finished_at` IS NULL
            LIMIT 0, 1
        ", [$game_id]);

        $game_array = $statement->fetch();

        if($game_array == null){
            $status = [
                'result' => 'null'
            ];
            echo json_encode($status);
            die();
        }

        $game = new game();
        $game->fromJson($game_array['data']);

        if($game->result != null){
            $status = [
                'result' => $game->result
            ];
            echo json_encode($status);
            die();
        }

        $dealer_sum = 0;

        while($dealer_sum < 17){
            $card = $game->getTopCardFromDeck();
            $dealer_sum += $card->blackjack_value;
        }

        $player_sum = 0;
        foreach($game->player_cards as $card){
            $player_sum += $card->blackjack_value;
        }
        
        $result = 'lost';

        if($dealer_sum > 21){
            $result = 'won';
        }else{
            if($dealer_sum < $player_sum){
                $result = 'won';
            }elseif($dealer_sum == $player_sum){
                $result = 'draw';
            }
        }

        $game->result = $result;

        $status = [
            'player_cards' => $game->player_cards,
            'player_sum' => $player_sum,
            'dealer_sum' => $dealer_sum,
            'result' => $result
        ];

        echo json_encode($status);

        database::query("
            UPDATE `games`
            SET `data` = ?, `finished_at` = NOW()
            WHERE `games`.`id` = ?",
            [$game->toJson(), $game_id]);
    }
}