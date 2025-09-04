<?php
// msl_form.php
// This is the second page of the form, collecting MSL data.
// It retrieves previously submitted data from localStorage (client-side).

// Include the database connection and functions file
require_once 'get_list.php'; // Make sure the path is correct

// Fetch all items from the database, grouped by category
$groupedItems = getAllItemsGroupedByCategory($conn);

// Close the database connection after fetching all necessary data
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mondelez MSL Data</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <img src="Mdlz.jpg" alt="Mondelez Logo">
        <h1>Mondelez MSL Data</h1>
        <div class="form-container">
            <form id="mslForm" action="save.php" method="POST">
                <div id="hiddenFormData"></div>

                <?php if (!empty($groupedItems)): ?>
                    <?php foreach ($groupedItems as $category => $items): ?>
                        <div class="msl-section">
                            <h2><?php echo htmlspecialchars($category); ?> MSL</h2>
                            <?php if (!empty($items)): ?>
                                <?php foreach ($items as $item): 
                                    $itemNameForInput = strtolower(str_replace([' ', '/', '-'], '_', $item));
                                    $inputName = $category . '_' . $itemNameForInput . '_status';
                                ?>
                                    <div class="product-item">
                                        <label><?php echo htmlspecialchars($item); ?></label>
                                        <div class="radio-group">
                                            <input type="radio" id="<?php echo $inputName; ?>_yes" name="<?php echo $inputName; ?>" value="Yes" required>
                                            <label for="<?php echo $inputName; ?>_yes">Yes</label>
                                            <input type="radio" id="<?php echo $inputName; ?>_no" name="<?php echo $inputName; ?>" value="No">
                                            <label for="<?php echo $inputName; ?>_no">No</label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="warning-message">No <?php echo htmlspecialchars(strtolower($category)); ?> items found in the database.</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="warning-message">No items found in the database. Please check the 'item_list' table.</p>
                <?php endif; ?>

                <div class="button-group">
                    <button type="button" class="button back" onclick="history.back()">Back</button>
                    <input type="submit" value="Submit All Data" class="button">
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mslForm = document.getElementById('mslForm');
            const hiddenFormDataDiv = document.getElementById('hiddenFormData');

            // Retrieve data from localStorage
            const storedData = localStorage.getItem('mondelezFormData');

            if (storedData) {
                const formData = JSON.parse(storedData);
                // Dynamically create hidden input fields for each piece of data
                for (const key in formData) {
                    if (formData.hasOwnProperty(key)) {
                        const value = formData[key];
                        if (Array.isArray(value)) { // Handle array values (checkboxes)
                            value.forEach(item => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = key + '[]'; // Ensure array name for checkboxes if needed
                                input.value = item;
                                hiddenFormDataDiv.appendChild(input);
                            });
                        } else {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = key;
                            input.value = value;
                            hiddenFormDataDiv.appendChild(input);
                        }
                    }
                }
            } else {
                console.warn('No form data found in localStorage. The user might have directly accessed this page.');
                // Optionally redirect back to the first page or show a message
                // window.location.href = 'index.php';
            }

            mslForm.addEventListener('submit', function(event) {
                console.log('Submitting all data...');
            });
        });
    </script>
</body>
</html>