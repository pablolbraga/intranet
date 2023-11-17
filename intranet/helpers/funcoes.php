<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("../helpers/phpmaile/src/PHPMailer.php");
require_once("../helpers/phpmaile/src/SMTP.php");
require_once("../helpers/phpmaile/src/Exception.php");
require_once("../helpers/contantes.php");


class Funcoes{

    public function gerarSenha(){
        $tamanho = 8;
        $maiusculas = true;
        $numeros = true;
        $simbolos = false;

        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*&';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;
        if ($maiusculas)
            $caracteres .= $lmai;
        if ($numeros)
            $caracteres .= $num;
        if ($simbolos)
            $caracteres .= $simb;

        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }


    public function enviarEmail($email, $assunto, $texto){        


        $mail = new PHPMailer(true);

        try{
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = Constantes::$DADOS_EMAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = Constantes::$DADOS_EMAIL_USERNAME;                   //SMTP username
            $mail->Password   = Constantes::$DADOS_EMAIL_PWD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = Constantes::$DADOS_EMAIL_PORT;
            $mail->CharSet = "UTF8";

            //Recipients
            $mail->setFrom(Constantes::$DADOS_EMAIL_USERNAME, 'Saúde Residence');
            $mail->addAddress($email);     //Add a recipient
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $assunto;
            $mail->Body    = $texto;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        } catch (Exception $e) {
            echo "Erro ao enviar o email. Erro: {$mail->ErrorInfo}";
        }

    }

