function mascaraData(val){
    var pass = val.value;
    var expr = /[0123456789]/;
    for (i = 0; i < pass.length; i++){
        // charAt -> retorna o caractere posicionado no índice especificado
        var lchar = val.value.charAt(i);
        var nchar = val.value.charAt(i + 1);

        if (i == 0){
            // search -> retorna um valor inteiro, indicando a posição do inicio da primeira
            // ocorrência de expReg dentro de instStr. Se nenhuma ocorrencia for encontrada o método retornara -1
            // instStr.search(expReg);
            if ((lchar.search(expr) != 0) || (lchar > 3)) {
                val.value = "";
            }
        } else if (i == 1){
            if (lchar.search(expr) != 0) {
                // substring(indice1,indice2)
                // indice1, indice2 -> será usado para delimitar a string
                var tst1 = val.value.substring(0, (i));
                val.value = tst1;
                continue;
            }

            if ((nchar != '/') && (nchar != '')) {
                var tst1 = val.value.substring(0, (i) + 1);
        
                if (nchar.search(expr) != 0)
                    var tst2 = val.value.substring(i + 2, pass.length);
                else
                    var tst2 = val.value.substring(i + 1, pass.length);
        
                val.value = tst1 + '/' + tst2;
            }
        } else if (i == 4){
            if (lchar.search(expr) != 0) {
                var tst1 = val.value.substring(0, (i));
                val.value = tst1;
                continue;
            }
        
            if ((nchar != '/') && (nchar != '')) {
                var tst1 = val.value.substring(0, (i) + 1);
        
                if (nchar.search(expr) != 0)
                    var tst2 = val.value.substring(i + 2, pass.length);
                else
                    var tst2 = val.value.substring(i + 1, pass.length);
        
                val.value = tst1 + '/' + tst2;
            }
        }

        if (i >= 6) {
            if (lchar.search(expr) != 0) {
                var tst1 = val.value.substring(0, (i));
                val.value = tst1;
            }
        }
    }

    if (pass.length > 9)
        val.value = val.value.substring(0, 9);
    return true;
}

function mascaraMoeda(a, e, r, t){
    let n = "", h = j = 0, u = tamanho2 = 0, l = ajd2 = "", o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
        return !0;
    if (n = String.fromCharCode(o), -1 == "0123456789".indexOf(n))
        return !1;
    for (u = a.value.length, h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++);
    for (l = ""; h < u; h++)
        -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n, 0 == (u = l.length) && (a.value = ""), 1 == u && (a.value = "0" + r + "0" + l), 2 == u && (a.value = "0" + r + l), u > 2) {
        for (ajd2 = "", j = 0, h = u - 3; h >= 0; h--)
            3 == j && (ajd2 += e, j = 0), ajd2 += l.charAt(h), j++;
        for (a.value = "", tamanho2 = ajd2.length, h = tamanho2 - 1; h >= 0; h--)      
            a.value += ajd2.charAt(h);
        a.value += r + l.substr(u - 2, u)
    }
    return !1
}