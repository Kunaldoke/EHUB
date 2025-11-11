const errorAlert = document.getElementById('erroralert');
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.display = 'none';
            }, 4000);}
const success = document.getElementById('success');
        if (success) {
            setTimeout(() => {
                success.style.display = 'none';
            }, 4000);}
            
            function toggleAmountInput(isPaid) {
                const amountContainer = document.getElementById("amount");
                if (isPaid) {
                    amountContainer.style.display = "block"; 
                    amountContainer.required = true;
                } else {
                    amountContainer.style.display = "none";
                    amountContainer.required = false; 
                }
            }