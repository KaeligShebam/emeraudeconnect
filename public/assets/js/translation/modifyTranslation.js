
document.addEventListener('DOMContentLoaded', function () {
    var tableBody = document.querySelector('table tbody');

    tableBody.addEventListener('click', function (event) {
        var clickedElement = event.target;
        var isEditableCell = clickedElement.classList.contains('editable-cell');

        if (isEditableCell) {
            makeCellEditable(clickedElement);
        } else {
            saveChanges();
        }
    });

    function makeCellEditable(cell) {
        var currentValue = cell.textContent.trim();
        cell.innerHTML = '';

        var input = createInput('value', currentValue);

        input.addEventListener('blur', function () {
            saveChanges();
        });

        cell.appendChild(input);
        input.focus();
    }

    function saveChanges() {
        var editableCells = document.querySelectorAll('.editable-cell input');

        editableCells.forEach(function (input) {
            var cell = input.closest('.editable-cell');
            var key = cell.dataset.key; // Assuming data-key attribute is set on each editable cell
            var value = input.value.trim();

            if (value !== '') {
                saveTranslation(key, value);
            } else {
                // Display an error message or handle it as needed
                console.error('Value must be non-empty');
            }

            // Restore the original content
            cell.innerHTML = value;
        });
    }

    function createInput(name, value) {
        var input = document.createElement('input');
        input.type = 'text';
        input.name = name;
        input.value = value;
        input.classList.add('inputTranslation');
        return input;
    }

    function saveTranslation(key, value) {
        // Make an AJAX request to Symfony controller to update the translation
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/parametres/traduction/modifier', true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Handle success, if needed
                    console.log(JSON.parse(xhr.responseText).message);
                } else {
                    // Handle error, if needed
                    console.error('Error saving translation:', xhr.statusText);
                }
            }
        };

        // Prepare data for the request
        var data = {
            key: key,
            value: value,
            category: 'your_category', // Set the category as needed
        };

        // Send the request with JSON data
        xhr.send(JSON.stringify(data));
    }
});
