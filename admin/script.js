document.querySelector('#input-valor').addEventListener("click", function(e){
    e.target.selectionStart = e.target.selectionEnd = e.target.value.length;
});

document.querySelector('#input-valor').addEventListener("keydown", function(e){
    e.preventDefault();
    
    let input = e.target;
    let val = input.value;
    let key = e.key;
    let regex = /[0-9]/;
    if (!regex.test(key) & key != 'Backspace') {
        input.value = val;
        return;
    } else if (key == 'Backspace') {
        let arr = val.split('');
        arr.splice(arr.length - 1);
        val = arr.join('');
    } else {
        val = val + key;
    }

    let arr = val.split(",");
    val = arr.join('');
    arr = val.split(".");
    
    let valor = arr.join('');
    let str = "";

    if (valor.length >= 3) {
        if(valor < 10) {
            str = "0,0";
            input.value = str + String(parseInt(valor));
        } else if (valor < 100){
            str = "0,";
            input.value = str + String(parseInt(valor));
        } else {
            valor = String(parseInt(valor));
            let l = valor.length;
            if(l > 5) {
                str = valor.substr(0, l - 2);
                let i = str.length;
                let m = Math.floor(i/3);
                let r = i % 3;
                pontos = r > 0 ? m : m - 1;
                for(i=1;i<=pontos;i++){
                    v = i === pontos ? "," : "";
                    let s = str.split(".");
                    let s1 = s[0].substr(0, s[0].length - 3);
                    let s2 = s[0].substr(s[0].length - 3, 3);
                    let s3 = s.slice(1).join('.');
                    s3 = s3.length > 0 ? "." + s3 : s3;
                    str = s1 + "." + s2 + s3 + v;
                }
            } else {
                str = valor.substr(0, valor.length - 2) + ",";
            }
            valor = str + valor.substr(l - 2, 2);
            input.value = valor;
        }
    } else {
        let z = '0';
        let str = z.repeat(3 - valor.length) + valor;
        valor = str[0] + ',' + str.substr(1, 2);
        input.value = valor;
    }
});

document.querySelector("#btn-submit").addEventListener("click", 
    function (e) {
        let val = document.getElementById("input-valor").value;
        let lblValorSaida = document.getElementById("lbl-valor-saida");
        let valor = 0;
        
        if(val.indexOf('.') > -1){
            let arr = val.split('.');
            valor = arr.join('').replace(',','.');
        } else {
            valor = val.replace(',','.');
        }

        console.log(valor);
        lblValorSaida.textContent = "Valor de saída: " + valor;
    }
);
