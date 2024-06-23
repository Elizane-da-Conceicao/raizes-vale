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
                <button type="button" class="button-adicionar-pessoa" id="addPersonButton">Adicionar pessoa +</button>
            </div>
            <div class="table-container">
                <div class="table-header-consulta">
                    <div class="table-cell">Nome</div>
                    <div class="table-cell actions">Ações</div>
                </div>
                <div class="linhas">
                    <!-- Linhas da tabela irão aqui -->
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
        <p id="modal-ins-religiao"></p>
        <hr>
        <h4>Família</h4>
        <p id="modal-ins-casamento"></p>
        <p id="modal-ins-filhos"></p>
        <hr>
        <h4>História e Acontecimentos</h4>
        <p id="modal-ins-resumo"></p>
        <h4>Documentos:</h4>
        <ul id="fileList"></ul>
    </div>
</div>

<!-- Modal de Imagem -->
<div id="imageModal" class="modal">
    <div class="modal-content">
        <span class="close-button" id="closeImageModal">&times;</span>
        <div id="fileContainer"></div>
    </div>
</div>

<script>
function ObterUsuario() {
    let storedUser = localStorage.getItem('usuarioLogado');
    if (storedUser) {
        storedUser = JSON.parse(storedUser);
        return storedUser;
    }
    return null;
}

