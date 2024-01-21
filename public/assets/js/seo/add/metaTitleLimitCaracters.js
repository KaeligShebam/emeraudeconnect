document.addEventListener('DOMContentLoaded', function() {
    // Sélectionnez l'élément textarea par son ID
    var metaTitleTextarea = document.getElementById('add_page_seo_metaTitle');

    // Fonction pour mettre à jour le compteur
    function updateTitleCharCount() {
        var maxLength = 60;
        var currentLength = metaTitleTextarea.value.length;

        // Supprimer les caractères excédentaires si la limite est dépassée
        if (currentLength > maxLength) {
            metaTitleTextarea.value = metaTitleTextarea.value.substring(0, maxLength);
            currentLength = maxLength;
        }

        var remainingChars = maxLength - currentLength;

        // Sélectionnez l'élément pour afficher le compteur
        var charCountElement = document.getElementById('title-char-count');

        // Condition pour le pluriel et le singulier
        var charCountMessage = remainingChars + (remainingChars > 1 ? ' caractères restants' : ' caractère restant');
        charCountElement.textContent = charCountMessage;
    }

    // Mettez à jour le compteur lorsqu'il y a une saisie
    metaTitleTextarea.addEventListener('input', updateTitleCharCount);

    // Appelez la fonction au chargement de la page
    updateTitleCharCount();
});