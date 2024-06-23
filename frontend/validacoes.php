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
                <input type="text" placeholder="Pesquisar" class="input-pesquisa-tela">

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
<div id="infoModal" class="modal-info-pessoa">
    <div id="modal-info-content" class="modal-info-content">
        <span class="close-button-vali">&times;</span>
        <h3 id="modal-ins-nome"></h3>
        <p id="modal-ins-religiao"></p>
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
        <h4>Documentos:</h4>
        <ul id="fileList"></ul>
    </div>
</div>
<div id="infoModalSolicitacao" class="modal-info-pessoa-alteracao">
<div id="modal-info-content-soli" class="modal-info-content-soli">
    <div class="modal-info-content-atual">
        <h3 id="modal-ins-a">Atual</h3>
        <h3 id="modal-ins-nome-a"></h3>
        <p id="modal-ins-religiao-a"></p>
        <h4>Informações Básicas</h4>
        <p id="modal-ins-nascimento-a"></p>
        <p id="modal-ins-morte-a"></p>
        <hr>
        <h4>Família</h4>
        <p id="modal-ins-casamento-a"></p>
        <p id="modal-ins-filhos-a"></p>
        <hr>
        <h4>Historia e Acontecimentos</h4>
        <p id="modal-ins-resumo-a"></p>
        <h4>Documentos:</h4>
        <ul id="fileList-a"></ul>
    </div>
    <div class="modal-info-content-solicitacao">
        <span class="close-button-soli">&times;</span>
        <h3 id="modal-ins-a">Solicitação</h3>
        <h3 id="modal-ins-nome-s"></h3>
        <p id="modal-ins-religiao-s"></p>
        <h4>Informações Básicas</h4>
        <p id="modal-ins-nascimento-s"></p>
        <p id="modal-ins-morte-s"></p>
        <hr>
        <h4>Família</h4>
        <p id="modal-ins-casamento-s"></p>
        <p id="modal-ins-filhos-s"></p>
        <hr>
        <h4>Historia e Acontecimentos</h4>
        <p id="modal-ins-resumo-s"></p>
        <h4>Documentos:</h4>
        <ul id="fileList-s"></ul>
    </div>
</div>
</div>

<!-- Modal de Imagem -->
<div id="imageModal" class="modal">
    <div class="modal-content">
        <span class="close-button" id="closeImageModal">&times;</span>
        <div id="fileContainer"></div>
    </div>
</div>

<div id="popupOverlay" class="popup-overlay">
    <div class="popup-content">
      <h2>Aviso</h2>
      <p>Usuario sem permissão para acessar essa tela.</p>
      <p> Você será redirecionado para outra página em breve.</p>
    </div>
</div>



</body>
<script>

function ObterUsuario()
{
    let storedUser = localStorage.getItem('usuarioLogado');
    if (storedUser) {
      storedUser = JSON.parse(storedUser);
      console.log(storedUser);
      return storedUser;
    }
    return null;
}

document.addEventListener('DOMContentLoaded', function() {

    var usuario = ObterUsuario();
    if(usuario == null || usuario.administrador == 1)
    {
        const popupOverlay = document.getElementById('popupOverlay');
        popupOverlay.style.display = 'flex';
        setTimeout(function() {
          window.location.href = '<?php echo $consulta; ?>'; 
        }, 10000); 
    }
    else{
        CarregaTabela()
    }
});

