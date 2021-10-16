<?php

include_once ("../conexao.php");

try{

include(__ROOT__ . '/documentacao.php');
include(__ROOT__ . '/componentes/menu.php');

    $query = $conexao->query('Select produto.nome as nome, atendimento_produto.quantidade as quantidade, atendimento_produto.valorproduto as valor, DATE_FORMAT(atendimento.data_carrinho, "%d/%m/%Y") as data, atendimento.status as status, atendimento_idatendimento as id
                                             from produto inner join atendimento_produto inner join atendimento
                                             on produto.id = atendimento_produto.produto_idproduto && atendimento_produto.atendimento_idatendimento=atendimento.idatendimento 
                                             where ( status = 2 || status = 3) order by data');



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Natural Chá | Pedidos</title>
    <style>
        #imagem{
            width: 75px;

        }
        #texto{
            color: black;
            display: inline-block;
            font-size: x-large;
        }
        #qnt{
            color: #434546;
            display: inline-block;
            font-size: small;
        }
        #produto{
            padding: 10px;
            border-width: thin;
            border-style: solid;
            border-color: #adb5bd;
            border-radius: 10px;
            margin-top: 5px;
        }
    </style>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>

</head>


<body>
<div class="container">
    <br>
    <br>
    <br><br>
    <h1>Pedidos</h1>
    <hr>
    <div id="accordion">
            <?php
            $controle = null;
            while ($linha= $query->fetch()):

            ?>


                    <?php

                    if($controle != $linha->id):
                    ?>
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="<?php echo $linha->if?>">
                        <h3><?php echo $linha->data; ?></h3>

                    </button>

                        <?php
                        if($linha->status == 2):

                            ?>

                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                <div>
                                    Pedido pendente
                                </div>
                            </div>
                        <?php endIf;
                        if($linha->status == 3):
                            ?>

                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                                <div>
                                    Pedido retirado
                                </div>
                            </div>
                        <?php
                        endIf;
                        ?>
                                        </h5>
            </div>

                    <?php
                    $controle = $linha->id;
                    endif;
                    if ($controle == $linha->id):
                        ?>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div id="produto">
                        <img src="../fotos/camomila.jpg" id="imagem">
                        <div id="texto"> <?php echo $linha->nome; ?> </div>
                        <div id="qnt"> Quantidade: <?php echo $linha->quantidade; ?> </div><br>
                        <div id="qnt"> Valor da unidade <?php echo $linha->valor; ?> </div>
                    </div>
                </div>
                    <?php
                        elseif($controle == null):$controle = $linha->id;
                        endif;
                        ?>

            </div>


<?php
    endwhile;
    ?>

    </div>

</div>
</div>
    <footer class="text-muted">
        <div class="container">
            <p class="float-right">
                <a href="#">Voltar ao topo</a>
            </p>
            <p>Natural Chá 2021</p>

        </div>
    </footer>
</body>

    <?php
}catch (PDOException $exception){
    echo $exception->getMessage();
    echo "Deu erro";

}