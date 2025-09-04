<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mondelez MT TG</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <img src="Mdlz.jpg">
        <h1>MT Stores Score</h1>
        <div class="form-container">
            <form id="mainForm" action="msl_form.php" method="POST">

                <div class="input-names">
                    <i class="fa fa-users lock"></i>
                    <select class="drop-down" name="sename" id="sename" required>
                        <option value="Not Selected"> Select SE </option>
                        <option value="Nitesh Singh"> Nitesh Singh </option>
                        <option value="Prakash Singh"> Prakash Singh </option>
                        <option value="V Laxmi Pathi"> V Laxmi Pathi </option>
                    </select>
                    <div class="arrow"></div>
                </div>

                <div class="input-names">
                    <i class="fa fa-university lock"></i>
                    <select class="drop-down" name="accout" id="account" required disabled>
                        <option value="Not Selected"> Select Account </option>
                    </select>
                    <div class="arrow"></div>
                </div>

                <div class="input-name">
                    <i class="fa fa-envelope lock"></i>
                    <input type="text" placeholder="Store Code" class="text-name" name="sname" id="scode" list="storeCodes" required disabled>
                    <datalist id="storeCodes"></datalist>
                </div>

                <div class="input-name">
                    <i class="fa fa-envelope lock"></i>
                    <input type="text" placeholder="Store Location" class="text-name" name="slocation" id="slocation" required>
                </div>

                <div class="input-name">
                    <i class="fa fa-address-book lock"></i>
                    <input type="text" placeholder="Store Area(Sqft)" class="text-name" name="sarea" id="sarea" required>
                </div>

                <div class="input-name">
                    <i class="fa fa-inr lock"></i>
                    <input type="text" placeholder="Store Monthly Revenue" class="text-name" name="srevenue" id="srevenue" required>
                </div>

                <div class="input-name">
                    <i class="fa fa-inr lock"></i>
                    <input type="text" placeholder="Cadbury Monthly Revenue" class="text-name" name="crevenue" id="crevenue" required>
                </div>

                <div class="input-namez">
                    <i class="fa fa-home lock"></i>
                    <label name="totasset">TOT Asset</label>
                    <div>
                        <input type="checkbox" class="checkbox" name="totasset[]" value="Endcap">
                        <label style="margin-right: 8px">Endcap</label>
                        <input type="checkbox" class="checkbox" name="totasset[]" value="Slatwall">
                        <label style="margin-right: 8px;">Slatwall</label>
                        <input type="checkbox" class="checkbox" name="totasset[]" value="FSU">
                        <label style="margin-right: 8px;">FSU</label>
                        <input type="checkbox" class="checkbox" name="totasset[]" value="Sidecap">
                        <label style="margin-right: 8px;">Sidecap</label>
                        <input type="checkbox" class="checkbox" name="totasset[]" value="Monkeyson">
                        <label style="margin-right: 8px;">Monkeyson</label>
                    </div>
                </div>

                <div class="input-namez">
                    <i class="fa fa-home lock"></i>
                    <label name="paidasset">Paid Asset</label>
                    <div>
                        <input type="checkbox" class="checkbox" name="paidasset[]" value="Endcap">
                        <label style="margin-right: 8px">Endcap</label>
                        <input type="checkbox" class="checkbox" name="paidasset[]" value="Slatwall">
                        <label style="margin-right: 8px;">Slatwall</label>
                        <input type="checkbox" class="checkbox" name="paidasset[]" value="FSU">
                        <label style="margin-right: 8px;">FSU</label>
                        <input type="checkbox" class="checkbox" name="paidasset[]" value="Sidecap">
                        <label style="margin-right: 8px;">Sidecap</label>
                        <input type="checkbox" class="checkbox" name="paidasset[]" value="Floor Stack">
                        <label style="margin-right: 8px;">Floor Stack</label>
                    </div>
                </div>

                <div class="input-namez">
                    <i class="fa fa-home lock"></i>
                    <label name="unpaidasset">UnPaid Asset</label>
                    <div>
                        <input type="checkbox" class="checkbox" name="unpaidasset[]" value="Endcap">
                        <label style="margin-right: 8px">Endcap</label>
                        <input type="checkbox" class="checkbox" name="unpaidasset[]" value="Slatwall">
                        <label style="margin-right: 8px;">Slatwall</label>
                        <input type="checkbox" class="checkbox" name="unpaidasset[]" value="FSU">
                        <label style="margin-right: 8px;">FSU</label>
                        <input type="checkbox" class="checkbox" name="unpaidasset[]" value="Sidecap">
                        <label style="margin-right: 8px;">Sidecap</label>
                        <input type="checkbox" class="checkbox" name="unpaidasset[]" value="Floor Stack">
                        <label style="margin-right: 8px;">Floor Stack</label>
                    </div>
                </div>

                <div class="input-name" name="save">
                    <input type="submit" value="Save" class="button" name="save">
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const seSelect = document.getElementById('sename');
            const accountSelect = document.getElementById('account');
            const storeCodeInput = document.getElementById('scode');
            const storeCodesDatalist = document.getElementById('storeCodes');
            const storeLocationInput = document.getElementById('slocation');
            const mainForm = document.getElementById('mainForm'); // Added ID to form

            // New JavaScript to save data to localStorage before redirecting
            mainForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const formData = new FormData(mainForm);
                const data = {};

                // Convert form data to a plain object, handling arrays for checkboxes
                formData.forEach((value, key) => {
                    if (key.endsWith('[]')) {
                        const cleanKey = key.slice(0, -2);
                        if (!data[cleanKey]) {
                            data[cleanKey] = [];
                        }
                        data[cleanKey].push(value);
                    } else {
                        data[key] = value;
                    }
                });

                // Save the data to localStorage
                localStorage.setItem('mondelezFormData', JSON.stringify(data));

                console.log('Form data saved to localStorage. Redirecting...');

                // Now, submit the form to the new action page
                mainForm.submit();
            });


            // Function to reset dependent fields
            function resetAccountAndStore() {
                accountSelect.innerHTML = '<option value="Not Selected"> Select Account </option>';
                accountSelect.disabled = true;
                storeCodeInput.value = '';
                storeCodeInput.disabled = true;
                storeCodesDatalist.innerHTML = '';
                storeLocationInput.value = '';
            }

            // 1. Listen for SE selection change
            seSelect.addEventListener('change', function() {
                const selectedSE = this.value;
                resetAccountAndStore();

                if (selectedSE === "Not Selected") {
                    return;
                }

                const xhrAccounts = new XMLHttpRequest();
                xhrAccounts.open('GET', 'get_accounts_and_store_codes.php?se_selected=' + encodeURIComponent(selectedSE), true);

                xhrAccounts.onload = function() {
                    if (xhrAccounts.status === 200) {
                        try {
                            const accounts = JSON.parse(xhrAccounts.responseText);
                            if (accounts.length > 0) {
                                accounts.forEach(account => {
                                    const option = document.createElement('option');
                                    option.value = account;
                                    option.textContent = account;
                                    accountSelect.appendChild(option);
                                });
                                accountSelect.disabled = false;
                            } else {
                                console.log("No accounts found for this SE.");
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            console.log('Response text:', xhrAccounts.responseText);
                        }
                    } else {
                        console.error('Error fetching accounts:', xhrAccounts.statusText);
                    }
                };
                xhrAccounts.onerror = function() {
                    console.error('Network error while fetching accounts.');
                };
                xhrAccounts.send();
            });

            // 2. Listen for Account selection change
            accountSelect.addEventListener('change', function() {
                const selectedSE = seSelect.value;
                const selectedAccount = this.value;

                storeCodeInput.value = '';
                storeCodesDatalist.innerHTML = '';
                storeLocationInput.value = '';
                storeCodeInput.disabled = true;

                if (selectedAccount === "Not Selected" || selectedSE === "Not Selected") {
                    return;
                }

                const xhrStoreCodes = new XMLHttpRequest();
                const queryParams = 'se_selected=' + encodeURIComponent(selectedSE) + '&account_selected=' + encodeURIComponent(selectedAccount);
                xhrStoreCodes.open('GET', 'get_accounts_and_store_codes.php?' + queryParams, true);

                xhrStoreCodes.onload = function() {
                    if (xhrStoreCodes.status === 200) {
                        try {
                            const storeCodes = JSON.parse(xhrStoreCodes.responseText);
                            if (storeCodes.length > 0) {
                                storeCodes.forEach(code => {
                                    const option = document.createElement('option');
                                    option.value = code;
                                    storeCodesDatalist.appendChild(option);
                                });
                                storeCodeInput.disabled = false;
                            } else {
                                console.log("No store codes found for this account.");
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            console.log('Response text:', xhrStoreCodes.responseText);
                        }
                    } else {
                        console.error('Error fetching store codes:', xhrStoreCodes.statusText);
                    }
                };
                xhrStoreCodes.onerror = function() {
                    console.error('Network error while fetching store codes.');
                };
                xhrStoreCodes.send();
            });

            // 3. Listen for Store Code input (to auto-fill location)
            storeCodeInput.addEventListener('input', function() {
                const selectedStoreCode = this.value;
                const selectedAccount = accountSelect.value;
                const selectedSE = seSelect.value;

                storeLocationInput.value = '';

                if (selectedStoreCode.length > 0 && selectedAccount !== "Not Selected" && selectedSE !== "Not Selected") {
                    const xhrLocation = new XMLHttpRequest();
                    const queryParams = 'se_name=' + encodeURIComponent(selectedSE) + '&account=' + encodeURIComponent(selectedAccount) + '&store_code=' + encodeURIComponent(selectedStoreCode);
                    xhrLocation.open('GET', 'get_store_location.php?' + queryParams, true);

                    xhrLocation.onload = function() {
                        if (xhrLocation.status === 200) {
                            try {
                                const response = JSON.parse(xhrLocation.responseText);
                                if (response.city_area) {
                                    storeLocationInput.value = response.city_area;
                                } else {
                                    console.log("No location found for this store code with the given SE and Account.");
                                }
                            } catch (e) {
                                console.error('Error parsing JSON:', e);
                                console.log('Response text:', xhrLocation.responseText);
                            }
                        } else {
                            console.error('Error fetching store location:', xhrLocation.statusText);
                        }
                    };

                    xhrLocation.onerror = function() {
                        console.error('Network error while fetching store location.');
                    };
                    xhrLocation.send();
                }
            });
        });
    </script>
</body>
</html>