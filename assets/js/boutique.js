document.addEventListener('DOMContentLoaded', function() {
    // Autocomplétion
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.getElementById('autocomplete-results');
    
    if (searchInput && resultsContainer) {
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.trim();
            
            if (term.length > 2) {
                try {
                    fetch('index.php?page=autocomplete&term=' + encodeURIComponent(term))
                        .then(response => {
                            if (!response.ok) throw new Error('Erreur réseau');
                            return response.json();
                        })
                        .then(data => {
                            resultsContainer.innerHTML = '';
                            data.forEach(livre => {
                                const div = document.createElement('div');
                                div.className = 'autocomplete-item';
                                div.innerHTML = `
                                    <img src="assets/images/${livre.image}" alt="${livre.titre}">
                                    <div>
                                        <h4>${livre.titre}</h4>
                                        <p>${livre.auteur}</p>
                                    </div>
                                `;
                                div.onclick = () => window.location.href = `index.php?page=livre_detail&id=${livre.id}`;
                                resultsContainer.appendChild(div);
                            });
                        })
                        .catch(error => {
                            console.error('Erreur autocomplétion:', error);
                            resultsContainer.innerHTML = '';
                        });
                } catch (error) {
                    console.error('Erreur dans le bloc try:', error);
                }
            } else {
                resultsContainer.innerHTML = '';
            }
        });

        // Cacher les suggestions quand on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!resultsContainer.contains(e.target) && e.target !== searchInput) {
                resultsContainer.innerHTML = '';
            }
        });
    } // Fin du if (searchInput && resultsContainer)

    // Filtrage
   // Dans boutique.js et main.js
document.querySelectorAll('.btn-filtre').forEach(btn => {
    btn.addEventListener('click', function() {
        const catId = this.dataset.id;
        fetch(`index.php?page=filtrer&categorieid=${catId}`) // URL corrigée
        
                .then(response => {
                    if (!response.ok) throw new Error(`Erreur HTTP ${response.status}`);
                    return response.json();
                })
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
                            <div class="price">${parseFloat(livre.prix).toFixed(2)} €</div>
                            <a href="index.php?page=livre_detail&id=${livre.id}" class="btn">Voir détail</a>
                        `;
                        grid.appendChild(div);
                    });
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert("Erreur : " + error.message);
                });
        });
    });

    // Gestion AJAX pour l'ajout au panier
    document.querySelectorAll('.form-ajout-panier').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => {
                if (!response.ok) throw new Error('Erreur réseau');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Mise à jour visuelle du panier
                    document.querySelector('.panier-count').textContent = data.count;
                } else {
                    console.error('Erreur ajout au panier:', data.message);
                }
            })
            .catch(error => {
                console.error('Erreur AJAX:', error);
            });
        });
    });
}); // Fin du DOMContentLoaded
