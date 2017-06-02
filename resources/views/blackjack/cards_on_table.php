<div id="cards">
    <?php foreach($cards as $card) : ?>
        <div><?php echo $card ?></div>

    <?php endforeach; ?>
    <?php foreach($cards as $card) : ?>
        <?php
            //width 146px
            //height:197px

            $card_value = $card->value;
            if($card_value == 'A') $card_value = 1;
            elseif($card_value == 'J') $card_value = 11;
            elseif($card_value == 'Q') $card_value = 12;
            elseif($card_value == 'K') $card_value = 13;

            $card_value--;

            $card_color = $card->suit;
            if($card_color == 'clubs') $card_color = 0;
            elseif($card_color == 'spades') $card_color = 1;
            elseif($card_color == 'hearts') $card_color = 2;
            elseif($card_color == 'diamonds') $card_color = 3;

        ?>

        <div style="display:inline-block;width:146px;height:197px;background:url('http://<?php echo $url?>/cards.png');background-position: -<?php echo ($card_value * 146) ?>px -<?php echo ($card_color * 197) ?>px;">
            
        </div>
    <?php endforeach; ?>
</div>

