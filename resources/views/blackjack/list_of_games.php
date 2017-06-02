<ul>
    <?php foreach($games as $game) : ?>
        <li>
            <a href="http://<?php echo $url ?>?route=play&id=<?php echo $game['id']; ?>"><?php echo $game['started_at']; ?></a>
        </li>
    <?php endforeach; ?>

</ul>