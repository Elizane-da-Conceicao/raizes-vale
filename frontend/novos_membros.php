<?php
include 'includes/config.php';
?>
    <div class="ligacoes-container">
        <?php
            include 'includes/header.php';
        ?>
    
        <div class="container">
        <h1 class="titulos-pagina">Novas Ligações</h1>
        <hr>
        <div class="linha" >
            <p>Você deseja inserir esta ligação á qual pessoa?</p>
            <div id="selected-persons"></div>
            <input type="button" value="Pesquisar pessoa" class="input-cadastro" id="openModalButton">
        </div>
        <div class="linha">
            <p>Qual o relacionamento familiar entre elas?</p>
            <p id="pespecial">A pessoa atual é</p>
            <select id="relacao">
                <option value="Conjuge">Cônjuge</option>
                <option value="Filho">Filho</option>
            </select>
        </div>
        <hr>
        <form id="pessoaForm" enctype="multipart/form-data">
            <div id="lados">
                <div id="input-escrever">
                    <div>
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="Nome" class="input-cadastro">
                    </div>
                    <div>
                        <label for="sobrenome" class="form-label">Sobrenomes</label>
                        <input type="text" id="sobrenome" name="sobrenome" placeholder="Sobrenomes" class="input-cadastro">
                    </div>
                    <div>
                        <label for="datanascimento" class="form-label">Data de Nascimento</label>
                        <input type="text" id="datanascimento" name="datanascimento" placeholder="dd/mm/aaaa" class="input-cadastro">
                    </div>
                    <div>
                        <label for="localnascimento" class="form-label">Local de Nascimento</label>
                        <input type="text" id="localnascimento" name="localnascimento" placeholder="Local de Nascimento" class="input-cadastro">
                    </div>
                    <div>
                        <label for="datafalecimento" class="form-label">Data de Falecimento</label>
                        <input type="text" id="datafalecimento" name="datafalecimento" placeholder="dd/mm/aaaa" class="input-cadastro">
                    </div>
                    <div>
                        <label for="localfalecimento" class="form-label">Local de Falecimento</label>
                        <input type="text" id="localfalecimento" name="localfalecimento" placeholder="Local de Falecimento" class="input-cadastro">
                    </div>
                    <div>
                        <label for="historiavida" class="form-label">História de vida</label>
                        <textarea class="area-texto" id="historiavida" name="historiavida" placeholder="Insira um resumo"></textarea>
                    </div>
                </div>
                <div id="lado-direito">
                    <div>
                        <label for="sexo" class="form-label">Sexo</label>
                        <select id="sexo" name="sexo">
                            <option value="Feminino">Feminino</option>
                            <option value="Masculino">Masculino</option>
                        </select>

                        <label id="labelReligiao" for="religiao" class="form-label">Religião</label>
                        <select id="religiao" name="religiao">
                            <option value="Catolica">Católica</option>
                            <option value="Protestante">Protestante</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <p>Você deve inserir documentos que comprovem a existência e a relação da pessoa:</p>
            <div id="documento-relacao">
                <label for="documentos" class="form-label">Documentos comprobatórios</label>
                <input type="button" value="Adicionar Documentos" class="open-modal-btn">
            </div>
            <div id="botoes-direita">
                <div class="centraliza">
                    <input type="button" id="botaoLimpar" class="botoes" value="Limpar">
                    <input type="submit" class="botoes" value="Salvar">
                </div>
            </div>
        </form>

        </div>
    </div>
    <?php
        include 'documento.php';
    ?>
 <div id="modal" class="modal-consulta">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h1 class="titulos-pagina">Consultar Pessoas</h1>
            <form>
                <div id="">
                    <input name="nome" id="consulta-nome" type="text" placeholder="Pesquise pelo nome" class="input-pesquisa">
                </div>
                <div class="table-container">
                    <div class="table-header">
                        <div class="table-cell">Nome</div>
                    </div>
                    <div class='linhas'>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="popupOverlay" class="popup-overlay">
    <div class="popup-content">
      <h2>Aviso</h2>
      <p>Para cadastrar uma nova pessoa você deve estar logado.</p>
      <p> Você será redirecionado para outra página em breve.</p>
</div>
</body>
<script>

function ObterUsuario()
{
    let storedUser = localStorage.getItem('usuarioLogado');
    if (storedUser) {
      storedUser = JSON.parse(storedUser);
      return storedUser;
    }
    return null;
}

