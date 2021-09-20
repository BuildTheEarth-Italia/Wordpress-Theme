</main>

<?php
// Includo dashicons
wp_enqueue_script('dashicons');

$discordInvite = get_option('bte_discord_url', 'https://discord.com/invite/dMahHCH');
if (get_option('bte_discord_add_utm'))
  $discordInvite .= '?utm_source=bteitalia.it&utm_medium=discord&utm_content=footer';
?>

<footer class="footer">
  <div class="box">
    <div class="brand">
      <img class="logo" src="<?= get_site_icon_url(36) ?>" alt="Logo ufficiale di <?= get_bloginfo('name') ?>" />
      <p class="name"> <?= get_bloginfo('name') ?></p>
    </div>
    <div class="row">
      <div id="contacts" class="contacts">
        <p>Contatti</p>
        <div class="link">
          <span class="dashicons dashicons-email"></span>
          <a href="mailto:bteitalia@gmail.com">Email</a>
        </div>
        <div class="link">
          <img src="<?= get_template_directory_uri(); ?>/resources/Discord-Logo.svg" alt="Discord Logo" height="20px" width="22px" />
          <a href="<?= $discordInvite; ?>">Discord</a>
        </div>
      </div>
      <?php
      for ($i = 0; $i <= 3; $i++)
        if (has_nav_menu('footer-menu-' . $i)) {
      ?>
        <nav id="footer-menu-<?= $i; ?>" class="footer-menu">
          <p><?= wp_get_nav_menu_name('footer-menu-' . $i); ?></p>
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'footer-menu-' . $i,
              'fallback_cb' => false,
            )
          );
          ?>
        </nav>
      <?php
        } ?>
    </div>
  </div>
  <p class="credits">
    Made with ❤️ by the <a href="https://github.com/BuildTheEarth-Italia">BTE Italia team</a>
  </p>
</footer>

<!--Wordpress imports con JS in fondo per caricamento rapido-->
<?php
wp_enqueue_script('bte_script_parallax');
wp_footer();
?>
<!--TODO: Aggiungere script per menù a tendina se width sotto 930px-->
</body>

</html>