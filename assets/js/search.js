document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.getElementById('autocomplete-results');

    if (searchInput && resultsContainer) {
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.trim();
            
            if (term.length > 2) {
                fetch(`index.php?page=recherche&term=${encodeURIComponent(term)}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';
                        data.forEach(livre => {
                            const div = document.createElement('div');
                            div.classList.add('autocomplete-item');
                            div.innerHTML = `
                                <img src="assets/images/${livre.image}" alt="${livre.titre}">
                                <span>${livre.titre}</span>
                            `;
                            div.onclick = () => window.location = `index.php?page=detail&id=${livre.id}`;
                            resultsContainer.appendChild(div);
                        });
                    });
            } else {
                resultsContainer.innerHTML = '';
            }
        });
    }
});