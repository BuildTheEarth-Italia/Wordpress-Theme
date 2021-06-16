<?php
/*
Template Name: Punti classifica
Template Post Type: page
*/

define('DONOTCACHEPAGE', true);

//stampo header
get_header();

// Importo stile
wp_enqueue_style('bte_points_style');

const points_url = 'http://bteitalia.it:8000/points';

// Prendo l'indice di partenza
$start = isset($_GET['start']) ? $_GET['start'] : 0;

// Ottengo la lista dei punti
$leaderboard = json_decode(
    file_get_contents(points_url)
)->Leaderboard;

// Ordino la lista per numero di punti
sort_list($leaderboard);

?>
<div class="grass"></div>
<section class="panel commonPanel pointsPanel" id="classifica">
    <h2 class="post-title"><?php the_title(); ?></h2>
    <div class="post-content"><?php the_content(); ?></div>
    <div class="table-wrapper">
        <table>
            <thead class="table-head">
                <tr>
                    <th class="rank">#</th>
                    <th class="username">Username</th>
                    <th class="points">Punti</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php
                // Itero tutti gli elementi
                for ($i = $start; $i < $start + 20 && $i < count($leaderboard); $i++) {
                ?>
                    <tr data-index="<?= $i; ?>">
                        <td class="rank"><?= $i + 1; ?></td>
                        <td class="username"><img class="avatar" src="https://www.mc-heads.net/avatar/<?= $leaderboard[$i]->name; ?>/25/" onerror="this.src='https:\/\/www.mc-heads.net\/avatar\/MHF_steve';"><span class="name"><?= $leaderboard[$i]->name; ?></span></td>
                        <td class="points"><?= $leaderboard[$i]->score; ?></td>
                    </tr>
                <?php
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="buttons">
        <?php
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

        if ($start >= 20)
            echo '<a href="' . $uri_parts . '?start=' . ($start - 20 - $start % 20) . '" class="prev">Precedente</a>';

        if ($start + 20 <= count($leaderboard))
            echo '<a href="' .  $uri_parts . '?start=' . ($start + 20 - $start % 20) . '" class="next">Successivo</a>';
        ?>
    </div>
</section>

<?php

get_footer();

function sort_list(&$list)
{
    function cmp($a, $b)
    {
        if ($a->score == $b->score) {
            return 0;
        }

        return ($a->score > $b->score) ? -1 : 1;
    }

    usort($list, 'cmp');
}

?>