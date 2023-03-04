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

}