    function adicionarDiasUteis($str_data, $int_qtd_dias_somar) {
        // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
        // Transforma para DATE - aaaa-mm-dd
        $str_data = substr($str_data, 0, 10);
        // Se a data estiver no formato brasileiro: dd/mm/aaaa
        // Converte-a para o padrÃ£o americano: aaaa-mm-dd
        if (preg_match("@/@", $str_data) == 1) {
            $str_data = implode("-", array_reverse(explode("/", $str_data)));
        }

        $array_data = explode('-', $str_data);
        $count_days = 0;
        $int_qtd_dias_uteis = 0;
        while ($int_qtd_dias_uteis < $int_qtd_dias_somar) {
            $count_days++;
            if (( $dias_da_semana = gmdate('w', strtotime('+' . $count_days . ' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6') {
                $int_qtd_dias_uteis++;
            }
        }
        return gmdate('d/m/Y', strtotime('+' . $count_days . ' day', strtotime($str_data)));
    }

    public function adicionarHora($hora, $qtdhora) {
        $xhora = explode(":", $hora);
        $hora = $xhora[0];
        $minuto = $xhora[1];
        $segundo = $xhora[2];

        $xdata = date("H:i", mktime(((int) $hora + $qtdhora), (int) $minuto, (int) $segundo, 0, 0, 0));
        return $xdata;
    }

    public function adicionarHoraUtil($data, $qtdeHora){

        // Método que verifica se a data máxima somada com a quantidade de horas está fora do limite solicitado
        $horaminutil = "0700";
        $horamaxutil = "1900";

        // Separar a data em dia, mes, ano, hora, min, seg
        $xdata = explode("/", $data);
        $dia = $xdata[0];
        $mes = $xdata[1];
        $ano = substr($xdata[2], 0, 4);
        $horario = explode(":", substr($xdata[2], 5, 8));
        $hora = $horario[0];
        $min = $horario[1];

        $prox_data = date("d/m/Y", mktime($hora + $qtdeHora, $min, 0, $mes, $dia, $ano));
        $prox_hora = date("H:i", mktime($hora + $qtdeHora, $min, 0, $mes, $dia, $ano));
        $prox_hora_desf = date("Hi", mktime($hora + $qtdeHora, $min, 0, $mes, $dia, $ano));
        $prox_datahora_desf = date("YmdHi", mktime($hora + $qtdeHora, $min, 0, $mes, $dia, $ano));


        return $prox_data . " " . $prox_hora;

    }

    public function retornarDiaSemana($data) {
        $ano = substr($data, 6, 4);
        $mes = substr($data, 3, 2);
        $dia = substr($data, 0, 2);

        $diasemana = date("D", mktime(0, 0, 0, $mes, $dia, $ano));

        if ($diasemana == "Sun") //domingo
            $diasemana2 = "1";
        else
        if ($diasemana == "Mon") //segunda
            $diasemana2 = "2";
        else
        if ($diasemana == "Tue") //terca
            $diasemana2 = "3";
        else
        if ($diasemana == "Wed") // quarta
            $diasemana2 = "4";
        else
        if ($diasemana == "Thu") // quinta
            $diasemana2 = "5";
        else
        if ($diasemana == "Fri") // sexta
            $diasemana2 = "6";
        else
        if ($diasemana == "Sat") //sabado
            $diasemana2 = "7";
        else
            $diasemana2 = "0";

        return $diasemana2;
    }

    public function diferenca_data_hora($dataini, $datafim) {
        // Deve ser colocado data e hora no formato DD/MM/YYYY HH:MM:SS
        $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $dataini);
        $fim = DateTime::createFromFormat('d/m/Y H:i:s', $datafim);
        
        $intervalo = $inicio->diff($fim);
        
        $xretorno = $intervalo->format('%Y,%M,%D,%H,%I,%S');

        $diferenca = explode(",", $xretorno);

        $retorno = "";

        if ($diferenca[0] != "00")
            $retorno .= $diferenca[0] . " Ano(s) ";
        else
            $retorno .= "";

        if ($diferenca[1] != "00")
            $retorno .= $diferenca[1] . " Mes(es) ";
        else
            $retorno .= "";

        if ($diferenca[2] != "00")
            $retorno .= $diferenca[2] . " Dia(s) ";
        else
            $retorno .= "";

        if ($diferenca[3] != "00")
            $retorno .= $diferenca[3] . ":";
        else
            $retorno .= "00:";

        if ($diferenca[4] != "00")
            $retorno .= $diferenca[4] . ":";
        else
            $retorno .= "00:";

        if ($diferenca[5] != "00")
            $retorno .= $diferenca[5];
        else
            $retorno .= "00";
        return $retorno;
    }

    public function retornarDataHoraUtil($dataInicio, $prazoHora){

        $xdate2 = explode("/", $dataInicio);
        $xdate = substr($xdate2[2], 0, 4) . "-" . $xdate2[1] . "-" . $xdate2[0] . " " . substr($dataInicio, 11, 8);
        $date = new DateTime($xdate);
        // prazo, em horas. se precisar especificar em minutos, 
        // coloque valores quebrados, como 15.5
        $prazo = $prazoHora;

        // inicio do expediente 9 = horas * 60 para transformar em minutos
        $inicioExpediente = 8 * 60;
        // fim do expediente
        $fimExpediente = 18 * 60;
        // feriados
        $feriados = array();
        // dias encontrados para trampo
        $diasUteis = array();
        // ----------- agora começa a brincadeira
        // convertemos o prazo para minutos
        $prazoMinutos = $prazo * 60;
        // enquanto for maior que zero
        while ($prazoMinutos > 0){
            // transformamos a hora atual em minutos
            $hora = ($date->format('H') * 60) + $date->format('i');
            // se for menor que a hora do inicio do expediente
            if ($hora < $inicioExpediente) {
                // colocamos igual a hora do expediente
                $date->setTime(0, $inicioExpediente, 0);
                continue;
            }
            // data calculada
            $data = $date->format('d/m/Y');
            // se 
            // - for um feriado OU
            // - passar da hora do expediente OU
            // - for um dia de fim de semana (sabado|domingo)
            // vamos para o dia seguinte, no inicio do expediente
            if (in_array($data, $feriados) || $hora >= $fimExpediente || $date->format('w') == 0 || $date->format('w') == 6) {
                $date->modify('+1 day');
                $date->setTime(0, $inicioExpediente, 0);
                continue;
            }
            // se chegou aqui, é um dia util.
            // vamos ver se já está na nossa lista de dias
            // se não estiver, colocamos
            if (!in_array($data, $diasUteis)) {
                $diasUteis[] = $data;
            }
            // minutos que temos que acrescentar para chegar no
            // fim do expediente de hoje
            $minutos = $fimExpediente - $hora;
            // tiramos do prazo
            $prazoMinutos -= $minutos;
            // se estourou
            if ($prazoMinutos < 0) {
                // tiramos o que estourou
                $minutos += $prazoMinutos;
            }
            // adicionamos os minutos do calculo na data
            $date->modify('+' . $minutos . ' minute');
        }

        $prazoFinal = $date->format('d/m/Y H:i:s');

        return $prazoFinal;

    }

    public function retornarDiferencaDataHoraUtil($dataInicio, $dataFim){

        // Colocar data e hora nos parametros
        $horainiutil = "08:00:00";
        $horainiform = "080000";
        $horafimutil = "18:00:00";
        $horafimform = "180000";
        $somahora = "00:00:00";

        $xdataini[0] = substr($dataInicio, 0, 2);
        $xdataini[1] = substr($dataInicio, 3, 2);
        $xdataini[2] = substr($dataInicio, 6, 4);
        $xdataini[3] = substr($dataInicio, 11, 2);
        $xdataini[4] = substr($dataInicio, 14, 2);
        $xdataini[5] = substr($dataInicio, 17, 2);

        $xdatafim[0] = substr($dataFim, 0, 2);
        $xdatafim[1] = substr($dataFim, 3, 2);
        $xdatafim[2] = substr($dataFim, 6, 4);
        $xdatafim[3] = substr($dataFim, 11, 2);
        $xdatafim[4] = substr($dataFim, 14, 2);
        $xdatafim[5] = substr($dataFim, 17, 2);

        $inicio = DateTime::createFromFormat('H:i:s', ($xdataini[3] . ":" . $xdataini[4] . ":" . $xdataini[5]));
        $fim = DateTime::createFromFormat('H:i:s', $horafimutil);

        $intervalo = $inicio->diff($fim);

        $hora[0] = $intervalo->format('%H:%I:%S'); // Diferença de horas do primeiro dia
        $somahora = $this->somarHoras($somahora, $intervalo->format('%H:%I:%S'));
        // diferenca dias
        $diferenca_dia = $this->diferencaData(substr($dataInicio, 0, 10), substr($dataFim, 0, 10), "D", "/");

        for ($i = 1; $i < $diferenca_dia; $i++){
            $dt = $this->adicionarDia(substr($dataInicio, 0, 10), $i);
            // Verifica se a data é dia útil
            if ($this->verificarDiaUtil($dt)){
                // Verifica se a data é igual a data final
                if ($dt != substr($dataFim, 0, 10)) {
                    $somahora = $this->somarHoras($somahora, "08:48:00");
                    //echo $somahora . "<br>";
                } else {
                    $inicio = DateTime::createFromFormat('H:i:s', "08:00:00");
                    $fim = DateTime::createFromFormat('H:i:s', ($xdatafim[3] . ":" . $xdatafim[4] . ":" . $xdatafim[5]));
                    $intervalo = $inicio->diff($fim);
                    //$hora[$i] = $intervalo->format('%H:%I:%S');
                    $somahora = $this->somarHoras($somahora, $intervalo->format('%H:%I:%S'));
                    //echo $somahora . "<br><br>";
                }
            }
        }

        $xsomahora = explode(":", $somahora);
        $somahora = str_pad($xsomahora[0], 2, "0", STR_PAD_LEFT) . ":" . str_pad($xsomahora[1], 2, "0", STR_PAD_LEFT) . ":" . str_pad($xsomahora[2], 2, "0", STR_PAD_LEFT);

        return $somahora;
    }

    public function retornarDiferencaDataHora($dataInicio, $dataFim){
        // Deve ser colocado data e hora no formato DD/MM/YYYY HH:MM:SS
        $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $dataInicio);
        $fim = DateTime::createFromFormat('d/m/Y H:i:s', $dataFim);
        $intervalo = $inicio->diff($fim);        
        $xretorno = $intervalo->format('%Y,%M,%D,%H,%I,%S');
        $diferenca = explode(",", $xretorno);
        $retorno = "";
        if ($diferenca[0] != "00")
            $retorno .= $diferenca[0] . " Ano(s) ";
        else
            $retorno .= "";

        if ($diferenca[1] != "00")
            $retorno .= $diferenca[1] . " Mes(es) ";
        else
            $retorno .= "";

        if ($diferenca[2] != "00")
            $retorno .= $diferenca[2] . " Dia(s) ";
        else
            $retorno .= "";

        if ($diferenca[3] != "00")
            $retorno .= $diferenca[3] . ":";
        else
            $retorno .= "00:";

        if ($diferenca[4] != "00")
            $retorno .= $diferenca[4] . ":";
        else
            $retorno .= "00:";

        if ($diferenca[5] != "00")
            $retorno .= $diferenca[5];
        else
            $retorno .= "00";
        return $retorno;

    }

    public function somarHoras($horaInicio, $horaFim){
        $times[0] = $horaInicio;
        $times[1] = $horaFim;
        $seconds = 0;

        foreach ($times as $time) {
            list( $g, $i, $s ) = explode(':', $time);
            $seconds += $g * 3600;
            $seconds += $i * 60;
            $seconds += $s;
        }

        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;

        return "{$hours}:{$minutes}:{$seconds}";
    }

    public function adicionarDia($data, $quantidadeDias) {
        $array_data = explode("/", $data);
        return date("d/m/Y", mktime(0, 0, 0, $array_data[1], ((int) $array_data[0] + $quantidadeDias), $array_data[2]));
    }

    function verificarDiaUtil($data) {
        $xdata = explode("/", $data);

        $diasemana = date("w", mktime(0, 0, 0, $xdata[1], $xdata[0], $xdata[2]));

        if (($diasemana == "0") || ($diasemana == "6")) {
            return false;
        } else {
            return true;
        }
    }

    public function diferencaData($d1, $d2, $type = '', $sep = '-') {
        $d1 = explode($sep, $d1);
        $d2 = explode($sep, $d2);

        switch ($type) {
            case 'A': $X = 31536000;
                break;
            case 'M': $X = 2592000;
                break;
            case 'D': $X = 86400;
                break;
            case 'H': $X = 3600;
                break;
            case 'MI': $X = 60;
                break;
            default: $X = 1;
        }

        $n1 = (int) mktime(0, 0, 0, $d2[1], $d2[0], $d2[2]);
        $n2 = (int) mktime(0, 0, 0, $d1[1], $d1[0], $d1[2]);

        $valor = round(($n1 - $n2) / $X);

        return $valor + 1;
    }

    public function converterDecimalParaBanco($valor){

        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);

        return $valor;

    }

}