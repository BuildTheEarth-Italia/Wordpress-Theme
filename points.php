<?php
/*
Template Name: Punti classifica
Template Post Type: page
*/

define('DONOTCACHEPAGE', true);

// Importo lo stile della tabella
wp_enqueue_style('bte_points_style');

// Stampo l'header
get_header();

// Dico a Wordpress di caricare il gile Javascript per gli utenti online
wp_enqueue_script('bte_points_online_players_loader');

// Path al file di cache e durata massima, se sono rimossi non verrà eseguita la cache
define('CACHE_FILENAME', WP_CONTENT_DIR . '/cache/classifica-cached.json'); // Default: WP_CONTENT_DIR . '/cache/classifica-cached.json'

$leaderboard = array();
$permissions = new stdClass();
$playtime = new stdClass();

$gotCachedData = defined('CACHE_FILENAME') && obtainCachedDataIfAvailable($leaderboard, $permissions, $playtime);

// Se non sono riuscito a caricare la cache carico le risorse "fresche"
if (!$gotCachedData)
    obtainFreshData($leaderboard, $permissions, $playtime);

// Prendo l'indice di partenza
$start = filter_input(INPUT_GET, 'start', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

// Se l'input non è valido cado nel valore di default (zero)
if ($start === null || $start === false)
    $start = 0;

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
                    <tr data-index="<?= $i; ?>" data-username="<?= $leaderboard[$i]->name; ?>">
                        <td class="rank"><?= $i + 1; ?></td>
                        <td class="username bubble-hover-trigger">
                            <img class="avatar" loading="lazy" src="https://www.mc-heads.net/avatar/<?= $leaderboard[$i]->name; ?>/25/" onerror="this.src='https:\/\/www.mc-heads.net\/avatar\/MHF_steve\/25\/';">
                            <span class="name bubble-wrapper">
                                <span class="<?= $role_class; ?>"><?= $leaderboard[$i]->name; ?></span>
                                <div class="bubble<?= ($i < $start + 3) ? ' upside-down' : ''; ?>">
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
                                    <?php
                                    $currentPlayerPlaytime = $playtime->{$leaderboard[$i]->name};

                                    if ($currentPlayerPlaytime !== null) { ?>
                                        <div class="decorator playtime">
                                            <span class="decorator-title">Tempo di gioco</span>
                                            <span class="decorator-value"><?= $currentPlayerPlaytime; ?></span>
                                        </div>
                                    <?php } ?>
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

// Avvio lo script per il caricamento dei player online
echo '<script>loadOnlineUsers("' . get_option('bte_points_api_url', 'http://localhost:8000') . '");</script>';

flush();

if (!$gotCachedData)
    saveFreshData($leaderboard, $permissions, $playtime);

function get_role_class($user, $groups)
{
    if ($groups != null) {
        $name = $user->name;

        if (is_array($groups->master) && array_search($name, $groups->master) !== false) {
            return 'role-master';
        } else if (is_array($groups->expert) && array_search($name, $groups->expert) !== false) {
            return 'role-expert';
        } else if (is_array($groups->architect) && array_search($name, $groups->architect) !== false) {
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
    if ($groups != null) {
        $name = $user->name;

        if (array_search($name, $groups->yugoslavia) !== false) {
            return '🇭🇷';
        } else if (array_search($name, $groups->malta) !== false) {
            return '🇲🇹';
        }
    }

    return '🇮🇹';
}

function obtainCachedDataIfAvailable(&$points, &$groups, &$time)
{
    $cacheExpiryDays = get_option('bte_points_cache_days', '2');

    // Se la cache è disabilitata ritorno false
    if ($cacheExpiryDays == 0)
        return false;

    $f = @fopen(CACHE_FILENAME, 'r');

    // Se il file non esiste ritorno false
    if ($f === false)
        return false;

    // Ottengo i dati dal JSON
    $cachedData = json_decode(
        fread($f, filesize(CACHE_FILENAME))
    );

    // Chiudo il file
    fclose($f);

    // Verifico che siano passati almeno 2 gorni
    $isCacheExpired = DateTimeImmutable::createFromFormat('U', $cachedData->cacheDate)->add(new DateInterval(
        'P' . $cacheExpiryDays . 'D'
    )) < new DateTimeImmutable();

    // Se la cache è scauta ritorno false
    if ($isCacheExpired)
        return false;

    // Salvo i punti
    $points = $cachedData->points;

    // i ruoli...
    $groups = $cachedData->groups;

    // e il playtime
    $time = $cachedData->playtime;

    // Ritorno con successo
    return true;
}

function obtainFreshData(&$points, &$groups, &$time)
{
    // Ottengo la lista dei punti
    $tmpPoints = fetchRemoteData('/points');

    if ($tmpPoints != null) {
        $tmpPoints = $tmpPoints->Leaderboard;

        // Ordino la lista per numero di punti
        function cmp($a, $b)
        {
            if ($a->score == $b->score) {
                return 0;
            }

            return ($a->score > $b->score) ? -1 : 1;
        }
        usort($tmpPoints, 'cmp');

        // Assegno il valore alla variabile globale
        $points = $tmpPoints;
        unset($tmpPoints);
    }

    // Ottengo la lista dei ruoli
    $tmpGroups = fetchRemoteData('/permissions');

    if ($tmpGroups != null) {
        $tmpGroups = $tmpGroups->groups;

        // Ordino la lista e rimuovo i ruoli inutili per la classifica
        foreach ($tmpGroups as $role) {
            switch ($role->name) {
                case 'master':
                case 'expert':
                case 'architect':
                case 'yugoslavia':
                case 'malta':
                    // Assegno il gruppo a variable locale
                    $groups->{$role->name} = $role->members;
                    break;
            }
        }

        // Rimuovo la variabile temporanea
        unset($tmpGroups);
    }

    // Ottengo la lista dei ruoli
    $tmpPlaytime = fetchRemoteData('/playtime');

    if ($tmpPlaytime != null) {
        $tmpPlaytime = $tmpPlaytime->playtime;

        // Ordino la lista e modifico il tempo di gioco
        foreach ($tmpPlaytime as $entry) {
            $t = $entry->ticks;

            // Converto il tempo da ticks al formato "umano"
            $seconds = (int) ($t / 20);
            $minutes = (int) ($seconds / 60);
            $hours = (int) ($minutes / 60);
            $days = (int) ($hours / 24);

            // Creo la stringa
            if ($days > 0)
                $time->{$entry->name} = $days . ' giorni, ';
            if (($hours % 24) > 0)
                $time->{$entry->name} .= $hours % 24 . ' ore, ';
            $time->{$entry->name} .= $minutes % 60 . ' minuti e ';
            $time->{$entry->name} .= $seconds % 60 . ' secondi';
        }

        // Rimuovo la variabile temporanea
        unset($tmpPlaytime);
    }
}

function saveFreshData($points, $groups, $time)
{
    // Creo la cartella se non esiste
    wp_mkdir_p(dirname(CACHE_FILENAME));

    // Apro il file cancellando tutto il contenuto
    $f = fopen(CACHE_FILENAME, 'w');

    // Se il file non puo essere creato ritorno false
    if ($f === false)
        return false;

    // Ottengo i dati dal JSON
    $serializedCachedData = json_encode(
        array(
            'cacheDate' => time(),
            'points' => $points,
            'groups' => $groups,
            'playtime' => $time
        )
    );

    fwrite($f, $serializedCachedData);

    // Chiudo il file
    fclose($f);

    // Ritorno con successo
    return true;
}

function fetchRemoteData($endpoint)
{
    // Apro cURL 
    $ch = curl_init(get_option('bte_points_api_url', 'http://localhost:8000') . $endpoint);

    // Parametri di configurazione di cURL
    curl_setopt_array(
        $ch,
        array(
            // Dico a cURL di darmi il risultato e non inviarmi gli headers di HTTP
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,

            // Impongo di seguire i redirect
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER => true,

            // Imposto il formato di un risultato accettabile
            CURLOPT_HTTPHEADER => array(
                'Accept' => 'application/json'
            ),
        )
    );

    // Parsing del JSON
    $decodedJSON2Return = json_decode(
        curl_exec($ch)
    );

    print_r(curl_error($ch));

    // Chiudo la connessione
    curl_close($ch);

    return $decodedJSON2Return;
}

?>
