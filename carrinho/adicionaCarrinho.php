<?php

try {
    include_once("../conexao.php");

//    echo $_POST['id'];

    $query = $conexao->prepare("Update atendimento_produto set quantidade=:quantidade WHERE idatendimento_produto=:id");
    $query->bindParam(':quantidade', $_POST['quantidade']);
    $query->bindParam(':id', $_POST['id']);
    $query->execute();

    if ($query->rowCount() == 1) {
        retornaOK( 'Alterado com sucesso');
    }
    else {
        retornaOK( 'Alterado com sucesso');
    }

}catch (PDOException $exception) {
    retornaErro('Erro ao inserir' . $exception->getMessage());
}



