<?php
// processar_pagamento.php

// Verificando se o formulário foi submetido via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $cartao = isset($_POST['cartao']) ? trim($_POST['cartao']) : '';
    $valor = isset($_POST['valor']) ? trim($_POST['valor']) : '';

    // Validação simples
    if (empty($nome) || empty($cartao) || empty($valor)) {
        header("Location: erro.html"); // Se faltar algum dado, redireciona para erro
        exit();
    }

    // Verificação do formato do número do cartão (apenas para fins de exemplo)
    // Verificando se o número do cartão tem 16 dígitos
    if (!preg_match('/^\d{16}$/', $cartao)) {
        header("Location: erro.html"); // Se o número do cartão for inválido, redireciona para erro
        exit();
    }

    // Verificando se o valor é um número positivo (apenas dois decimais permitidos)
    if (!preg_match('/^\d+(\.\d{2})?$/', $valor)) {
        header("Location: erro.html"); // Se o valor for inválido, redireciona para erro
        exit();
    }

    // Lógica fictícia de processamento de pagamento (substitua com uma API real de pagamento)
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

