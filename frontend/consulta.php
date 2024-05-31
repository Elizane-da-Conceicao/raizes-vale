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
            <div id="">
                <input name="nome" id="nome" type="text" placeholder="Pesquise pelo nome" class="input-pesquisa">
                <button class="button-adicionar-pessoa" id="addPersonButton">Adicionar pessoa +</button>
            </div>
        <div class="table-container">
            <div class="table-header">
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

    <script>

         document.getElementById('nome').addEventListener('input', async function(event) {
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
                        nomeCell.textContent = pessoa.Nome; 
        
                        const actionsCell = document.createElement('div');
                        actionsCell.classList.add('table-cell', 'actions');
        
                        const imgIcons = ['genealogia.jpg', 'visualizar.jpg', 'lapiseditar.jpg', 'lixeira.jpg'];
                        imgIcons.forEach(icon => {
                            const img = document.createElement('img');
                            img.src = `./assets/img/${icon}`;
                            img.alt = `Icone ${icon.split('.')[0]}`;
                            if (icon === 'genealogia.jpg') {
                                img.addEventListener('click', function() {
                                window.location.href = 'http://localhost/raizes-vale/raizes-vale/frontend/genealogia.php?parametro='+pessoa.Pessoa_id;
                            });
                        }

                            actionsCell.appendChild(img);
                        });
        
                        tableRow.appendChild(nomeCell);
                        tableRow.appendChild(actionsCell);
                        tableContainer.appendChild(tableRow);
                    });
                } else {
                    const tableContainer = document.querySelector('.linhas');
                    tableContainer.innerHTML = '';
                }
            } catch (error) {
                console.error('Erro:', error);
            }
        }
    });
    </script>