document.addEventListener('DOMContentLoaded', function () {
    var addRowButton = document.getElementById('addRowButtonTranslation');
    var categoryInputContainer = document.getElementById('categoryInputContainer');
    var categoryInput = document.getElementById('categoryInput');

    addRowButton.addEventListener('click', function () {
        // Rendre visible le champ de saisie de la catégorie
        categoryInputContainer.style.display = 'none';

        // Ajouter une nouvelle ligne au tableau
        var tableBody = document.querySelector('table tbody');
        var newRow = tableBody.insertRow();
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);

        // Créer des champs de saisie pour la clé, la valeur et la catégorie
        var keyInput = createInput('key', 'En anglais');
        var valueInput = createInput('value', 'En français');
        var categoryInputForRow = createInput('category', 'Nom de la catégorie');

        cell1.appendChild(keyInput);
        cell2.appendChild(valueInput);
        cell3.appendChild(categoryInputForRow);

        // Focus sur le champ de saisie de la clé pour l'entrée de l'utilisateur
        keyInput.focus();
    });

    function createInput(name, placeholder) {
        var input = document.createElement('input');
        input.type = 'text';
        input.name = name;
        input.placeholder = placeholder;
        input.classList.add('inputTranslation');
        return input;
    }

    // Add the rest of your JavaScript code here...

    document.addEventListener('click', function (event) {
        var clickedElement = event.target;
        var isInputField = clickedElement.nodeName === 'INPUT';

        if (!isInputField) {
            // Trigger save action if both key and value have non-empty values
            var lastRow = document.querySelector('table tbody tr:last-child');
            var keyInput = lastRow.querySelector('[name="key"]');
            var valueInput = lastRow.querySelector('[name="value"]');
            var categoryInput = lastRow.querySelector('[name="category"]');

            if (keyInput && valueInput && categoryInput &&
                keyInput.value.trim() !== '' && valueInput.value.trim() !== '' && categoryInput.value.trim() !== '') {
                saveTranslation(keyInput.value, valueInput.value, categoryInput.value);
            }
        }
    });

    function saveTranslation(key, value, category) {
        // Make an AJAX request to Symfony controller to add/update the translation
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/parametres/traduction/ajouter', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    console.log(JSON.parse(xhr.responseText).message);
                } else {
                    console.error('Error saving translation:', xhr.statusText);
                }
            }
        };

        // Extract key, value, and category from the input elements in the new row
        var params = 'key=' + encodeURIComponent(key) + '&value=' + encodeURIComponent(value) + '&category=' + encodeURIComponent(category);
        xhr.send(params);
    }

});