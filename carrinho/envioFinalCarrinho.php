<?php

try{
    include_once("../conexao.php");

    $nome = $_POST['nome'];
    $hora_prevista = $_POST['hora_prevista'];
    $observacao = $_POST['observacao'];
    $forma_pagamento = $_POST['forma_pagamento'];
    $dia = $_POST['dia_previsto'];

    $dataAtual = strtotime("15 minutes");
    $dataPrevista = strtotime($dia. ' ' .$hora_prevista);

    if($dataAtual > $dataPrevista){
        retornaErro("Data/Hora devem ser maior que 15 minutos da atual");
    }

    if( $forma_pagamento == 'outro'){
        $forma_pagamento = $_POST['outros_forma_pagamento'];
    }

    $inserir = $conexao->prepare("Insert into controla_retirada (hora_prevista, dia_retirada, quem_retira, meio_pagamento, atendimento_id, observacao)
                                        values (:hora, :dia, :quem, :pagamento, :atendimento, :observacao)");
    $inserir->bindParam(":hora", $hora_prevista);
    $inserir->bindParam(":dia", $dia);
    $inserir->bindParam(":quem", $nome);
    $inserir->bindParam("pagamento", $forma_pagamento);
    $inserir->bindParam(":atendimento", $_COOKIE['carrinho']);
    $inserir->bindParam(":observacao", $observacao);
    $inserir->execute();

    if($inserir->rowCount()==1){
        $valor = 2;
        $valida = $conexao->prepare("Update atendimento set status=:status WHERE idatendimento=:id");
        $valida->bindParam(":status", $valor);
        $valida->bindParam(":id", $_COOKIE['carrinho']);
        $valida->execute();

        if ($valida->rowCount() == 1) {
            retornaOK("Seu pedido foi enviado com sucessso");
        } else {
            retornaErro("Erro ao enviar seu pedido");
        }
    }else {
        retornaErro("Ocorreu um erro");
    }

}catch (PDOException $exception){
    retornaErro($exception->getMessage());
}