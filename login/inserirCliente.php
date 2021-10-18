<?php

try {
    include_once("../conexao.php");
    //include(__ROOT__ . '/documentacao.php');

    $nome = $_POST["nomeCliente"];
    $telefone = $_POST['telefoneCliente'];
    $email = $_POST['emailCliente'];
    $cpf = $_POST['cpfCliente'];
    $cidade = $_POST['cidadeCliente'];
    $uf = $_POST['ufCliente'];
    $data = $_POST['dataCliente'];

    if (validaCPF($cpf)==false){
//    if (!validaCPF($_POST['cpf'])){
        retornaErro("CPF invalido");
    }

    $valida = $conexao->prepare("Select * from cliente where cpf =:cpf || email =:email");
    $valida->bindParam(":cpf", $cpf);
    $valida->bindParam(":email", $email);
    $valida->execute();

    if ($valida->rowCount()!= 0){
        retornaErro("CPF ou email já existentes");
    }

    $inserir = $conexao->prepare('Insert into cliente (nome, telefone, email, cpf, cidade, uf, datanascimento) 
                                  values 
                                  (:nome, :telefone, :email,:cpf, :cidade, :uf, :nasc)');
    $inserir->bindParam(":nome", $nome);
    $inserir->bindParam(":telefone", $telefone);
    $inserir->bindParam(":email", $email);
    $inserir->bindParam(":cpf", $cpf);
    $inserir->bindParam(":cidade", $cidade);
    $inserir->bindParam(":uf", $uf);
    $inserir->bindParam(":nasc", $data);
    $inserir->execute();

    $_SESSION['cliente_autorizado'] = true;

    if ($inserir->rowCount() == 1) {
        retornaOK("Valor inserido com sucesso");
    } else {
        retornaErro("Nenhum dado alterado");
    }

}catch (PDOException $exception) {
    retornaErro($exception->getMessage());
}