async function CarregaTabela(){
    var usuario = ObterUsuario();
    const tabelaValidacao = document.getElementById("tabela-validacao").getElementsByTagName('tbody')[0];
    tabelaValidacao.innerHTML = ''; 
    const modal = document.getElementById("infoModal");
    const modalSolicitacao = document.getElementById("infoModalSolicitacao");
    const closeButton = document.getElementsByClassName("close-button")[0];
    const modalNome = document.getElementById("modal-ins-nome");
    const modalNascimento = document.getElementById("modal-ins-nascimento");
    const modalMorte = document.getElementById("modal-ins-morte");
    const modalCasamento = document.getElementById("modal-ins-casamento");
    const modalFilhos = document.getElementById("modal-ins-filhos");
    const modalResumo = document.getElementById("modal-ins-resumo");
    const modalReligiao = document.getElementById("modal-ins-religiao");
    const fileList = document.getElementById("fileList");
    //Atual
    const modalNomeA = document.getElementById("modal-ins-nome-a");
    const modalNascimentoA = document.getElementById("modal-ins-nascimento-a");
    const modalMorteA = document.getElementById("modal-ins-morte-a");
    const modalCasamentoA = document.getElementById("modal-ins-casamento-a");
    const modalFilhosA = document.getElementById("modal-ins-filhos-a");
    const modalResumoA = document.getElementById("modal-ins-resumo-a");
    const modalReligiaoA = document.getElementById("modal-ins-religiao-a");
    const fileListA = document.getElementById("fileList-a");
    //Solicitacao
    const modalNomeS = document.getElementById("modal-ins-nome-s");
    const modalNascimentoS = document.getElementById("modal-ins-nascimento-s");
    const modalMorteS = document.getElementById("modal-ins-morte-s");
    const modalCasamentoS = document.getElementById("modal-ins-casamento-s");
    const modalFilhosS = document.getElementById("modal-ins-filhos-s");
    const modalResumoS = document.getElementById("modal-ins-resumo-s");
    const modalReligiaoS = document.getElementById("modal-ins-religiao-s");
    const fileListS = document.getElementById("fileList-s");

    try {
        var urlPessoa = "<?php echo $baseAPI; ?>validacoes";
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
                acoesCell.classList.add('acoes'); 
                const imgIcons = ['fichavalidacao.jpg', 'validacaoaceita.jpg', 'validacaonegada.jpg'];
                imgIcons.forEach(icon => {
                    const img = document.createElement('img');
                    img.src = `./assets/img/${icon}`;
                    img.alt = `Icone ${icon.split('.')[0]}`;
                    acoesCell.appendChild(img);
                    if (icon === 'fichavalidacao.jpg') {
                        img.addEventListener('click', () => {
                            abrirModalInsert(pessoa);
                        });
                    }
                    if (icon === 'validacaoaceita.jpg') {
                        img.addEventListener('click', () => {
                            validacao(pessoa.pessoa,1,2);
                        });
                    }
                    if (icon === 'validacaonegada.jpg') {
                        img.addEventListener('click', () => {
                            validacao(pessoa.pessoa,1,3);
                        });
                    }
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
                acoesCell.classList.add('acoes'); 
                const imgIcons = ['fichavalidacao.jpg', 'validacaoaceita.jpg', 'validacaonegada.jpg'];
                imgIcons.forEach(icon => {
                    const img = document.createElement('img');
                    img.src = `./assets/img/${icon}`;
                    img.alt = `Icone ${icon.split('.')[0]}`;
                    acoesCell.appendChild(img);
                    if (icon === 'fichavalidacao.jpg') {
                        img.addEventListener('click', () => {
                            abrirModalUpdate(pessoa);
                        });
                    }
                    if (icon === 'validacaoaceita.jpg') {
                        img.addEventListener('click', () => {
                            validacao(pessoa,2,2);
                        });
                    }
                    if (icon === 'validacaonegada.jpg') {
                        img.addEventListener('click', () => {
                            validacao(pessoa,2,3);
                        });
                    }
                });
                linha.appendChild(acoesCell);
        
                tabelaValidacao.appendChild(linha);
            });
            window.addEventListener("click", function(event) {
            if (event.target == modal) {
                    modal.style.display = "none";
                }
            });

            async function abrirModalUpdate(pessoa) {
                console.log(pessoa);
                modalNomeS.textContent = pessoa.pessoa.Nome;
                modalNascimentoS.textContent = "Nasceu em "+formatarData(pessoa.pessoa.Data_nascimento)+" em "+pessoa.pessoa.Local_nascimento;
                modalMorteS.textContent = pessoa.pessoa.Data_obito != null ? "Faleceu "+formatarData(pessoa.pessoa.Data_obito) ?? "Data de morte não informada"+ " em "+pessoa.pessoa.Local_sepultamento : null;
                modalCasamentoS.textContent = pessoa.pessoaOriginal.conjuge.Pessoa_id != null || pessoa.pessoaOriginal.conjuge.length > 0 ? "Casou-se em "+( formatarData(pessoa.pessoa.Data_casamento) ?? "Data de casamento não informada")+" com "+pessoa.pessoaOriginal.conjuge.Nome : "Não se casou." ;
                modalFilhosS.textContent = pessoa.pessoaOriginal.descendentes != null && pessoa.pessoaOriginal.descendentes.length > 0 ? "Tiveram os filhos: "+stringFilhos(pessoa.pessoaOriginal.descendentes) : "Não tiveram filhos.";
                modalResumoS.textContent = pessoa.pessoa.Resumo;
                modalReligiaoS.textContent = pessoa.pessoa.Religiao;

                try {
                    const url = `<?php echo $baseAPI; ?>documentos/solicitacao/${pessoa.pessoa.Pessoa_id_solicitacao}`;
                    const responseDocumentos = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    });

                    if (responseDocumentos.ok) {
                        const data = await responseDocumentos.json();
                        console.log(data);
                        const files = data.model;
                        fileListS.innerHTML = '';

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
                            fileListS.appendChild(listItem);
                        });
                    }
                } catch (error) {
                    console.error('Erro ao buscar documentos:', error);
                }

                modalNomeA.textContent = pessoa.pessoaOriginal.pessoa.Nome;
                modalNascimentoA.textContent = "Nasceu em "+formatarData(pessoa.pessoaOriginal.pessoa.Data_nascimento)+" em "+pessoa.pessoaOriginal.pessoa.Local_nascimento;
                modalMorteA.textContent = pessoa.pessoaOriginal.pessoa.Data_obito != null ? "Faleceu "+formatarData(pessoa.pessoaOriginal.pessoa.Data_obito) ?? "Data de morte não informada"+ " em "+pessoa.pessoaOriginal.pessoa.Local_sepultamento : null;
                modalCasamentoA.textContent = pessoa.pessoaOriginal.conjuge.Pessoa_id != null || pessoa.pessoaOriginal.conjuge.length > 0 ? "Casou-se em "+( formatarData(pessoa.pessoaOriginal.pessoa.Data_casamento) ?? "Data de casamento não informada")+" com "+pessoa.pessoaOriginal.conjuge.Nome : "Não se casou." ;
                modalFilhosA.textContent = pessoa.pessoaOriginal.descendentes != null && pessoa.pessoaOriginal.descendentes.length > 0 ? "Tiveram os filhos: "+stringFilhos(pessoa.pessoaOriginal.descendentes) : "Não tiveram filhos.";
                modalResumoA.textContent = pessoa.pessoaOriginal.pessoa.Resumo;
                modalReligiaoA.textContent = pessoa.pessoaOriginal.pessoa.Religiao;

                try {
                    const url = `<?php echo $baseAPI; ?>documentos/${pessoa.pessoaOriginal.pessoa.Pessoa_id}`;
                    const responseDocumentos = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    });

                    if (responseDocumentos.ok) {
                        const data = await responseDocumentos.json();
                        const files = data.model;
                        fileListA.innerHTML = '';

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
                            fileListA.appendChild(listItem);
                        });
                    }
                } catch (error) {
                    console.error('Erro ao buscar documentos:', error);
                }

                modalSolicitacao.style.display = "block";
            }

            async function abrirModalInsert(pessoa) {
                console.log(pessoa);
                modalNome.textContent = pessoa.pessoa.Nome;
                modalNascimento.textContent = "Nasceu em "+formatarData(pessoa.pessoa.Data_nascimento)+" em "+pessoa.pessoa.Local_nascimento;
                modalMorte.textContent = pessoa.pessoa.Data_obito != null ? "Faleceu "+formatarData(pessoa.pessoa.Data_obito) ?? "Data de morte não informada"+ " em "+pessoa.pessoa.Local_sepultamento : null;
                modalCasamento.textContent = pessoa.conjuge.Pessoa_id != null || pessoa.conjuge.length > 0 ? "Casou-se em "+( formatarData(pessoa.pessoa.Data_casamento) ?? "Data de casamento não informada")+" com "+pessoa.conjuge.Nome : "Não se casou." ;
                modalFilhos.textContent = pessoa.descendentes != null && pessoa.descendentes.length > 0 ? "Tiveram os filhos: "+stringFilhos(pessoa.descendentes) : "Não tiveram filhos.";
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
                var stringFilhos = "";
                filhos.forEach(filho => {
                    stringFilhos = stringFilhos + filho.Nome+",";
                });
                return stringFilhos;
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
                const modal = document.getElementById("imageModal");
                modal.style.display = "none";
            };

            window.onclick = function(event) {
                const modal = document.getElementById("imageModal");
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            };
            
        } else {
          console.error("Erro ao buscar dados da árvore:", responseArvore.status);
        }
    } catch (error) {
      console.error("Erro na requisição:", error);
    }
};

