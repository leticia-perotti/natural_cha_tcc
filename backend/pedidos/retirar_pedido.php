<?php
include "../configurações/conexao.php";
try {
    $query=$conexao->prepare("UPDATE atendimento set status=3 WHERE idatendimento=:id");
    $query-> bindValue(":id",$_POST ['id']);
    $query->execute();

    $queryretirada= $conexao->prepare("Update controla_retirada set hora_retirada=NOW() WHERE atendimento_id=:id");
    $queryretirada-> bindValue(":id",$_POST ['id']);
    $queryretirada->execute();

    if($queryretirada->rowCount()==1 && $query->rowCount()==1 ){
        retornaOK("Status alterado com sucesso");
    }else{
        retornaErro("ERRO");
    }

}catch (PDOException $exception){
    echo $exception->getMessage();
}