document.addEventListener('DOMContentLoaded', function() {

    function aplicarMascaraData(event) {
        var input = event.target;
        var value = input.value.replace(/\D/g, '');
        var formattedValue = '';

        if (value.length > 0) {
            formattedValue = value.substring(0, 2);
        }
        if (value.length > 2) {
            formattedValue += '/' + value.substring(2, 4);
        }
        if (value.length > 4) {
            formattedValue += '/' + value.substring(4, 8);
        }
        
        input.value = formattedValue;
    }
    function permitirSomenteLetras(event) {
        var input = event.target;
        input.value = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚâêîôûÂÊÎÔÛãõÃÕçÇäëïöüÄËÏÖÜ ]/g, '');
    }

    var textoNome = document.getElementById('nome');
    var textoSobrenome = document.getElementById('sobrenome');
    textoNome.addEventListener('input', permitirSomenteLetras);
    textoSobrenome.addEventListener('input', permitirSomenteLetras);


    var dataNasc = document.getElementById('datanascimento');
    var dataFal = document.getElementById('datafalecimento');
    dataNasc.addEventListener('input', aplicarMascaraData);
    dataFal.addEventListener('input', aplicarMascaraData);

    var usuario = ObterUsuario();
    if(usuario == null)
    {
        const popupOverlay = document.getElementById('popupOverlay');
    
        popupOverlay.style.display = 'flex';
        setTimeout(function() {
          window.location.href = '<?php echo $cadastroUsuarioURL; ?>'; 
        }, 10000); 
    }
});

// Event listener para abrir o modal quando o botão for clicado
document.querySelector('.open-modal-btn').addEventListener('click', abrirModal);

function abrirModal() {
  var modal = document.getElementById("myModal");
  if (modal) {
    modal.style.display = "flex"; // Mostrar o modal apenas se for encontrado
  } else {
    console.error("Elemento modal não encontrado.");
  }
}

function getDocumentos() {
      return JSON.parse(localStorage.getItem('documentos')) || [];
  }

