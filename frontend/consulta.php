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
                <input type="text" placeholder="Adicionar pessoa" class="input-pesquisa">
            </div>
        <div class="table-container">
            <div class="table-header">
                <div class="table-cell">Nome</div>
                <div class="table-cell actions">Ações</div>
            </div>
            <div class="table-row">
                <div class="table-cell">Augusto Höfelmann</div>
                <div class="table-cell actions">
                <img src="./assets/img/genealogia.jpg" alt="Icone arvore">
                    <img src="./assets/img/visualizar.jpg" alt="Icone arvore">
                    <img src="./assets/img/lapiseditar.jpg" alt="Icone arvore">
                    <img src="./assets/img/lixeira.jpg" alt="Icone arvore">
                </div>
            </div>
            <div class="table-row">
                <div class="table-cell">Henedina Höfelmann</div>
                <div class="table-cell actions">
                    <img src="./assets/img/genealogia.jpg" alt="Icone arvore">
                    <img src="./assets/img/visualizar.jpg" alt="Icone arvore">
                    <img src="./assets/img/lapiseditar.jpg" alt="Icone arvore">
                    <img src="./assets/img/lixeira.jpg" alt="Icone arvore">
                </div>
            </div>
            <div class="table-row">
                <div class="table-cell">Luiza Höfelmann</div>
                <div class="table-cell actions">
                <img src="./assets/img/genealogia.jpg" alt="Icone arvore">
                    <img src="./assets/img/visualizar.jpg" alt="Icone arvore">
                    <img src="./assets/img/lapiseditar.jpg" alt="Icone arvore">
                    <img src="./assets/img/lixeira.jpg" alt="Icone arvore">
                </div>
            </div>
            <div class="table-row">
                <div class="table-cell">Nelson Höfelmann</div>
                <div class="table-cell actions">
                <img src="./assets/img/genealogia.jpg" alt="Icone arvore">
                    <img src="./assets/img/visualizar.jpg" alt="Icone arvore">
                    <img src="./assets/img/lapiseditar.jpg" alt="Icone arvore">
                    <img src="./assets/img/lixeira.jpg" alt="Icone arvore">
                </div>
            </div>
        </div>

            </div>
        </form>
        </div>
    </div>

    <script>
         document.getElementById('nome').addEventListener('input', async function(event) {
        const nome = event.target.value;

        if (nome.length >= 3) { // Fazer a requisição somente se o texto tiver 3 ou mais caracteres
            try {
                var dataPessoa = {
                    "nome": nome
                };
                const responseFamilia = await fetch('http://127.0.0.1:8000/api/pessoas', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataPessoa),
                });
                if (responsePessoas.ok) {
                    const data = await response.json();
                    console.log(data);
                    // Aqui você pode atualizar a UI com os dados recebidos
                } else {
                    console.error('Erro ao buscar dados');
                }
            } catch (error) {
                console.error('Erro:', error);
            }
        }
    });
    </script>