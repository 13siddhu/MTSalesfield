<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mondelez MT TG</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Add some basic styling for the datalist (optional, but can improve appearance) */
    </style>
</head>
<body>
     <div class="container">

        <img src="Mdlz.jpg">
        <h1>MT Stores Score</h1>
        <div class="form-container">
            <form action="save.php" method="POST">

                <div class="input-names">
                <i class="fa fa-users lock"></i>
                <select class="drop-down" name="sename" id="sename" required>
                    <option value="Not Selected"> Select SE </option>
                    <option value="Nitesh Singh"> Nitesh Singh </option>
                    <option value="Prakash Singh"> Prakash Singh </option>
                    <option value="V Laxmi Pathi"> V Laxmi Pathi </option>
                    </select>

                    <div class="arrow"> </div>

                </div>

                
                <div class="input-names">
                    <i class="fa fa-university lock"></i>
                    <select class="drop-down" name="accout" id="account" required disabled>
                        <option value="Not Selected"> Select Account </option>
                        </select>
                    <div class="arrow"> </div>
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


                <div class="input-name" name="save">
                    <input type="submit" value="Save" class="button" name="save">
                </div>
 
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
                resetAccountAndStore(); // Reset everything when SE changes

                if (selectedSE === "Not Selected") {
                    return;
                }

                // Fetch accounts based on selected SE
                const xhrAccounts = new XMLHttpRequest();
                // Point to the dedicated PHP file for accounts and store codes
                xhrAccounts.open('GET', 'get_accounts_and_store_codes.php?se_selected=' + encodeURIComponent(selectedSE), true);

                xhrAccounts.onload = function() {
                    if (xhrAccounts.status === 200) {
                        const accounts = JSON.parse(xhrAccounts.responseText);
                        if (accounts.length > 0) {
                            accounts.forEach(account => {
                                const option = document.createElement('option');
                                option.value = account;
                                option.textContent = account;
                                accountSelect.appendChild(option);
                            });
                            accountSelect.disabled = false; // Enable account dropdown
                        } else {
                            console.log("No accounts found for this SE.");
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

                storeCodeInput.value = ''; // Clear store code input
                storeCodesDatalist.innerHTML = ''; // Clear datalist options
                storeLocationInput.value = ''; // Clear location
                storeCodeInput.disabled = true; // Disable store code until valid account is chosen

                if (selectedAccount === "Not Selected" || selectedSE === "Not Selected") {
                    return;
                }

                // Fetch store codes based on selected SE and Account
                const xhrStoreCodes = new XMLHttpRequest();
                // Point to the dedicated PHP file for accounts and store codes
                xhrStoreCodes.open('GET', 'get_accounts_and_store_codes.php?se_selected=' + encodeURIComponent(selectedSE) + '&account_selected=' + encodeURIComponent(selectedAccount), true);

                xhrStoreCodes.onload = function() {
                    if (xhrStoreCodes.status === 200) {
                        const storeCodes = JSON.parse(xhrStoreCodes.responseText);
                        if (storeCodes.length > 0) {
                            storeCodes.forEach(code => {
                                const option = document.createElement('option');
                                option.value = code;
                                storeCodesDatalist.appendChild(option);
                            });
                            storeCodeInput.disabled = false; // Enable store code input
                        } else {
                            console.log("No store codes found for this account.");
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
                const selectedAccount = accountSelect.value; // Get the currently selected account
                const selectedSE = seSelect.value; // Get the currently selected SE

                storeLocationInput.value = ''; // Clear location initially

                // Only fetch location if a store code is entered and both SE and account are selected
                if (selectedStoreCode.length > 0 && selectedAccount !== "Not Selected" && selectedSE !== "Not Selected") {
                    const xhrLocation = new XMLHttpRequest();
                    // Point to the dedicated PHP file for store location
                    const queryParams = 'se_name=' + encodeURIComponent(selectedSE) + '&account=' + encodeURIComponent(selectedAccount) + '&store_code=' + encodeURIComponent(selectedStoreCode);
                    xhrLocation.open('GET', 'get_store_location.php?' + queryParams, true);

                    xhrLocation.onload = function() {
                        if (xhrLocation.status === 200) {
                            const response = JSON.parse(xhrLocation.responseText);
                            if (response.city_area) { // Check if 'city_area' property exists
                                storeLocationInput.value = response.city_area;
                            } else {
                                console.log("No location found for this store code with the given SE and Account.");
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