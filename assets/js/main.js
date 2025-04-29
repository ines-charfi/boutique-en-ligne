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
