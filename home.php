<?php
//stampo header
get_header();

//ottengo le foto
$photos = get_photos_from_bte_theme_showcase();

if(count($photos) > 0) {
	//importo script per galleria
	wp_enqueue_script('bte_script_gallery');
?>
<section class="card" id="gallery" style="flex-direction: column;">
	<div class="text">
		<h1 class="title">Galleria</h1>
	</div>
	<div class="gallery" data-gallery-max="<?=count($photos)?>" data-gallery-current-photo="0">
	<?php
		//itero liste foto per stamparle in html
		foreach($photos as $id => $photo) {
			//se nascoste le elimino
			if(!$photo->visible) continue;
			?>
			<figure class="galleryItem" data-gallery-id="<?=$id?>">
				<img src="<?=$photo->path?>" class="media" loading="lazy"/>
				<figcaption class="description">
					<h1 class="title"><?=$photo->title?></h1>
					<span class="detail"><?=$photo->description?></span>
				</figcaption>
			</figure>
		<?php } ?>
	</div>
</section>
<?php } ?>
<section class="card map" id="map">
	<iframe class="media" loading="lazy" allowtransparency="true" frameborder="0" src="https://www.google.com/maps/d/u/1/embed?mid=1lVkAeyFwAYxxSWIuUffjuLsLmqfjFRlK"></iframe>
	<div class="description">
		<h1 class="title">Mappa delle costruzioni</h1>
		<p class="detail">Ecco tutti i luoghi in cui stiamo costruendo! Sono davvero tantissimi!</p>
	</div>
	<img  class="block lax" data-lax-rotate="430 0, 1430 15" src="<?=get_template_directory_uri()?>/resources/blocks/bricks.png"/>
</section>
<section class="card discord" id="discord">
	<img  class="block right lax" data-lax-rotate="1260 -15, 2260 -20" src="<?=get_template_directory_uri()?>/resources/blocks/diamond-pickaxe.png"/>
	<iframe class="media" loading="lazy" allowtransparency="true" frameborder="0" src="https://discordapp.com/widget?id=686910132017430538&amp;theme=light"></iframe>
	<div class="description">
		<h1 class="title">Discord</h1>
		<p class="detail">Discord è il posto perfetto per parlare, divertirsi o perdere tempo &#x1F60B;!<br />Sei curioso ora? Passa a fare un salto con il widget accanto!</p>
	</div>
</section>
<section class="card supportus" id="supportus">
	<div class="text">
		<h1 class="title">Supportaci</h1>
		<p class="detail">Anche noi abbiamo bisogno di fondi &#x1F4B8;!<br />Vuoi sostenerci? Non esiteremo a ringraziarti!</p>
		<a href="https://www.paypal.me/bteitaliadonations" class="button"><img loading="lazy" src="<?=get_template_directory_uri()?>/resources/paypal-logo.png" height="50" alt="PayPal logo"/></a>
	</div>
	<img  class="block lax" data-lax-rotate="1670 10, 2600 20" src="<?=get_template_directory_uri()?>/resources/blocks/diamond.png"/>
</section>
<section class="card play" id="play">
	<div class="text">
		<h1 class="title">Partecipa</h1>
		<p class="detail">Sei eccitatissimo per questo progetto? Non perdere tempo allora!<br />Entra nel nostro server Discord per trovare le istruzioni.</p>
		<a href="https://discord.gg/dMahHCH" class="button" style="background-color: #7289DA;"><img loading="lazy" src="<?=get_template_directory_uri()?>/resources/Discord-Logo.svg" height="70"/></a>
	</div>
</section>
<?php
	//stampo footer
	get_footer();
?>