// Função para fechar o modal
function fecharModal() {
  var modal = document.getElementById("myModal");
  modal.style.display = "none"; // Esconder o modal
}
  
  function saveDocumento(documento) {
      const documentos = getDocumentos();
      documentos.push(documento);
      localStorage.setItem('documentos', JSON.stringify(documentos));
  }

  function transformarData(dataCampo) {
    if(dataCampo != null)
    {

        var partesData = dataCampo.split('/');
        if (partesData.length === 3) {
            var dia = partesData[0];
            var mes = partesData[1];
            var ano = partesData[2];
        
            var dataTransformada = ano + '/' + mes + '/' + dia;
            return dataTransformada;
        }
            return null;
    }
    return null;
}

  function salvarDocumento() {
      const tipoArquivo = document.getElementById('tipo-arquivo').value;
      const descricao = document.getElementById('descricao').value;
      const arquivoInput = document.getElementById('documento');

      if (tipoArquivo && descricao && arquivoInput.files.length > 0) {
          const file = arquivoInput.files[0];
          const reader = new FileReader();

          reader.onload = function(e) {
              const documento = {
                  type: tipoArquivo,
                  description: descricao,
                  privado: privado,
                  file: e.target.result 
              };

              saveDocumento(documento);
              alert('Documento salvo com sucesso!');
          };

          reader.readAsDataURL(file); 
      } else {
          alert('Por favor, preencha todos os campos e selecione um arquivo.');
      }
  }
    document.getElementById('pessoaForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        var idPessoa = 0;
        try {
            var tagsPessoas = document.getElementsByClassName("person-tag");
            if(tagsPessoas.length == 0 )
            {
                alert('Escolha uma pessoa para inserir a ligação.');
                return;
            }
            for (var i = 0; i < tagsPessoas.length; i++) {
                var tagPessoa = tagsPessoas[i];
                idPessoa = tagPessoa.id;
            }
            
        } catch {
            alert('Escolha uma pessoa para inserir a ligação.');
        }
        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());
        const relacionamento = document.getElementById('relacao').value;
        data.relacao = relacionamento;
        var usuarioLogado = ObterUsuario();
        
        var dataPessoa = {
            "nome": data.nome +" "+data.sobrenome,
            "sexo": data.sexo.charAt(0),
            "data_nascimento": transformarData(data.datanascimento),
            "data_obito": transformarData(data.datafalecimento),
            "local_nascimento": data.localnascimento,
            "local_sepultamento": data.localsepultamento,
            "resumo": data.historiavida,
            "colonizador": '1',
            "usuario_id": usuarioLogado.idUsuario,
            "religiao": data.religiao,
        };
        console.log(dataPessoa);
    
        try {
            const responsePessoa = await fetch('<?php echo $baseAPI; ?>pessoas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dataPessoa),
            });
            console.log(responsePessoa);
            if (responsePessoa.ok) {
                const result = await responsePessoa.json();

                const todosDocumentos = getDocumentos();
                console.log(todosDocumentos);

                for (const documento of todosDocumentos) {
                    const { type, description, file, privado } = documento;

                    const arquivoData = {
                        pessoa_id: result.model.pessoa_id,
                        Descricao: description,
                        Tipo_arquivo: type,
                        arquivo: file,
                        privado: privado == "true" ? 1 : 0,
                        usuario_id: usuarioLogado.idUsuario
                    };

                    try {
                        const response = await fetch('<?php echo $baseAPI; ?>documentos', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(arquivoData),
                        });

                        if (response.ok) {
                            console.log(`Arquivo enviado com sucesso.`);
                        } else {
                            console.error(`Erro ao enviar o arquivo.`);
                        }
                    } catch (error) {
                        console.error(`Erro ao enviar o arquivo`, error);
                    }
                }

                // Limpar localStorage após o envio bem-sucedido
                localStorage.removeItem('documentos');


                if(relacionamento == "Conjuge")
                {   
                    if(data.sexo.charAt(0) == "M")
                    {
                        var marido = result.model.pessoa_id;
                        var esposa = idPessoa;
                    }else{
                        var esposa = result.model.pessoa_id;
                        var marido = idPessoa;
                    }
                    
                    var dataPessoa = {
                        "Marido_id": marido,
                        "Esposa_id": esposa,
                        "Data_casamento": "2024-01-01",
                        "usuario_id": usuarioLogado.idUsuario,
                    };

                    const responseCasal = await fetch('<?php echo $baseAPI; ?>casais', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(dataPessoa),
                    });
                    console.log(responseCasal);
                    if (responseCasal.ok) {
                    }else {
                        alert('Erro ao salvar os dados.');
                    }
                }else{

                    var dataPessoa = {
                        "Filho_id": result.model.pessoa_id,
                        "usuario_id": usuarioLogado.idUsuario,
                        "Pessoa_id": idPessoa
                    };

                    const responseFilho = await fetch('<?php echo $baseAPI; ?>descendencias', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(dataPessoa),
                    });
                    if (responseFilho.ok) {
                        console.log(responseFilho.json());
                    }else {
                        alert('Erro ao salvar os dados.');
                    }
                }

                alert('Dados salvos com sucesso!');
                document.getElementById('pessoaForm').reset();
            } else {
                alert('Erro ao salvar os dados.');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao salvar os dados.');
        }
    });

    document.getElementById('botaoLimpar').addEventListener('click', function() {
        document.getElementById('colonizadorForm').reset();
        document.getElementById('relacao').selectedIndex = 0;
    });
    document.addEventListener('DOMContentLoaded', (event) => {
    const openModalButton = document.getElementById('openModalButton');
    const modal = document.getElementById('modal');
    const closeButton = document.querySelector('.close-button');
    const tableRows = document.querySelectorAll('.table-row');
    const selectedPersonsContainer = document.getElementById('selected-persons');

    openModalButton.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    closeButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    tableRows.forEach(row => {
        row.addEventListener('click', () => {
            const personName = row.querySelector('.table-cell').textContent;
            comsole.log(personName);
                addPersonTag(personName);
            modal.style.display = 'none';
        });
    });

    function addPersonTag(name) {
        const tag = document.createElement('div');
        tag.classList.add('person-tag');
        tag.textContent = name;
        selectedPersonsContainer.appendChild(tag);
    }
});

document.getElementById('consulta-nome').addEventListener('input', async function(event) {
            const nome = event.target.value;
        if (nome.length == 0){
            const tableContainer = document.querySelector('.linhas');
            tableContainer.innerHTML = '';     
        }
        if (nome.length >= 3) { // Fazer a requisição somente se o texto tiver 3 ou mais caracteres
            try {
                var url = "<?php echo $baseAPI; ?>pessoas/consulta/"+nome;
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
                        tableRow.addEventListener('click', () => {
                            const personName = nomeCell.textContent;
                                addPersonTag(personName,pessoa.pessoa.Pessoa_id);
                            modal.style.display = 'none';
                        });

                        function addPersonTag(name,id) {
                            const tag = document.createElement('div');
                            const selectedPersonsContainer = document.getElementById('selected-persons');
                            tag.classList.add('person-tag');
                            tag.id = id;
                            tag.textContent = name;
                            selectedPersonsContainer.appendChild(tag);
                        }

                        tableRow.appendChild(nomeCell);
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

