<?php   
    //importo configurazioni del sito
    require_once("./site.config.php");

    //importo il file di autenticazione
    require_once("./api/authenticator.php");
    //avvio sessione
    session_start();
    //verifico che le sessione sia valida
    $logged_in = Authenticator::checkSession($_COOKIE["session"]);
    
    //controllo esistenza parametro GET id in url
    if(!isset($_GET["id"])) {
        header("HTTP/1.1 400 Bad Request");
        header("Location: " . PATH . "index.php");
    }

    //ottengo il link al db
    $link = Config::getLink();

    //carico le foto da mysql
    $query = $link->prepare("SELECT path, title, author, position FROM showcase LIMIT 10");
    if($query->execute()) {
		$arr = $query->fetchAll(PDO::FETCH_OBJ);
		
		//scelgo una foto a caso come sfondo
		$key = array_rand($arr);
		$bg = PATH . "resources/uploads/" . $arr[$key]->path;
    }

    //carico i post da mysql
    $query = $link->prepare("SELECT * FROM blog WHERE id = :id");
    if($query->execute([":id" => $_GET["id"]])) {
        $article = $query->fetch(PDO::FETCH_OBJ);
        
        //formatto la data
        $date = new DateTime($article->date);
        $date = $date->format('d/m/Y') . " alle " . $date->format('H:i');

        //formatto il nome del creatore
        $query = $link->prepare("SELECT username FROM auth WHERE id = :id");
        $query->execute([":id" => $article->author]);
        $author = $query->fetch(PDO::FETCH_ASSOC)["username"];
    }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildTheEarth Italia | <?php echo $article->title;?></title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" rel="stylesheet">
    <link href="./style/style.css" rel="stylesheet"/>
    <link href="./style/section.css" rel="stylesheet"/>	
    <link href="./style/blog.css" rel="stylesheet"/>	
	<?php if(isset($bg)) {?>
		<!-- sfondo -->
		<style>
			body {
				background-image: url("<?php echo $bg; ?>");
			}
		</style>
	<?php } ?>
</head>
<body class="lax" data-lax-bg-pos-y="0 0, 600 -30">
    <nav class="mainNav lax" data-lax-bg-pos-y="0 0, 600 -30">
        <a href="./index.php" rel="home" class="navItem navLogo"><img src="./resources/logo.gif" alt="Home"/> BuildTheEarth Italia</a>
        <a href="./index.php#play" class="navItem navPlay"><i class="fas fa-gamepad"></i> Play</a>
        <a href="./index.php#map" class="navItem navMap"><i class="fas fa-map"></i> Mappa</a>
        <a href="./index.php#discord" class="navItem navDiscord"><i class="fab fa-discord"></i> Discord</a>
    </nav>
    <header class="heading lax" data-lax-opacity="100 1, 200 0.8, 310 0" data-lax-translate-y="0 -0, 200 -15, 310 -40">
        <h1><?php echo $article->title;?></h1>
        <?php
            //stampo autore e data
            echo "<p>Postato da {$author} il {$date}</p>" . ($logged_in ? "<a href=\"#\" onclick=\"deletePost({$article->id});\"><i class=\"fas fa-trash-alt\"></i> Elimina</a>" : "");
        ?>
    </header>
    <main class="content">
        <img src="./resources/grass-pattern.svg" class="grass"/>
        <article class="card postContent">
            <p><?php echo $article->text; ?></p>
        </article>
        <footer>
            Made with ❤️ by MemoryOfLife and the BTE Italia Team
        </footer>
    </main>

    <!--JS in fondo per caricamento rapido-->
    <script src="https://cdn.jsdelivr.net/npm/lax.js"></script>
    <?php
        //se sono admin importo script per cancellare il post
        if($logged_in) {
            echo "<script src=\"./js/admin.js\" async></script>";
        }
    ?>
    <script>
        lax.setup(); //avvio lax
		const nav = document.querySelector(".mainNav"); //reference alla navbar

        const updateOnScroll = () => {
			//aggiorno lax
            lax.update(window.scrollY);
			
			<?php if(isset($bg))
			    echo "nav.style.backgroundImage = (window.scrollY >= 505 ? \"url(\\\"{$bg}\\\")\" : \"none\")";?>
			
			//animo nuovamente
            window.requestAnimationFrame(updateOnScroll);
        }
        window.requestAnimationFrame(updateOnScroll);
    </script>
</body>
</html>
