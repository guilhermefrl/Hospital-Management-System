<?php

    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['receitar'])){             //Caso o médico tenha terminado uma consulta

        //Guardar os dados inseridos nos campos
        $ID_CONSULTA= $_POST['id_modal'];
        $diagnostico = $_POST['diagnostico'];
        $observacoes = $_POST['observacoes'];
        $preco = $_POST['preco'];
        $medicamentos = $_POST['medicamentos'];
        date_default_timezone_set('Europe/Lisbon');
        $timestamp = date("Y-m-d H:i:s");               //Guardar a data e hora em que a consulta foi terminada

        //Atualizar a tabela consulta com os dados da consulta
        $sql4 = "UPDATE consulta SET DIAGNOSTICO = '$diagnostico', OBSERVACOES = '$observacoes', PRECO = '$preco', DATA = '$timestamp' WHERE consulta.ID_CONSULTA = $ID_CONSULTA";
        $result4 = mysqli_query($conn, $sql4);        //Executar a query na base de dados

        //Query para mudar o estado da consulta para 3, ou seja, terminada
        $sql5 = "UPDATE pedido_consulta, consulta SET ESTADO = 3 WHERE consulta.ID_CONSULTA = $ID_CONSULTA AND consulta.ID_PEDIDO=pedido_consulta.ID_PEDIDO";
        $result5 = mysqli_query($conn, $sql5);        //Executar a query na base de dados

        //Para todos os medicamentos receitados na consulta, inserir na tabela utente_medicamento o ID de cada medicamento e da consulta
        if(count($medicamentos) > 1){
            for ($i=0;$i<count($medicamentos)-1;$i++){
                $aux=$medicamentos[$i];
                $sql6 ="INSERT INTO utente_medicamento (ID_CONSULTA, ID_MEDICAMENTO) VALUES ('$ID_CONSULTA', '$aux');";
                $result6 = mysqli_query($conn, $sql6);
            }
        }

        //--------------------------------------------------------
        // Gerar PDF
        //---------------------------------------------------------

        //Query para ir buscar todos os dados da consulta
        $sql = "SELECT DISTINCT utilizador.ID_UTILIZADOR, utilizador.EMAIL,utilizador.NOME_COMPLETO, (DATE_FORMAT(utente.DATA_NASCIMENTO, '%d/%m/%Y')) AS DATA_NASCIMENTO, utente.TELEMOVEL, consulta.DATA, consulta.DIAGNOSTICO, consulta.OBSERVACOES, consulta.PRECO FROM utilizador, utente, pedido_consulta, consulta WHERE consulta.ID_CONSULTA=$ID_CONSULTA AND consulta.ID_PEDIDO=pedido_consulta.ID_PEDIDO AND pedido_consulta.ID_UTENTE=utente.ID_UTENTE AND utente.ID_UTILIZADOR=utilizador.ID_UTILIZADOR";
        $result = mysqli_query($conn, $sql);  //Executar a query na base de dados
        $row = mysqli_fetch_assoc($result);   //Guardar na variável um array que corresponde aos dados da linha do resultado da query

        //Guardar os dados resultantes da query
        $ID_UTILIZADOR = $row['ID_UTILIZADOR'];
        $NOME_COMPLETO = $row['NOME_COMPLETO'];
        $DATA_NASCIMENTO = $row['DATA_NASCIMENTO'];
        $TELEMOVEL = $row['TELEMOVEL'];
        $DIAGNOSTICO = $row['DIAGNOSTICO'];
        $OBSERVACOES = $row['OBSERVACOES'];
        $PRECO = $row['PRECO'];
        $EMAIL = $row['EMAIL'];

        //Separar o datetime em dia e hora
        $aux1=$row["DATA"];
        list($second,$first) = explode(' ',strrev($aux1),2);
        $first = strrev($first);
        $second = strrev($second);
    
        $dia = date("d/m/Y", strtotime($first));
        $hora = date("H:i", strtotime($second));

        //Query para ir buscar os dados do médico
        $sql1 = "SELECT DISTINCT utilizador.NOME_COMPLETO, utilizador.EMAIL, (especialidades.NOME) AS ESPECIALIDADE FROM utilizador, medico, pedido_consulta, consulta, especialidades WHERE consulta.ID_CONSULTA=$ID_CONSULTA AND consulta.ID_PEDIDO=pedido_consulta.ID_PEDIDO AND pedido_consulta.ID_MEDICO=medico.ID_MEDICO AND medico.ID_UTILIZADOR=utilizador.ID_UTILIZADOR AND medico.ESPECIALIDADE=especialidades.ID_ESPECIALIDADE";
        $result1 = mysqli_query($conn, $sql1);  //Executar a query na base de dados
        $row1 = mysqli_fetch_assoc($result1);   //Guardar na variável um array que corresponde aos dados da linha do resultado da query

        //Guardar os dados resultantes da query
        $NOME_MEDICO = $row1['NOME_COMPLETO'];
        $EMAIL_MEDICO = $row1['EMAIL'];
        $ESPECIALIDADE_MEDICO = $row1['ESPECIALIDADE'];

        //Query para ir buscar os dados dos medicamentos da consulta
        $sql2 = "SELECT DISTINCT medicamento.NOME, medicamento.LABORATORIO, medicamento.PRECO FROM medicamento, utente_medicamento WHERE utente_medicamento.ID_CONSULTA=$ID_CONSULTA AND utente_medicamento.ID_MEDICAMENTO=medicamento.ID_MEDICAMENTO";
        $result2 = mysqli_query($conn, $sql2);  //Executar a query na base de dados

        //Query para somar os preços dos medicamentos da consulta
        $sql3 = "SELECT SUM(medicamento.PRECO) AS PRECO_TOTAL FROM medicamento, utente_medicamento WHERE utente_medicamento.ID_CONSULTA=$ID_CONSULTA AND utente_medicamento.ID_MEDICAMENTO=medicamento.ID_MEDICAMENTO";
        $result3 = mysqli_query($conn, $sql3);  //Executar a query na base de dados
        $row3 = mysqli_fetch_assoc($result3);   //Guardar na variável um array que corresponde aos dados da linha do resultado da query
        $PRECO_TOTAL = $row3['PRECO_TOTAL'];    //Guardar o preço total dos medicamentos

        require_once($_SERVER['DOCUMENT_ROOT'].'/projeto/generate_pdf/tcpdf.php');  //É usada a biblioteca TCPDF parar gerar o pdf

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Consulta #'.$ID_CONSULTA.'');

        $pdf->SetFont('helvetica', '', 10);

        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


        $pdf->AddPage();

        $html = <<<EOF

        <div style="text-align: center;">
            <h1 style="text-align: center; font-size: 18px;">Hospital</h1>
            <h1 style="text-align: center; font-size: 18px;">Registo de Consulta</h1>
        </div>

        <table class="first" cellpadding="1" cellspacing="6">
        <tr>
            <td width="450" align="left"><div style="font-size: 14px;"><u>Informação do utente:</u></div></td>
            <td width="300" align="left"><div style="font-size: 14px;"><u>Informação do médico:</u></div></td>
        </tr>
        <tr>
        <td width="450">ID: #$ID_UTILIZADOR<br />Nome: $NOME_COMPLETO<br />Data de Nascimento: $DATA_NASCIMENTO<br />Telefone: $TELEMOVEL</td>
        <td width="300">Nome: $NOME_MEDICO<br />Especialidade: $ESPECIALIDADE_MEDICO<br />Email: $EMAIL_MEDICO</td>

        </tr>
        </table>

        <p style="text-align: center; font-size: 16px; text-decoration: underline;">Detalhes da Consulta</p>
        <div style="line-height: 1;">
        <p>ID: #$ID_CONSULTA</p>
        <p>Dia: $dia</p>
        <p>Hora: $hora</p>
        </div>

        <table style="border: 1px solid black;">
            <tr>
                <td><div style="text-align: center; font-size: 13px;">Diagnóstico</div></td>
            </tr>
        </table>
        <br />
        <br />
        <table>
            <tr>
                <td><div style="font-size: 10px;">$DIAGNOSTICO</div></td>
            </tr>
        </table>
        <br />
        <br />
        <br />
        <table style="border: 1px solid black;">
            <tr>
                <td><div style="text-align: center; font-size: 13px;">Observações</div></td>
            </tr>
        </table>
        <br />
        <br />
        <table>
            <tr>
                <td><div style="font-size: 10px;">$OBSERVACOES</div></td>
            </tr>
        </table>
        <br />
        <br />
        <br />
        <table style="border: 1px solid black;">
            <tr>
                <td><div style="text-align: center; font-size: 13px;">Preço da Consulta</div></td>
            </tr>
        </table>
        <br />
        <br />
        <table>
            <tr>
                <td><div style="font-size: 10px;">$PRECO €</div></td>
            </tr>
        </table>
        <br />
        <br />
        <br />
        <table style="border: 1px solid black;">
            <tr>
                <td><div style="text-align: center; font-size: 13px;">Medicamentos</div></td>
            </tr>
        </table>
        <br />
        EOF;


        if(mysqli_num_rows($result2) === 0){    //Caso não tenham sido receitados medicamentos
            $html1 = '
            <p style="text-align: center;">Não foram receitados medicamentos.</p>
            ';

            $html = $html.''.$html1;

            $pdf->writeHTML($html, true, false, true, false, '');     //Gerar o pdf

            //------------------------------------------------------------
            // Fim do Ficheiro
            //------------------------------------------------------------
        }
        else{       //Caso tenham sido receitados medicamentos
            $html1 = '
            <table border="1">
                <tr>
                    <th colspan="9"><div style="text-align: center; font-size: 13px;"><b>Nome</b></div></th>
                    <th colspan="9"><div style="text-align: center; font-size: 13px;"><b>Laboratório</b></div></th>
                    <th colspan="9"><div style="text-align: center; font-size: 13px;"><b>Preço</b></div></th>
                </tr>
            ';
            
            $html = $html.'<br /><br />'.$html1;

            $htmlx='';

            while($row2 = mysqli_fetch_array($result2)){    //Mostrar todos os medicamentos
                $html2= '
                    <tr>
                        <td colspan="9"><div style="text-align: center; font-size: 13px;">'.$row2["NOME"].'</div></td>
                        <td colspan="9"><div style="text-align: center; font-size: 13px;">'.$row2["LABORATORIO"].'</div></td>
                        <td colspan="9"><div style="text-align: center; font-size: 13px;">'.$row2["PRECO"].' €</div></td>
                    </tr>
                ';
                $htmlx = $htmlx.''.$html2;
            }

            $html = $html.''.$htmlx;

            $html3='
            </table>
            <table>
                <tr>
                    <td></td>
                    <td><div style="text-align: rigth; font-size: 13px;"><b>Total:    </b></div></td>
                    <td><div style="text-align: center; font-size: 13px; border: 1px solid black;">'.$PRECO_TOTAL.' €</div></td>
                </tr>
            </table>
            ';

            $html = $html.''.$html3;

            $pdf->writeHTML($html, true, false, true, false, '');     //Gerar o pdf

            //------------------------------------------------------------
            // Fim do Ficheiro
            //------------------------------------------------------------
        }

        //------------------------------------------------------------
        // Enviar Email
        //------------------------------------------------------------

        $fileName = 'Consulta_'.$ID_CONSULTA.'.pdf';
        $pdfdoc = $pdf->Output('', 'S');

        require_once $_SERVER['DOCUMENT_ROOT'].'/projeto/mail/config.php';      //É usada a biblioteca PHPMailer para enviar o email

        $mail->setFrom('noreplyprojetohospital@gmail.com', 'Hospital');
        $mail->addAddress($EMAIL);
    
        $mail->isHTML(true);
        $mail->Subject = utf8_decode('Consulta #'.$ID_CONSULTA.' terminada!');
    
        $mail->Body = utf8_decode('<b>Caro(a) '.$NOME_COMPLETO.',</b><br><br>A consulta do dia '.$dia.' às '.$hora.' foi terminada!<br>O PDF relativo à consulta está em anexo.');

        $mail->addStringAttachment($pdfdoc, $fileName);     //Anexar pdf
    
        $mail->send();

        if(count($medicamentos) === 1){     //Caso não tenham sido receitados medicamentos na consulta
            header("Location: /projeto/medico/consultas/ver_consultas.php?success= Consulta terminada!");  //Mensagem de sucesso
            exit();
        }
        else{       //Caso tenham sido receitados medicamentos na consulta
            if($result4 && $result5){       //Caso não tenha ocorrido nenhum erro
                header("Location: /projeto/medico/consultas/ver_consultas.php?success= Consulta terminada!");  //Mensagem de sucesso
                exit();
            }
        }
    }
    else{
        header("Location: /projeto/medico/");
    }

?>