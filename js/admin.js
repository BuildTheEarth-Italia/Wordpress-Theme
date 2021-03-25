//funzione per caricare session id
let getCookie = (name) => {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2)
	return parts.pop().split(';').shift();
}

//apro il picker al click sul bottone
const uploadPhoto = () => document.getElementById("newPhotoFile").click();

//carico sul server la nuova foto
const handlePhotoFileChange = (target) => {
	let upload = (file, title, author, position) => {
		const fd = new FormData();
		fd.append('newPhotoFile', file);
		fd.append('title', title);
		fd.append('author', author);
		fd.append('position', position);
		
		return new Promise((resolve, reject) => {
			const xhr = new XMLHttpRequest();
			
			xhr.open("POST", "./api/uploadNewPhoto.php", true);
			xhr.setRequestHeader("Authorization", getCookie("session"));

			xhr.send(fd);

			xhr.onload = () => {
				if(xhr.status === 201){
					resolve(xhr.responseText);
				} else {
					reject(xhr.responseText);
				}
			};
			xhr.onerror = () => reject(xhr.statusText);
		});
	}
	
	//unico div per campi
	let container = document.createElement("div");
	container.classList.add("box");
	container.innerHTML = `
		<label for="title" class="label">Titolo</label>
		<input class="field" type="text" id="title" required value="${target.files[0].name}"/>
		<label for="author" class="label">Autore</label>
		<input class="field" type="text" id="author" required/>
		<label for="position" class="label">Posizione</label>
		<input class="field" type="text" id="position" required/>`;

	//apro finestra
	let modal = openModal("Nuovo post", container);

	//ottengo referenza agli input
	let title = container.querySelector("#title");
	let author = container.querySelector("#author");
	let position = container.querySelector("#position");
	
	//invio il file e aggiorno la pagina
	modal.then(() => {
		upload(target.files[0], title.value, author.value, position.value).then(() => window.location.reload());
	});
	modal.catch(() => {
		closeModal();
	});
}

//carico sul server il nuovo post
const newPost = () => {
	let upload = (title, text) => {
		const fd = new FormData();
		fd.append('title', title);
		fd.append('text', text);
		
		return new Promise((resolve, reject) => {
			const xhr = new XMLHttpRequest();
			
			xhr.open("POST", "./api/createPost.php", true);
			xhr.setRequestHeader("Authorization", getCookie("session"));

			xhr.send(fd);

			xhr.onload = () => {
				if(xhr.status === 201){
					resolve(xhr.responseText);
				} else {
					reject(xhr.responseText);
				}
			};
			xhr.onerror = () => reject(xhr.statusText);
		});
	}

	//unico div per campi
	let container = document.createElement("div");
	container.classList.add("box");
	container.innerHTML = `
		<label for="title" class="label">Titolo</label>
		<input class="field" type="text" id="title" required/>
		<label for="text" class="label">Testo</label>
		<textarea class="field" type="text" id="text" required></textarea>`;

	//apro finestra
	let modal = openModal("Nuovo post", container);

	//ottengo referenza agli input
	let title = container.querySelector("#title");
	let text = container.querySelector("#text");
	
	//invio il file e aggiorno la pagina
	modal.then(() => {
		upload(title.value, text.value).then(() => window.location.reload());
	});
	modal.catch(() => {
		closeModal();
	});
}

//elimino dal server la foto
const deletePhoto = (target) => {
	let del = (id) => {
		const fd = new FormData();
		fd.append('id', id);
		
		return new Promise((resolve, reject) => {
			const xhr = new XMLHttpRequest();
			
			xhr.open("POST", "./api/deletePhoto.php", true);
			xhr.setRequestHeader("Authorization", getCookie("session"));

			xhr.send(fd);

			xhr.onload = () => {
				if(xhr.status === 200){
					resolve(xhr.responseText);
				} else {
					reject(xhr.responseText);
				}
			};
			xhr.onerror = () => reject(xhr.statusText);
		});
	}
	
	//invio il file e aggiorno la pagina
	del(target).then(() => window.location.reload());
}

const deletePost = (id) => {
    let del = (id) => {
		const fd = new FormData();
		fd.append('id', id);
		
		return new Promise((resolve, reject) => {
			const xhr = new XMLHttpRequest();
			
			xhr.open("POST", "./api/deletePost.php", true);
			xhr.setRequestHeader("Authorization", getCookie("session"));

			xhr.send(fd);

			xhr.onload = () => {
				if(xhr.status === 200){
					resolve(xhr.responseText);
				} else {
					reject(xhr.responseText);
				}
			};
			xhr.onerror = () => reject(xhr.statusText);
		});
	}
	
	//invio la richiesta e torno ad admin
	del(id).then(() => window.location.href = "./admin.php");
} 
//apro un pannello
const openSettings = (group) => {
	//reference al container dei pannelli
	let container = document.querySelector(".content");
	
	//nascondo tutti i pannelli
	let child = container.children;
	for (var i = 0; i < child.length; i++) {
		child[i].classList.add("hidden");
	}
	
	//mostro tutti i pannelli con data-settings-group=group
	let selected = container.querySelectorAll("*[data-settings-group=\"" + group + "\"]");
	for (var j = 0; j < selected.length; j++) {
		selected[j].classList.remove("hidden");
	}
}
const openModal = (title, content) => {
	//chiudo altre finestre preventivamente
	closeModal();

	//finestra
	let modal = document.createElement("div");
	modal.classList.add("modal-content");
	modal.innerHTML = `
		<label for="modal" class="close">
			<i class="fa fa-times" aria-hidden="true"></i>
		</label>
		<header>
			<h2>${title}</h2>
		</header>
		<article>
		</article>
		<footer>
			<button class="button success">Pubblica</button>
		</footer>`;
	//aggiungo contenuto
	modal.querySelector("article").appendChild(content);
	
	//background per la finestra
	let modalBg = document.createElement("div");
	modalBg.classList.add("modal-bg");

	//aggiungo elementi a body
	document.body.appendChild(modalBg);
	document.body.appendChild(modal);

	//avvio animazione
	modalBg.classList.add("visible");

	return new Promise((resolve, reject) => {
		//risolvo se premo Pubblica
		modal.querySelector("footer > .success").addEventListener("click", resolve);
		modal.querySelector("label.close").addEventListener("click", reject);
	});
}
const closeModal = () => {
	//prendo reference a bg e finestra
	let modal = document.querySelector(".modal-content");
	let modalBg = document.querySelector(".modal-bg");

	if(!modal || !modalBg)
		return;

	//avvio animazione
	modalBg.classList.remove("visible");

	//rimuovo da body dopo timeout
	setTimeout(() => {
		document.body.removeChild(modal);
		document.body.removeChild(modalBg);
	}, 251);
}
