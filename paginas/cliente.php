<?php
    include_once("../php/validador_acesso.php");
    include_once("../php/conexao.php");

    $cpf = $_SESSION["login_usuário"];

    $stmt = $conexao->prepare("SELECT nome_completo FROM Clientes WHERE cpf = '$cpf'");
    if($stmt->execute()){
        $retorno_consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $nome = $retorno_consulta[0]['nome_completo'];
    }

    $num_conta = $_POST['num_conta'];
    $senha_informada = md5($_POST['senha']);

    $stmt = $conexao->prepare("SELECT Clientes_cpf FROM Possui WHERE Contas_num_conta = '$num_conta'");
    if($stmt->execute()){
        $retorno_consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $cpf_informado = $retorno_consulta[0]['Clientes_cpf'];
        if($cpf !== $cpf_informado){
            header('Location: escolha-conta.php?conta=erro');
        }
    }

    $stmt = $conexao->prepare("SELECT senha FROM Contas WHERE num_conta = '$num_conta'");
    if($stmt->execute()){
        $retorno_consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $senha = $retorno_consulta[0]['senha'];
        if($senha !== $senha_informada){
            header('Location: escolha-conta.php?senha=erro');
        }
    }

    $stmt = $conexao->prepare("SELECT saldo FROM CONTAS WHERE num_conta = '$num_conta'");
    if($stmt->execute()){
        $retorno_consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $saldo = $retorno_consulta[0]['saldo'];
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nullbank</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700;900&display=swap" rel="stylesheet"> 

    <link rel="stylesheet" href="../estilos/global.css">
    <link rel="stylesheet" href="../estilos/cliente.css">

</head>
<body>
    <a class="back-page-btn" href="../php/logoff.php">Sair</a>
    <header class="header">
        <h1 class="logo">Nullbank</h1>
    </header>
    <main class="main">
        <section class="section-info">
            <div class="card">
                <img class="icon" src="../imagens/user.png" alt="icone do usuário">
                <div>
                    <h3 class="card-text">Usuário</h3>
                    <p class="card-value"><?php echo $nome ?></p>
                </div>
            </div>

            <div class="card">
                <img class="icon" src="../imagens/real-brasileiro.png" alt="icone do usuário">
                <div>
                    <h3 class="card-text">Saldo</h3>
                    <p class="card-value"><?php echo $saldo ?></p>
                </div>
            </div>
        </section>

        <section class="section-services">
            <h2 class="title">Todos os serviços</h2>
            <div class="services-area">
                <div class="service-card">
                    <h3>Saques</h3>
                    <hr/>
                </div>

                <div class="service-card">
                    <h3>Depósitos</h3>
                    <hr/>
                </div>

                <div class="service-card">
                    <h3>Transferências</h3>
                    <hr/>
                </div>

                <div class="service-card">
                    <h3>Estorno</h3>
                    <hr/>
                </div>
            </div>
            <button class="btn-select-trasaction" onclick="Modal.open()">Realizar transação</button>
        </section>
    </main>

    <div class="modal-overlay" onclick="">
        <div class="modal">
            <a class="close-modal" onclick="Modal.close()">Cancelar</a>
            <h2 class="form-title">Nova transação</h2>

            <form class="modal-form" action="" method="POST">
                <h3 class="subtitle">Selecione um tipo de transação</h3>
                <select name="select_transacoes" class="select_trancacoes" required>
                    <option id="opition_saque" value="saque">Saque</option>
                    <option id="opition_deposito" value="deposito">Depósito</option>
                    <option id="opition_transferencia" value="transferencia">Transferência</option>
                    <option id="opition_estorno" value="estorno">Estorno</option>
                </select>

                <h3 class="subtitle">Selecione o valor transação</h3>
                <input type="text" name="valor_saque" placeholder="Valor do saque" required>
                <button class="btn-submit-trasaction" type="submit">Confirmar</button>
            </form>
        </div>
    </div>

    <script>
        const Modal = {
            open(){
                document
                    .querySelector(".modal-overlay")
                    .classList
                    .add("active")
            },
            close(){
                document
                    .querySelector(".modal-overlay")
                    .classList
                    .remove("active")
            }
        }
    </script>
</body>
</html>