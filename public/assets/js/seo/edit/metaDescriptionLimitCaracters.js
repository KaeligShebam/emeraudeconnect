document.addEventListener('DOMContentLoaded', function() {
    // Sélectionnez l'élément textarea par son ID
    var metaDescriptionTextarea = document.getElementById('edit_page_seo_metaDescription');

    // Fonction pour mettre à jour le compteur
    function updateCharCount() {
        var maxLength = 120;
        var currentLength = metaDescriptionTextarea.value.length;

        // Supprimer les caractères excédentaires si la limite est dépassée
        if (currentLength > maxLength) {
            metaDescriptionTextarea.value = metaDescriptionTextarea.value.substring(0, maxLength);
            currentLength = maxLength;
        }

        var remainingChars = maxLength - currentLength;

        // Sélectionnez l'élément pour afficher le compteur
        var charCountElement = document.getElementById('description-char-count');

        // Condition pour le pluriel et le singulier
        var charCountMessage = remainingChars + (remainingChars > 1 ? ' caractères restants' : ' caractère restant');
        charCountElement.textContent = charCountMessage;
    }

    // Mettez à jour le compteur lorsqu'il y a une saisie
    metaDescriptionTextarea.addEventListener('input', updateCharCount);

    // Appelez la fonction au chargement de la page
    updateCharCount();
});