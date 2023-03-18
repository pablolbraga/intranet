<?php

if ($_REQUEST["tpl"] > 0 && $_REQUEST["img"] == ""){

    // Fichas Preenchidas
    switch ($_REQUEST["tpl"]) {
        case 98:
            echo "<script>location.href='fichaenfermagem_vis.php?evol=" . $_REQUEST["idevol"] . "'</script>";            
            break;
        case 109:
            echo "<script>location.href='fichanutricao_vis.php?evol=" . $_REQUEST["idevol"] . "'</script>";     
            break;
        case 107:
            echo "<script>location.href='fichamedica_vis.php?evol=" . $_REQUEST["idevol"] . "'</script>";  
            break;
        case 98:
            echo "<script>location.href='fichatecnicobase_vis.php?evol=" . $_REQUEST["idevol"] . "'</script>";  
            break;
        default:
            echo "<script>location.href='fichaterapia_vis.php?evol=" . $_REQUEST["idevol"] . "'</script>";  
            break;
    }

} else {

    // Fichas Importadas
    $extensao = explode(".", $_REQUEST["img"]);

    if ($extensao[1] == "pdf"){
        $file='../fichasimportadas/' . $_REQUEST["img"];
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="the.pdf"');
        @readfile($file);
    } else if ($extensao[1] == "jpg" || $extensao[1] == "jpeg" || $extensao[1] == "png") {
        $file='../fichasimportadas/' . $_REQUEST["img"];                                   
        ?>
        <img src="<?php echo $file ?>" />
        <?php
    } else {
        echo "<script>alert('extensão não suportada.'); window.close();</script>";
    }
}