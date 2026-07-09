const form = document.getElementById('formCadastro');
const divMensagem = document.getElementById('mensagem');
const corpoTabela = document.getElementById('tabelaClientes');
const inputId = document.getElementById('clienteId');
const tituloFormulario = document.getElementById('tituloFormulario');
const btnSalvar = document.getElementById('btnSalvar');
const btnCancelar = document.getElementById('btnCancelar');

// Evento de SUBMIT (Serve tanto para Cadastrar quanto para Editar)
form.addEventListener('submit', async function(event) {
    event.preventDefault();

    const id = inputId.value;
    const nome = document.getElementById('nome').value;
    const email = document.getElementById('email').value;
    const telefone = document.getElementById('telefone').value;

    const dadosCliente = { nome, email, telefone };

    // Se o campo ID estiver preenchido, é EDIÇÃO. Se não, é CADASTRO.
    let url = 'http://localhost:8000/cadastrar.php';
    let metodo = 'POST';

    if (id) {
        url = 'http://localhost:8000/editar.php';
        metodo = 'PUT';
        dadosCliente.id = id; // Adiciona o ID no pacote de dados
    }

    try {
        const resposta = await fetch(url, {
            method: metodo,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dadosCliente)
        });

        const resultado = await resposta.json();

        if (resposta.status === 201 || resposta.status === 200) {
            divMensagem.style.color = 'green';
            divMensagem.textContent = resultado.mensagem;
            cancelarEdicao(); // Limpa o form e volta ao modo "Cadastro"
            carregarClientes(); // Atualiza a tabela
        } else {
            divMensagem.style.color = 'red';
            divMensagem.textContent = resultado.erro;
        }
    } catch (erro) {
        divMensagem.style.color = 'red';
        divMensagem.textContent = 'Erro ao conectar com o servidor.';
    }
});

// Busca os clientes e desenha a tabela
async function carregarClientes() {
    try {
        const resposta = await fetch('http://localhost:8000/listar.php');
        const clientes = await resposta.json();

        corpoTabela.innerHTML = '';

        clientes.forEach(cliente => {
            const linha = document.createElement('tr');

            linha.innerHTML = `
                <td>${cliente.id}</td>
                <td>${cliente.nome}</td>
                <td>${cliente.email}</td>
                <td style="text-align: center;">
                    <button class="btn-editar" onclick="prepararEdicao(${cliente.id}, '${cliente.nome}', '${cliente.email}', '${cliente.telefone}')">Editar</button>
                    <button class="btn-excluir" onclick="excluirCliente(${cliente.id})">Excluir</button>
                </td>
            `;
            corpoTabela.appendChild(linha);
        });
    } catch (erro) {
        console.error("Erro ao carregar clientes:", erro);
    }
}

// Prepara o formulário para Editar
function prepararEdicao(id, nome, email, telefone) {
    inputId.value = id;
    document.getElementById('nome').value = nome;
    document.getElementById('email').value = email;
    document.getElementById('telefone').value = telefone;

    tituloFormulario.textContent = "Editar Cliente";
    btnSalvar.textContent = "Salvar Alterações";
    btnCancelar.style.display = "block"; // Mostra o botão cancelar
    divMensagem.textContent = ""; // Limpa mensagens antigas
    
    // Rola a tela para o topo para facilitar
    window.scrollTo(0, 0);
}

// Cancela a edição e volta o formulário ao normal
function cancelarEdicao() {
    inputId.value = "";
    form.reset();
    tituloFormulario.textContent = "Novo Cliente";
    btnSalvar.textContent = "Cadastrar";
    btnCancelar.style.display = "none"; // Esconde o botão cancelar
}

// Função de Excluir
async function excluirCliente(id) {
    // Pede confirmação antes de apagar
    if (confirm("Tem certeza que deseja excluir este cliente?")) {
        try {
            const resposta = await fetch('http://localhost:8000/deletar.php?id=' + id, {
                method: 'DELETE'
            });

            const resultado = await resposta.json();

            if (resposta.status === 200) {
                divMensagem.style.color = 'green';
                divMensagem.textContent = resultado.mensagem;
                carregarClientes(); // Atualiza a tabela
            } else {
                divMensagem.style.color = 'red';
                divMensagem.textContent = resultado.erro;
            }
        } catch (erro) {
            divMensagem.style.color = 'red';
            divMensagem.textContent = 'Erro ao conectar com o servidor para excluir.';
        }
    }
}

// Carrega os dados assim que entra na tela
carregarClientes();