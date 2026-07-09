// Seleciona o formulário pelo ID
const form = document.getElementById('formCadastro');
const divMensagem = document.getElementById('mensagem');

// Fica "escutando" o evento de envio (submit) do formulário
form.addEventListener('submit', async function(event) {
    // Evita que a página recarregue ao clicar no botão
    event.preventDefault();

    // Captura os valores digitados nos campos
    const nome = document.getElementById('nome').value;
    const email = document.getElementById('email').value;
    const telefone = document.getElementById('telefone').value;

    // Monta o objeto com os dados
    const dadosCliente = {
        nome: nome,
        email: email,
        telefone: telefone
    };

    try {
        // Envia os dados para a nossa API PHP usando o método POST
        const resposta = await fetch('http://localhost:8000/cadastrar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' // Avisa a API que estamos enviando JSON
            },
            body: JSON.stringify(dadosCliente) // Converte o objeto JavaScript em texto JSON
        });

        // Aguarda a resposta da API e converte de volta para objeto
        const resultado = await resposta.json();

        // Verifica o código de status HTTP retornado pelo PHP
        if (resposta.status === 201) {
            // Sucesso
            divMensagem.style.color = 'green';
            divMensagem.textContent = resultado.mensagem;
            form.reset(); // Limpa os campos do formulário
        } else {
            // Erro vindo do servidor
            divMensagem.style.color = 'red';
            divMensagem.textContent = resultado.erro;
        }

    } catch (erro) {
        // Erro de conexão (ex: servidor desligado)
        divMensagem.style.color = 'red';
        divMensagem.textContent = 'Erro ao conectar com o servidor.';
        console.error(erro);
    }
});