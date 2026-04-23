let deleteButtons = document.querySelectorAll('.delete-btn');

deleteButtons.forEach(button => {
    const billId = Number(button.dataset.id);
    const billNumber = button.id;
    let data = {bill_id: billId};
    button.addEventListener('click', e => {
        if(confirm(`Biztonsan törölni szeretnéd a(z) ${billNumber} azonosítójú számlát?`)){
            fetch("../controller/delete_bill.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                console.log("Válasz a szervertől:", result);
            })
            .catch(error => {
                console.error("Hiba történt:", error);
            });
        }else{
            console.log("Nincs törlés...");
        }
    });
});