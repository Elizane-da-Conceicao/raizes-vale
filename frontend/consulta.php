<?php
include 'includes/config.php';
?>
    <div class="container-header">
    <?php
    include 'includes/header.php';
    ?>
        <div class="container">
        <h1 class="titulos-pagina">Consultar Pessoas</h1>
        <form>
            <div id="consulta-pessoas">
                <input name="nome" id="nome" type="text" placeholder="Pesquise pelo nome" class="input-pesquisa-tela">
                <button class="button-adicionar-pessoa" id="addPersonButton">Adicionar pessoa +</button>
            </div>
        <div class="table-container">
            <div class="table-header-consulta">
                <div class="table-cell">Nome</div>
                <div class="table-cell actions">Ações</div>
            </div>
            <div class='linhas'>

            </div>
            
        </div>

            </div>
        </form>
        </div>
    </div>
    <div id="infoModal" class="modal-info-pessoa">
    <div class="modal-info-content">
        <span class="close-button">&times;</span>
        <h3 id="modal-ins-nome"></h3>
        <h4>Informações Básicas</h4>
        <p id="modal-ins-nascimento"></p>
        <p id="modal-ins-morte"></p>
        <hr>
        <h4>Família</h4>
        <p id="modal-ins-casamento"></p>
        <p id="modal-ins-filhos"></p>
        <hr>
        <h4>Historia e Acontecimentos</h4>
        <p id="modal-ins-resumo"></p>
    </div>
</div>

<script>

