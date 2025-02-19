<?php
// Carregar o autoloader do Composer
require_once 'vendor/autoload.php';

// Defina sua chave secreta do Stripe (não deve ser compartilhada com ninguém)
\Stripe\Stripe::setApiKey('sk_test_suaChaveSecretaAqui');

// Verificar se os dados necessários foram recebidos pelo formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do pagamento do formulário
    $token = $_POST['stripeToken'];  // O token do Stripe gerado no front-end
    $amount = 1000; // Exemplo: valor do pagamento em centavos (R$10,00)

    try {
        // Criar um novo pagamento no Stripe
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount,  // O valor em centavos
            'currency' => 'brl',   // Moeda brasileira
            'payment_method' => $token, // O token gerado pelo Stripe.js
            'confirmation_method' => 'manual',
            'confirm' => true,
        ]);

        // Verificar se o pagamento foi bem-sucedido
        if ($paymentIntent->status == 'succeeded') {
            echo 'Pagamento realizado com sucesso!';
        } else {
            echo 'Pagamento falhou, por favor tente novamente.';
        }

    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Caso algum erro aconteça ao comunicar com a API do Stripe
        echo 'Erro ao processar pagamento: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
</head>
<body>
    <h2>Realizar Pagamento</h2>

    <!-- Formulário de pagamento -->
    <form action="processar_pagamento.php" method="POST" id="payment-form">
        <div>
            <label for="card-element">
                Cartão de Crédito:
            </label>
            <div id="card-element">
                <!-- Um campo de entrada do cartão de crédito será inserido aqui pelo Stripe.js -->
            </div>
            <!-- Usado para mostrar erros no campo -->
            <div id="card-errors" role="alert"></div>
        </div>
        <button type="submit">Pagar R$10,00</button>
    </form>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('pk_test_suaChavePublicaAqui');  // Sua chave pública do Stripe
        var elements = stripe.elements();
        var style = {
            base: {
                color: "#32325d",
                lineHeight: "24px",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            }
        };
        var card = elements.create("card", {style: style});
        card.mount("#card-element");

        // Handle form submission
        var form = document.getElementById("payment-form");
        form.addEventListener("submit", function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Exibe erro
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Envia o token para o servidor
                    var token = result.token.id;

                    // Adiciona o token no formulário e envia para o PHP
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', token);
                    form.appendChild(hiddenInput);

                    // Envia o formulário
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>
  <!-- Rodapé -->
  <footer class="bg-dark text-white text-center py-4">
    <p>&copy; 2025 Cruzeiro Esporte Clube | Todos os direitos reservados.</p>
  </footer>

  <!-- Scripts do Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
