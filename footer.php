		</div>
        <footer>
            Made with ❤️ by MemoryOfLife and the BTE Italia Team
        </footer>
    </main>
    <!--Wordpress imports con JS in fondo per caricamento rapido-->
    <?php
        wp_enqueue_script('bte_script_parallax');
        wp_footer();
    ?>
    <!--TODO: Aggiungere script per menù a tendina se width sotto 930px-->
</body>
</html>