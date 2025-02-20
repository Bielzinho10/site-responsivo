<?php
// processar_pagamento.php

// Verificando se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $cartao = isset($_POST['cartao']) ? trim($_POST['cartao']) : '';
    $valor = isset($_POST['valor']) ? trim($_POST['valor']) : '';

    // Validação simples (você pode fazer validações mais completas)
    if (empty($nome) || empty($cartao) || empty($valor)) {
        header("Location: erro.html"); // Se faltar algum dado, redireciona para erro
        exit();
    }

    // Lógica fictícia de processamento de pagamento
    // Substitua isso por uma chamada de API real de pagamento
    if ($cartao == "1234567890123456" && $valor == "100.00") {
        // Pagamento aprovado
        header("Location: sucesso.html"); // Redireciona para a página de sucesso
    } else {
        // Pagamento recusado
        header("Location: erro.html"); // Redireciona para a página de erro
    }
    exit();
} else {
    // Se não for um POST, redireciona para o formulário
    header("Location: formulario_pagamento.html");
    exit();
}
?>
