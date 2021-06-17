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

define('URL', 'http://bteitalia.it:8000');

// Prendo l'indice di partenza
$start = isset($_GET['start']) ? $_GET['start'] : 0;

// Ottengo la lista dei punti
$leaderboard = json_decode(
    file_get_contents(URL . '/points')
);

if ($leaderboard != null) {
    $leaderboard = $leaderboard->Leaderboard;

    // Ordino la lista per numero di punti
    sort_list($leaderboard);
}

// Ottengo la lista dei ruoli
$permissions = json_decode(
    file_get_contents(URL . '/permissions')
);

if ($permissions != null) {
    $permissions = $permissions->groups;

    // Ordino la lista e rimuovo i ruoli inutili per la classifica
    remove_ignored_roles($permissions);
}

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
                if ($leaderboard != null)
                    for ($i = $start; $i < $start + 20 && $i < count($leaderboard); $i++) {

                        // Ottengo il gruppo a cui il player appartiene
                        $role_class = get_role_class($leaderboard[$i], $permissions);
                ?>
                    <tr data-index="<?= $i; ?>">
                        <td class="rank"><?= $i + 1; ?></td>
                        <td class="username bubble-hover-trigger">
                            <img class="avatar" loading="lazy" src="https://www.mc-heads.net/avatar/<?= $leaderboard[$i]->name; ?>/25/" onerror="this.src='https:\/\/www.mc-heads.net\/avatar\/MHF_steve\/25\/';">
                            <span class="name bubble-wrapper">
                                <span class="<?= $role_class; ?>"><?= $leaderboard[$i]->name; ?></span>
                                <div class="bubble">
                                    <img class="avatar" loading="lazy" src="https://www.mc-heads.net/avatar/<?= $leaderboard[$i]->name; ?>/80/" onerror="this.src='https:\/\/www.mc-heads.net\/avatar\/MHF_steve\/50';">
                                    <h1 class="name <?= $role_class; ?>"><?= $leaderboard[$i]->name; ?></h1>
                                    <div class="decorator">
                                        <span class="decorator-title">Punti</span>
                                        <span class="decorator-value"><?= $leaderboard[$i]->score; ?></span>
                                    </div>
                                    <div class="decorator">
                                        <span class="decorator-title">Rank</span>
                                        <span class="decorator-value <?= $role_class; ?>"><?= $role_class != null ? ucfirst(str_replace('role-', '', $role_class)) : "Starter"; ?></span>
                                    </div>
                                    <div class="decorator">
                                        <span class="decorator-title">Nazione</span>
                                        <span class="decorator-value"><?= get_national_flag($leaderboard[$i], $permissions); ?></span>
                                    </div>
                                </div>
                            </span>
                        </td>
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

function remove_ignored_roles(&$list)
{
    $newList = array();

    foreach ($list as $role) {
        switch ($role->name) {
            case 'New':
            case 'Event':
            case 'default':
            case 'collab':
            case 'Twitch':
            case 'starter':
            case 'trainee':
            case 'builder':
            case 'yugoadmin':
            case 'admin':
            case 'moderator':
                break;

            default:
                $newList[$role->name] = $role->members;
        }
    }

    $list = $newList;
}

function get_role_class($user, $groups)
{
    if ($groups != null) {
        $name = $user->name;

        if (array_search($name, $groups['master']) !== false) {
            return 'role-master';
        } else if (array_search($name, $groups['expert']) !== false) {
            return 'role-expert';
        } else if (array_search($name, $groups['architect']) !== false) {
            return 'role-architect';
        }
    }

    $points = $user->score;
    if ($points >= 2000) {
        return 'role-expert';
    } else if ($points >= 1250 && $points < 2000) {
        return 'role-architect';
    } else if ($points >= 750 && $points < 1250) {
        return 'role-builder';
    } else if ($points >= 250 && $points < 750) {
        return 'role-trainee';
    }

    return null;
}

function get_national_flag($user, $groups)
{
    if($groups != null) {
        $name = $user->name;

        if (array_search($name, $groups['yugoslavia']) !== false) {
            return '🇭🇷';
        } else if (array_search($name, $groups['malta']) !== false) {
            return '🇲🇹';
        }
    }

    return '🇮🇹';
}
?>