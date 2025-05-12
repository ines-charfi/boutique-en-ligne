// Gestion AJAX pour l'ajout au panier
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
