document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-category');
    const livresGrid = document.getElementById('livres-grid');

    if (filterButtons.length > 0 && livresGrid) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const categoryId = this.dataset.categoryId;
                
                fetch(`index.php?page=filtrer&category_id=${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        livresGrid.innerHTML = '';
                        data.forEach(livre => {
                            const card = document.createElement('div');
                            card.className = 'livre-card';
                            card.innerHTML = `
                                <img src="assets/images/${livre.image}" alt="${livre.titre}">
                                <h3>${livre.titre}</h3>
                                <p class="auteur">${livre.auteur}</p>
                                <div class="price">${parseFloat(livre.prix).toFixed(2)} €</div>
                                <a href="index.php?page=detail&id=${livre.id}" class="btn">Voir détail</a>
                            `;
                            livresGrid.appendChild(card);
                        });
                    });
            });
        });
    }
});