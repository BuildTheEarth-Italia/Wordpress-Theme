<footer class="footer">
    <div class="box">
      <div class="brand">
        <img class="logo" src="<?= get_site_icon_url(36) ?>" alt="Lugo ufficiale di  <?= get_bloginfo('name') ?>" />
        <p class="name"> <?= get_bloginfo('name') ?></p>
      </div>
      <div id="contacts" class="contacts">
        <p>Contatti:</p>
        <div class="link">
          <i class="fas fa-envelope"></i>
          <a href="mailto:bteitalia@gmail.com">Email</a>
        </div>
        <div class="link">
          <i class="fab fa-discord"></i>
          <a href="https://discord.com/invite/dMahHCH">Discord</a>
        </div>
      </div>
    </div>
    <p class="credits">
      Made with ❤️ by the <a href="https://github.com/BTE-Italia">BTE Italia team</a>
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