// Gestion du panier
document.querySelectorAll('.form-ajout-panier').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mise à jour visuelle du panier
                document.querySelector('.panier-count').textContent = data.count;
            }
        });
    });
});

// Gestion de la recherche

document.addEventListener('DOMContentLoaded', function() {
    // Autocomplétion recherche
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.getElementById('autocomplete-results');
    if (searchInput && resultsContainer) {
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.trim();
            if (term.length > 2) {
                fetch('index.php?page=autocomplete&term=' + encodeURIComponent(term))
                    .then(r => r.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';
                        data.forEach(livre => {
                            const div = document.createElement('div');
                            div.className = 'autocomplete-item';
                            div.innerHTML = `<img src="assets/images/${livre.image}" style="width:40px;height:60px;margin-right:10px;">${livre.titre}`;
                            div.onclick = () => window.location = 'index.php?page=livre_detail&id=' + livre.id;
                            resultsContainer.appendChild(div);
                        });
                    });
            } else {
                resultsContainer.innerHTML = '';
            }
        });
    }

    // Filtrage AJAX par catégorie
  // Dans boutique.js et main.js
document.querySelectorAll('.btn-filtre').forEach(btn => {
    btn.addEventListener('click', function() {
        const catId = this.dataset.id;
        fetch(`index.php?page=filtrer&categorieid=${catId}`) // URL corrigée
      
                .then(r => r.json())
                .then(data => {
                    const grid = document.getElementById('livres-grid');
                    grid.innerHTML = '';
                    data.forEach(livre => {
                        const div = document.createElement('div');
                        div.className = 'book-card';
                        div.innerHTML = `
                            <img src="assets/images/${livre.image}" alt="${livre.titre}">
                            <h3>${livre.titre}</h3>
                            <p>${livre.auteur}</p>
                            <p>${livre.description}</p>
                            <div class="price">${parseFloat(livre.prix).toFixed(2)} €</div>
                            <a href="index.php?page=livre_detail&id=${livre.id}" class="btn">Voir détail</a>
                        `;
                        grid.appendChild(div);
                    });
                });
        });
    });
});
