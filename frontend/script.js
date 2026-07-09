// Seleciona os elementos do HTML
const form = document.getElementById('formCadastro');
const divMensagem = document.getElementById('mensagem');
const corpoTabela = document.getElementById('tabelaClientes');

// Fica "escutando" o evento de envio (submit) do formulário
form.addEventListener('submit', async function(event) {
    event.preventDefault();

    // Captura os valores digitados nos campos
    const nome = document.getElementById('nome').value;
    const email = document.getElementById('email').value;
    const telefone = document.getElementById('telefone').value;

    const dadosCliente = {
        nome: nome,
        email: email,
        telefone: telefone
    };

    try {
        const resposta = await fetch('http://localhost:8000/cadastrar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dadosCliente)
        });

        const resultado = await resposta.json();

        if (resposta.status === 201) {
            divMensagem.style.color = 'green';
            divMensagem.textContent = resultado.mensagem;
            form.reset(); // Limpa os campos do formulário
            carregarClientes(); // Atualiza a tabela com o novo cliente automaticamente
        } else {
            divMensagem.style.color = 'red';
            divMensagem.textContent = resultado.erro;
        }
    } catch (erro) {
        divMensagem.style.color = 'red';
        divMensagem.textContent = 'Erro ao conectar com o servidor.';
        console.error(erro);
    }
});

// Função para buscar e exibir os clientes na tabela
async function carregarClientes() {
    try {
        // Faz uma requisição GET para a rota de listar
        const resposta = await fetch('http://localhost:8000/listar.php');
        const clientes = await resposta.json();

        // Limpa a tabela antes de preencher novamente
        corpoTabela.innerHTML = '';

        // Percorre cada cliente retornado pelo PHP
        clientes.forEach(cliente => {
            const linha = document.createElement('tr');

            linha.innerHTML = `
                <td>${cliente.id}</td>
                <td>${cliente.nome}</td>
                <td>${cliente.email}</td>
                <td style="text-align: center;">
                    <button class="btn-editar">Editar</button>
                    <button class="btn-excluir">Excluir</button>
                </td>
            `;
            corpoTabela.appendChild(linha);
        });
    } catch (erro) {
        console.error("Erro ao carregar clientes:", erro);
    }
}

// Chama a função assim que o script carrega para mostrar a lista
carregarClientes();