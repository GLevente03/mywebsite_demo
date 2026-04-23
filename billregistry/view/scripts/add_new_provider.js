    // Az input esemény figyelése az adott mezőn
    document.getElementById('account-number').addEventListener('input', function(e) {
        let input = e.target;
        let value = input.value;
        
        // 1. Csak számjegyek megtartása
        value = value.replace(/\D/g, '');
        
        // 2. Maximum 24 számjegy engedélyezése (3 db 8 számjegyű blokk)
        if (value.length > 24) {
          value = value.substring(0, 24);
        }
        
        // 3. Formázás: 8 számjegyenként kötőjel beszúrása
        let formattedValue = '';
        for (var i = 0; i < value.length; i++) {
          if (i > 0 && i % 8 === 0) {
            formattedValue += '-';
          }
          formattedValue += value.charAt(i);
        }
        
        // A formázott érték visszaállítása az input mezőbe
        input.value = formattedValue;
    });

    //Ha a felhasználó üresen hagy egy mezőt, majd elkattint róla, akkor piros szegélyt kapnak az input mezők.
    let providerInputFields = document.querySelectorAll('.provider-input');
    providerInputFields.forEach(input => {
        input.addEventListener('blur', () => {
            if(input.value.length === 0){
                input.classList.add('emptyfocusout');
                let inputID = input.id;
                let errMsgID = 'err-msg-for-' + inputID;
                document.getElementById(errMsgID).textContent = "A mező kitöltése kötelező!";
            }
        });
        //Ha visszakattint az üresen hagyott mezőbe, és elkezd írni valamit, akkor a mezők visszaváltoznak az eredeti stílusukra.
        input.addEventListener('input', () => {
            if(input.classList.contains('emptyfocusout')){
                input.classList.remove('emptyfocusout');
                let inputID = input.id;
                let errMsgID = 'err-msg-for-' + inputID;
                document.getElementById(errMsgID).textContent = "";
            }
        });
    });