async function validacao(pessoa,tipo,status) {
                var url = "<?php echo $baseAPI; ?>pessoas";
                var dataValidacao = {};
                console.log(pessoa);
                if(tipo === 1)
                {
                    url = url+"/validacao/"+pessoa.Pessoa_id;
                    dataValidacao = {
                        "validado": status,
	                    "motivo": "Dados inconscistentes"
                    };
                }else{
                    url = url+"/validacao/solicitacao/"+pessoa.pessoa.Pessoa_id_solicitacao;
                    dataValidacao = {
                        "idPessoa": pessoa.pessoa.Pessoa_id,
                        "validado": status,
	                    "motivo": "Dados inconscistentes",
                    };
                }

                const responseValidacao = await fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataValidacao),
                });

                if(responseValidacao.ok)
                {
                    alert(`Validação processada com sucesso`);
                    CarregaTabela();
                }

                // alert(`Validação aceita para: ${pessoa.nome}`);
            }
    
document.addEventListener('DOMContentLoaded', function() {
      const modal = document.getElementById('infoModalSolicitacao');
      const modalInsert = document.getElementById('infoModal');
      const closeButton = document.querySelector('.close-button-vali');
      const closeButtonSoli = document.querySelector('.close-button-soli');

      closeButton.addEventListener('click', function() {
        modalInsert.style.display = "none";
      });

      closeButtonSoli.addEventListener('click', function() {
        modal.style.display = "none";
      });
    });
</script>