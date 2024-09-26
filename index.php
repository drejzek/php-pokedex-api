<pre>
    <?php

        include 'pokedex-api.php';

        $pokemon = new Pokémon("audino", true);

        print_r($pokemon->getSingle());

    ?>
</pre>