document.getElementById('nome').addEventListener('input', async function(event) {
    const nome = event.target.value;
    const tableContainer = document.querySelector('.linhas');

    if (nome.length === 0) {
        tableContainer.innerHTML = '';
        return;
    }

    if (nome.length >= 3) { 
        try {
            const url = `<?php echo $baseAPI; ?>pessoas/consulta/${nome}`;
            const responsePessoas = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            if (responsePessoas.ok) {
                const data = await responsePessoas.json();
                const pessoas = data.model;
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
                    const usuario = ObterUsuario();

                    imgIcons.forEach(icon => {
                        if (icon !== 'lixeira.jpg') {
                            const img = document.createElement('img');
                            img.src = `./assets/img/${icon}`;
                            img.alt = `Icone ${icon.split('.')[0]}`;
                            img.addEventListener('click', function() {
                                if (icon === 'genealogia.jpg') {
                                    window.location.href = `<?php echo $baseURL; ?>/genealogia.php?parametro=${pessoa.pessoa.Pessoa_id}`;
                                } else if (icon === 'visualizar.jpg') {
                                    abrirModal(pessoa);
                                } else if (icon === 'lapiseditar.jpg') {
                                    window.location.href = `<?php echo $baseURL; ?>/alteracao.php?parametro=${pessoa.pessoa.Pessoa_id}`;
                                }
                            });
                            actionsCell.appendChild(img);
                        } else if (usuario != null && usuario.administrador === 2) {
                            const img = document.createElement('img');
                            img.src = `./assets/img/${icon}`;
                            img.alt = `Icone ${icon.split('.')[0]}`;
                            img.addEventListener('click', () => excluirPessoa(pessoa.pessoa.Pessoa_id));
                            actionsCell.appendChild(img);
                        }
                    });

                    tableRow.appendChild(nomeCell);
                    tableRow.appendChild(actionsCell);
                    tableContainer.appendChild(tableRow);
                });

                async function abrirModal(pessoa) {
                    const modal = document.getElementById("infoModal");
                    const modalNome = document.getElementById("modal-ins-nome");
                    const modalNascimento = document.getElementById("modal-ins-nascimento");
                    const modalMorte = document.getElementById("modal-ins-morte");
                    const modalCasamento = document.getElementById("modal-ins-casamento");
                    const modalFilhos = document.getElementById("modal-ins-filhos");
                    const modalResumo = document.getElementById("modal-ins-resumo");
                    const modalReligiao = document.getElementById("modal-ins-religiao");
                    const fileList = document.getElementById("fileList");
                    var usuario = ObterUsuario();

                    modalNome.textContent = pessoa.pessoa.Nome;
                    modalNascimento.textContent = "Nasceu em " + formatarData(pessoa.pessoa.Data_nascimento) + " em " + pessoa.pessoa.Local_nascimento;
                    modalMorte.textContent = pessoa.pessoa.Data_obito ? "Faleceu em " + formatarData(pessoa.pessoa.Data_obito) + " em " + pessoa.pessoa.Local_sepultamento : "Não informado";
                    modalCasamento.textContent = pessoa.conjuge.Pessoa_id ? "Casou-se em " + formatarData(pessoa.pessoa.Data_casamento) + " com " + pessoa.conjuge.Nome : "Não se casou.";
                    modalFilhos.textContent = pessoa.descendentes && pessoa.descendentes.length > 0 ? "Tiveram os filhos: " + stringFilhos(pessoa.descendentes) : "Não tiveram filhos.";
                    modalResumo.textContent = pessoa.pessoa.Resumo;
                    modalReligiao.textContent = pessoa.pessoa.Religiao;

                    try {
                        const url = `<?php echo $baseAPI; ?>documentos/${pessoa.pessoa.Pessoa_id}`;
                        const responseDocumentos = await fetch(url, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                        });

                        if (responseDocumentos.ok) {
                            const data = await responseDocumentos.json();
                            const files = data.model;
                            fileList.innerHTML = '';

                            files.forEach(file => {
                                const listItem = document.createElement('li');
                                const link = document.createElement('a');
                                link.href = "#";
                                link.textContent = file.nome;
                                link.classList.add("listaDocumento");
                                if (file.privado == 1 && (usuario == null || usuario.administrador == 1)) {
                                    link.textContent = file.nome +" "+"🔒";
                                }else{
                                    link.onclick = function(event) {
                                        event.preventDefault();
                                        mostrarImagem(file.caminho); 
                                    };
                                }
                                listItem.appendChild(link);
                                fileList.appendChild(listItem);
                            });
                        }
                    } catch (error) {
                        console.error('Erro ao buscar documentos:', error);
                    }

                    modal.style.display = "block";
                }

                function formatarData(dataString) {
                    const data = new Date(dataString);
                    const meses = ["janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro"];
                    const dia = data.getDate();
                    const mes = meses[data.getMonth()];
                    const ano = data.getFullYear();
                    return `${dia} de ${mes} de ${ano}`;
                }

                function stringFilhos(filhos) {
                    return filhos.map(filho => filho.Nome).join(", ");
                }

                function mostrarImagem(caminho) {
                    const imageModal = document.getElementById('imageModal');
                    const fileContainer = document.getElementById('fileContainer');
                    fileContainer.innerHTML = ''; // Limpa o conteúdo anterior

                    const fileUrl = "<?php echo($baseURLAquivos); ?>"+caminho;
                    const extension = fileUrl.split('.').pop().toLowerCase();

                    if (extension === 'pdf') {
                        window.open(fileUrl, '_blank');
                    } else if (extension === 'png' || extension === 'jpeg' || extension === 'jpg') {
                        const img = document.createElement('img');
                        img.src = fileUrl;
                        img.id = "modalImage";
                        fileContainer.appendChild(img);
                        imageModal.style.display = "block";
                    } else {
                        console.error('Formato de arquivo não suportado');
                    }
                }

                const closeButton = document.getElementsByClassName("close-button")[0];
                closeButton.onclick = function() {
                    const modal = document.getElementById("infoModal");
                    modal.style.display = "none";
                };

                window.onclick = function(event) {
                    const modal = document.getElementById("infoModal");
                    if (event.target === modal) {
                        modal.style.display = "none";
                    }
                };
            } else {
                tableContainer.innerHTML = '';
            }
        } catch (error) {
            console.error('Erro:', error);
        }
    }
});

async function excluirPessoa(id) {
    const url = `<?php echo $baseAPI; ?>pessoas/${id}`;
    const responsePessoas = await fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
    });
    if (responsePessoas.ok) {
        alert('Pessoa excluída com sucesso');
        const tableContainer = document.querySelector('.linhas');
        tableContainer.innerHTML = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const addPersonButton = document.getElementById('addPersonButton');
    addPersonButton.addEventListener('click', function() {
        const url = "<?php echo $inserirPessoasLigacoes; ?>";
        window.location.href = url;
    });

    const closeImageModal = document.getElementById('closeImageModal');
    closeImageModal.onclick = function() {
        const imageModal = document.getElementById('imageModal');
        imageModal.style.display = "none";
    };

    window.onclick = function(event) {
        const imageModal = document.getElementById('imageModal');
        if (event.target === imageModal) {
            imageModal.style.display = "none";
        }
    };
});
</script>