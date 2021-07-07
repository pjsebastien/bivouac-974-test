window.onload = () => {
    const FiltersForm = document.querySelector("#filters");

    //On sélectionne tous les inputs, sur lesquel on boucle l'évênement change (cocher/décocher)
    document.querySelectorAll("#filters input").forEach(input => {
        input.addEventListener("change", () => {
            //Récupère donnée form
            const Form = new FormData(FiltersForm);
            //On fabrique la queryString, qui est après le ? dans l'URL
            const Params = new URLSearchParams();
            Form.forEach((value, key) => {
                Params.append(key, value);
            })
            //On recupère l'URL active
            const Url = new URL(window.location.href);
            
            //On lance la requête Ajax, a laquelle on ajoute ajax=1 afin de pouvoir recuperer dans le controlleur et savoir si on a lancé une requête ajax ou pas
            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response => 
                response.json()
            ).then(data => {
                //On cherche la zone de contenu a remplacer
                const content = document.querySelector("#content");
                //On remplace le contenu
                content.innerHTML = data.content;
                //On met a jour l'URL
                history.pushState({}, null, Url.pathname + "?" + Params.toString())
            }).catch(e => alert(e));
        })
    });
}