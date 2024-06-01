<?php
include 'includes/config.php';
?>
    <div class="container-header">
    <?php
    include 'includes/header.php';
    ?>
        <div class="container">
        <h1 class="titulos-pagina">Solicitações Pendentes</h1>
        <form>
            <div id="">
                <input type="text" placeholder="Pesquisar" class="input-pesquisa">

                <table id="tabela-validacao">
                <thead>
                    <tr>
                        <th>Pessoa</th>
                        <th>Solicitante</th>
                        <th>Evento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>

            </div>
        </form>
        </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", async function() {

    const tabelaValidacao = document.getElementById("tabela-validacao").getElementsByTagName('tbody')[0];
    try {
        var urlPessoa = "http://127.0.0.1:8000/api/validacoes";
        const responsePessoa = await fetch(urlPessoa, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
        });

        if(responsePessoa.ok)
        {
            const resultPessoa = await responsePessoa.json();
            resultPessoa.insert.pessoas.forEach(pessoa => {
                const linha = document.createElement('tr');
        
                const nomeCell = document.createElement('td');
                nomeCell.textContent = pessoa.pessoa.Nome;
                linha.appendChild(nomeCell);
        
                const responsavelCell = document.createElement('td');
                responsavelCell.textContent = pessoa.solicitante.Nome;
                linha.appendChild(responsavelCell);
        
                const statusCell = document.createElement('td');
                statusCell.textContent = "Inserção";
                linha.appendChild(statusCell);
        
                const acoesCell = document.createElement('td');
                const imgIcons = ['fichavalidacao.jpg', 'validacaoaceita.jpg', 'validacaonegada.jpg'];
                imgIcons.forEach(icon => {
                    const img = document.createElement('img');
                    img.src = `./assets/img/${icon}`;
                    img.alt = `Icone ${icon.split('.')[0]}`;
                    acoesCell.appendChild(img);
                });
                linha.appendChild(acoesCell);
        
                tabelaValidacao.appendChild(linha);
            });
            resultPessoa.update.pessoas.forEach(pessoa => {
                const linha = document.createElement('tr');
        
                const nomeCell = document.createElement('td');
                nomeCell.textContent = pessoa.pessoa.Nome;
                linha.appendChild(nomeCell);
        
                const responsavelCell = document.createElement('td');
                responsavelCell.textContent = pessoa.solicitante.Nome;
                linha.appendChild(responsavelCell);
        
                const statusCell = document.createElement('td');
                statusCell.textContent = "Alteração";
                linha.appendChild(statusCell);
        
                const acoesCell = document.createElement('td');
                const imgIcons = ['fichavalidacao.jpg', 'validacaoaceita.jpg', 'validacaonegada.jpg'];
                imgIcons.forEach(icon => {
                    const img = document.createElement('img');
                    img.src = `./assets/img/${icon}`;
                    img.alt = `Icone ${icon.split('.')[0]}`;
                    acoesCell.appendChild(img);
                });
                linha.appendChild(acoesCell);
        
                tabelaValidacao.appendChild(linha);
            });
            
        } else {
          console.error("Erro ao buscar dados da árvore:", responseArvore.status);
        }
    } catch (error) {
      console.error("Erro na requisição:", error);
    }
});
</script>