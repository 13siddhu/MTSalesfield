<?php
// msl_form.php
// This is the second page of the form, collecting MSL data.
// It retrieves previously submitted data from localStorage (client-side).

// Include the database connection and functions file
require_once 'get_list.php'; // Make sure the path is correct

// Fetch items for each category using the function from get_list.php
$chocolateItems = getItemsByCategory($conn, 'Chocolate');
$biscuitItems = getItemsByCategory($conn, 'Biscuit');
$gcpbItems = getItemsByCategory($conn, 'GCPB'); // Changed from MFD to GCPB

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

                <div class="msl-section">
                    <h2>Chocolate MSL</h2>
                    <div class="product-item">
                        <label>Is Chocolate MSL available?</label>
                        <div class="radio-group">
                            <input type="radio" id="choc_msl_yes" name="chocolate_msl_status" value="Yes" required>
                            <label for="choc_msl_yes">Yes</label>
                            <input type="radio" id="choc_msl_no" name="chocolate_msl_status" value="No">
                            <label for="choc_msl_no">No</label>
                        </div>
                    </div>
                    <div id="chocolateDropdownContainer" class="product-item-dropdown" style="display: none;">
                        <label for="chocolate_item_selection">Select Chocolate Item:</label>
                        <select id="chocolate_item_selection" name="chocolate_selected_item">
                            <option value="">-- Please Select --</option>
                            <?php if (!empty($chocolateItems)): ?>
                                <?php foreach ($chocolateItems as $item): ?>
                                    <option value="<?php echo htmlspecialchars($item); ?>"><?php echo htmlspecialchars($item); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?php if (empty($chocolateItems)): ?>
                            <p class="warning-message">No chocolate items found in the database.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="msl-section">
                    <h2>Biscuit MSL</h2>
                    <div class="product-item">
                        <label>Is Biscuit MSL available?</label>
                        <div class="radio-group">
                            <input type="radio" id="bisc_msl_yes" name="biscuit_msl_status" value="Yes" required>
                            <label for="bisc_msl_yes">Yes</label>
                            <input type="radio" id="bisc_msl_no" name="biscuit_msl_status" value="No">
                            <label for="bisc_msl_no">No</label>
                        </div>
                    </div>
                    <div id="biscuitDropdownContainer" class="product-item-dropdown" style="display: none;">
                        <label for="biscuit_item_selection">Select Biscuit Item:</label>
                        <select id="biscuit_item_selection" name="biscuit_selected_item">
                            <option value="">-- Please Select --</option>
                            <?php if (!empty($biscuitItems)): ?>
                                <?php foreach ($biscuitItems as $item): ?>
                                    <option value="<?php echo htmlspecialchars($item); ?>"><?php echo htmlspecialchars($item); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?php if (empty($biscuitItems)): ?>
                            <p class="warning-message">No biscuit items found in the database.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="msl-section">
                    <h2>GCPB MSL</h2>
                    <div class="product-item">
                        <label>Is GCPB MSL available?</label>
                        <div class="radio-group">
                            <input type="radio" id="gcpb_msl_yes" name="gcpb_msl_status" value="Yes" required>
                            <label for="gcpb_msl_yes">Yes</label>
                            <input type="radio" id="gcpb_msl_no" name="gcpb_msl_status" value="No">
                            <label for="gcpb_msl_no">No</label>
                        </div>
                    </div>
                    <div id="gcpbDropdownContainer" class="product-item-dropdown" style="display: none;">
                        <label for="gcpb_item_selection">Select GCPB Item:</label>
                        <select id="gcpb_item_selection" name="gcpb_selected_item">
                            <option value="">-- Please Select --</option>
                            <?php if (!empty($gcpbItems)): ?>
                                <?php foreach ($gcpbItems as $item): ?>
                                    <option value="<?php echo htmlspecialchars($item); ?>"><?php echo htmlspecialchars($item); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?php if (empty($gcpbItems)): ?>
                            <p class="warning-message">No GCPB items found in the database.</p>
                        <?php endif; ?>
                    </div>
                </div>

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

            // --- New JavaScript for conditional dropdown visibility ---

            function setupConditionalDropdown(radioName, dropdownContainerId, selectElementId) {
                const radios = document.querySelectorAll(`input[name="${radioName}"]`);
                const dropdownContainer = document.getElementById(dropdownContainerId);
                const selectElement = document.getElementById(selectElementId);

                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (this.value === 'Yes') {
                            dropdownContainer.style.display = 'block';
                            selectElement.setAttribute('required', 'required');
                        } else {
                            dropdownContainer.style.display = 'none';
                            selectElement.removeAttribute('required');
                            selectElement.value = ''; // Reset dropdown selection when 'No' is chosen
                        }
                    });
                });
            }

            // Apply the function to each MSL section
            setupConditionalDropdown('chocolate_msl_status', 'chocolateDropdownContainer', 'chocolate_item_selection');
            setupConditionalDropdown('biscuit_msl_status', 'biscuitDropdownContainer', 'biscuit_item_selection');
            setupConditionalDropdown('gcpb_msl_status', 'gcpbDropdownContainer', 'gcpb_item_selection');

            // --- End New JavaScript ---

            mslForm.addEventListener('submit', function(event) {
                console.log('Submitting all data...');
                // Further client-side validation could go here if needed.
                // The browser's native 'required' attribute will handle basic validation.
            });
        });
    </script>
</body>
</html>