function ObterUsuario()
{
    let storedUser = localStorage.getItem('usuarioLogado');
    if (storedUser) {
      storedUser = JSON.parse(storedUser);
      return storedUser;
    }
}
         document.getElementById('nome').addEventListener('input', async function(event) {
            const modal = document.getElementById("infoModal");
            const closeButton = document.getElementsByClassName("close-button")[0];
            const modalNome = document.getElementById("modal-ins-nome");
            const modalNascimento = document.getElementById("modal-ins-nascimento");
            const modalMorte = document.getElementById("modal-ins-morte");
            const modalCasamento = document.getElementById("modal-ins-casamento");
            const modalFilhos = document.getElementById("modal-ins-filhos");
            const modalResumo = document.getElementById("modal-ins-resumo");
            const nome = event.target.value;
        if (nome.length == 0){
            const tableContainer = document.querySelector('.linhas');
            tableContainer.innerHTML = '';     
        }
        if (nome.length >= 3) { // Fazer a requisição somente se o texto tiver 3 ou mais caracteres
            try {
                var url = "http://127.0.0.1:8000/api/pessoas/consulta/"+nome;
                const responsePessoas = await fetch( url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });
                if (responsePessoas.ok) {
                    const data = await responsePessoas.json();
                    const pessoas = data.model;
                    // Aqui você pode atualizar a UI com os dados recebidos
                    const tableContainer = document.querySelector('.linhas');
                    tableContainer.innerHTML = '';
                    pessoas.forEach(pessoa => {
                        const tableRow = document.createElement('div');
                        tableRow.classList.add('table-row');
        
                        const nomeCell = document.createElement('div');
                        nomeCell.classList.add('table-cell');
                        nomeCell.textContent = pessoa.pessoa.Nome; 
        
                        const actionsCell = document.createElement('div');
                        actionsCell.classList.add('table-cell', 'actions');
                        const imgIcons = ['genealogia.jpg', 'visualizar.jpg', 'lapiseditar.jpg', 'lixeira.jpg'];
                        imgIcons.forEach(icon => {
                            const usuario = ObterUsuario();
                            if(icon !== 'lixeira.jpg' ){
                                const img = document.createElement('img');
                                img.src = `./assets/img/${icon}`;
                                img.alt = `Icone ${icon.split('.')[0]}`;
                                if (icon === 'genealogia.jpg') {
                                    img.addEventListener('click', function() {
                                        window.location.href = 'http://localhost/raizes-vale/raizes-vale/frontend/genealogia.php?parametro='+pessoa.pessoa.Pessoa_id;
                                    });
                                }    
                                if (icon === 'visualizar.jpg') {
                                    img.addEventListener('click', () => {
                                        abrirModal(pessoa);
                                    });
                                }
                                if (icon === 'lapiseditar.jpg') {
                                    img.addEventListener('click', function() {
                                        window.location.href = 'http://localhost/raizes-vale/raizes-vale/frontend/alteracao.php?parametro='+pessoa.pessoa.Pessoa_id;
                                    });
                                }     
    
                                actionsCell.appendChild(img);
                            }else if(usuario.administrador == 2){
                                const img = document.createElement('img');
                                img.src = `./assets/img/${icon}`;
                                img.alt = `Icone ${icon.split('.')[0]}`;
                                img.addEventListener('click', () => {
                                        excluirPessoa(pessoa.pessoa.Pessoa_id);
                                });
                                actionsCell.appendChild(img);
                            }
                        });
        
                        tableRow.appendChild(nomeCell);
                        tableRow.appendChild(actionsCell);
                        tableContainer.appendChild(tableRow);
                    });

                    function abrirModal(pessoa) {
                        console.log(pessoa);
                        modalNome.textContent = pessoa.pessoa.Nome;
                        modalNascimento.textContent = "Nasceu em "+formatarData(pessoa.pessoa.Data_nascimento)+" em "+pessoa.pessoa.Local_nascimento;
                        modalMorte.textContent = pessoa.pessoa.Data_obito != null ? "Faleceu "+formatarData(pessoa.pessoa.Data_obito) ?? "Data de morte não informada"+ " em "+pessoa.pessoa.Local_sepultamento : null;
                        modalCasamento.textContent = pessoa.conjuge.Pessoa_id != null || pessoa.conjuge.length > 0 ? "Casou-se em "+( formatarData(pessoa.pessoa.Data_casamento) ?? "Data de casamento não informada")+" com "+pessoa.conjuge.Nome : "Não se casou." ;
                        modalFilhos.textContent = pessoa.descendentes != null && pessoa.descendentes.length > 0 ? "Tiveram os filhos: "+stringFilhos(pessoa.descendentes) : "Não tiveram filhos.";
                        modalResumo.textContent = pessoa.pessoa.Resumo;
                        modal.style.display = "block";
                    }
        
                    function formatarData(dataString) {
                        // Criar um objeto Date a partir da string de data
                        const data = new Date(dataString);
                    
                        // Array de meses em português
                        const meses = [
                            "janeiro", "fevereiro", "março", "abril", "maio", "junho",
                            "julho", "agosto", "setembro", "outubro", "novembro", "dezembro"
                        ];
                    
                        // Extrair dia, mês e ano do objeto Date
                        const dia = data.getDate();
                        const mes = meses[data.getMonth()];
                        const ano = data.getFullYear();
                    
                        // Retornar a data formatada
                        return `${dia} de ${mes} de ${ano}`;
                    }

                    function stringFilhos(filhos) 
                    {
                        console.log(filhos);
                        var stringFilhos = "";
                        filhos.forEach(filho => {
                            stringFilhos = stringFilhos + filho.Nome+",";
                        });
                        return stringFilhos;
                    }

                } else {
                    const tableContainer = document.querySelector('.linhas');
                    tableContainer.innerHTML = '';
                }
            } catch (error) {
                console.error('Erro:', error);
            }
        }
    });
async function excluirPessoa(id)
{
    var url = "http://127.0.0.1:8000/api/pessoas/"+id;
    const responsePessoas = await fetch( url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
    });
    if(responsePessoas.ok)
    {
        alert(`Pessoa excluida com sucesso`);
    }
    const tableContainer = document.querySelector('.linhas');
    tableContainer.innerHTML = '';

}

document.addEventListener('DOMContentLoaded', function() {
      const addPersonButton = document.getElementById('addPersonButton');

      addPersonButton.addEventListener('click', function() {
        var url = "<?php echo $inserirPessoasLigacoes; ?>";
        console.log(url);
        window.location.href = url; 
      });
    });
    </script>