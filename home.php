<?php
//stampo header
get_header();

// Richiedo lo script per il testo mobile
wp_enqueue_script('bte_text_changer');

//ottengo le foto
$photos = get_photos_from_bte_theme_showcase();

if (count($photos) > 0)
  //importo script per galleria
  wp_enqueue_script('bte_script_gallery');
?>


<div class="welcomeCover custom-background lax" data-lax-translate-y="0 0, 600 -80"></div>
<section class="panel welcomePanel lax" data-lax-opacity="80 1, 180 0" data-lax-translate-y="0 -0, 100 -25, 210 -40">
  <h1 class="staticText"><?= get_option('bte_main_sentence'); ?></h1>
    <h2 class="dynamicText underlined">su Build The Earth Italia</h2>
</section>

  <div class="grass"></div>
  <section class="panel commonPanel" id="chi-siamo">
    <div class="box">
      <div class="text">
        <h1 class="title">Chi siamo</h1>
        <p class="description"><i>Build The Earth Italia</i> &egrave; una community che nasce durante il Lockdown <wbr>per gestire il progetto <abbr translate="no" title="Build The Earth">BTE</abbr> nella nostra nazione 🇮🇹.</p>
      </div>
      <img class="model rounded" src="<?= get_template_directory_uri(); ?>/resources/castelloCornedoSquared.png" alt="Castello di Cornedo in Minecraft" loading="lazy"></div>
    </div>
  </section>

  <section class="panel commonPanel reverse" id="il-progetto">
    <div class="box">
      <div class="text">
        <h1 class="title">Il nostro progetto</h1>
        <p class="description">Noi di <i><abbr translate="no" title="Build The Earth">BTE</abbr> Italia</i> ci occupiamo di portare avanti un ambizioso progetto, <wbr>quello di ricostruire la Terra in scala reale su Minecraft, <wbr>direttamente dal proprio PC!</p>
      </div>
      <img class="model rounded" src="<?= get_template_directory_uri(); ?>/resources/ponteSquared.png" alt="Ponte in Minecraft" loading="lazy"></div>
    </div>
  </section>

  <section class="panel commonPanel" id="perche">
    <div class="box">
      <div class="text">
        <h1 class="title">Perch&eacute;?</h1>
        <p class="description">Con l'avvento di Internet possiamo scoprire nuove culture, idee e persone. <wbr>Proprio su questo si basa <i><abbr translate="no" title="Build The Earth">BTE</abbr> Italia</i>, mostrare le bellezze dell'Italia agli altri.</p>
      </div>
      <img class="model rounded" src="<?= get_template_directory_uri(); ?>/resources/centroCommercialeSquared.png" alt="Centro commerciale in Minecraft" loading="lazy"></div>
    </div>
  </section>

  <section class="panel textMediaPanel" id="partecipa">
    <div class="box">
      <div class="text">
        <h1 class="title">Partecipa</h1>
        <p class="description">Sei interessato? Vuoi partecipare?<br>Tutto quello che devi fare è entrare <wbr>nel server Discord!</p>
      </div>
      <iframe class="media" loading="lazy" allowtransparency="true" frameborder="0" src="https://discordapp.com/widget?id=686910132017430538&amp;theme=light"></iframe>
      <a href="https://discord.com/invite/dMahHCH" title="Il nostro server Discord" class="discordJoinButton">Unisciti</a>
    </div>
  </section>
  <?php
    if (count($photos) > 0) { ?>
      <section class="panel galleryPanel" id="galleria">
        <div class="box">
          <div class="text">
            <h1 class="title">Galleria</h1>
          </div>
          <div class="gallery">
            <div class="slider lax animateMargin" data-lax-translate-x="2400 50, 3800 -150">
              <?php
              //itero liste foto per stamparle in html
              foreach ($photos as $id => $photo) {
              ?>
                <figure class="media" data-gallery-id="<?= $id ?>">
                  <img class="image" src="<?= $photo->path ?>" class="media" loading="lazy" alt="<?= $photo->title ?> - <?= $photo->description ?>" draggable="false" />
                </figure>
              <?php } ?>
            </div>
          </div>
        </div>
      </section>
    <?php } ?>

<script>
  window.sentences = [
    <?php
    $sentences = str_replace("'", "\\'", get_option('bte_second_sentences'));
    $sentences_list = explode("\n", $sentences);

    echo str_replace(
      array("\r", "\n"), 
      "", 
      "'" . implode("', '", $sentences_list) . "'"
    );
    ?>
  ];
</script>

<?php

//stampo footer
get_footer();
?>