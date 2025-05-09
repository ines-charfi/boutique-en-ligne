document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.getElementById('autocomplete-results');
    if(!searchInput) return;

    searchInput.addEventListener('input', function(e) {
        const term = e.target.value.trim();
        if(term.length > 2) {
            fetch('index.php?page=autocomplete&term=' + encodeURIComponent(term))
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = '';
                    data.forEach(livre => {
                        const div = document.createElement('div');
                        div.textContent = livre.titre;
                        div.onclick = () => window.location = 'index.php?page=livre_detail&id=' + livre.id;
                        resultsContainer.appendChild(div);
                    });
                });
        } else {
            resultsContainer.innerHTML = '';
        }
    });
});
// Autocomplétion
document.getElementById('search-input').addEventListener('input', function(e) {
    let val = e.target.value;
    let results = document.getElementById('autocomplete-results');
    if (val.length > 2) {
        fetch('index.php?page=autocomplete&term=' + encodeURIComponent(val))
            .then(r => r.json())
            .then(data => {
                results.innerHTML = '';
                data.forEach(livre => {
                    let div = document.createElement('div');
                    div.textContent = livre.titre;
                    div.onclick = () => window.location = 'index.php?page=livre_detail&id=' + livre.id;
                    results.appendChild(div);
                });
            });
    } else {
        results.innerHTML = '';
    }
});

// Filtrage AJAX par catégorie
document.querySelectorAll('.btn-filtre').forEach(btn => {
    btn.addEventListener('click', function() {
        let catId = this.getAttribute('data-id');
        fetch('index.php?page=filtrer_livres&categorie_id=' + catId)
            .then(r => r.json())
            .then(data => {
                let grid = document.getElementById('livres-grid');
                grid.innerHTML = '';
                data.forEach(livre => {
                    let div = document.createElement('div');
                    div.className = 'book-card';
                    div.innerHTML = `
                        <img src="assets/images/${livre.image}" alt="${livre.titre}">
                        <h3>${livre.titre}</h3>
                        <p>${livre.auteur}</p>
                        <div class="price">${parseFloat(livre.prix).toFixed(2)} €</div>
                        <a href="index.php?page=livre_detail&id=${livre.id}" class="btn">Voir détail</a>
                    `;
                    grid.appendChild(div);
                });
            });
    });
});
// Filtrage AJAX par catégorie
document.querySelectorAll('.btn-filtre').forEach(btn => {
    btn.addEventListener('click', function() {
        let catId = this.getAttribute('data-id');
        fetch('index.php?page=filtrer_livres&categorie_id=' + catId)
            .then(r => r.json())
            .then(data => {
                let grid = document.getElementById('livres-grid');
                grid.innerHTML = '';
                data.forEach(livre => {
                    let div = document.createElement('div');
                    div.className = 'book-card';
                    div.innerHTML = `
                        <img src="assets/images/${livre.image}" alt="${livre.titre}">
                        <h3>${livre.titre}</h3>
                        <p>${livre.auteur}</p>
                        <div class="price">${parseFloat(livre.prix).toFixed(2)} €</div>
                        <a href="index.php?page=livre_detail&id=${livre.id}" class="btn">Voir détail</a>
                    `;
                    grid.appendChild(div);
                });
            });
    });
});

