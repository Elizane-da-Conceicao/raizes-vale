<?php
if (isset($_GET['parametro'])) {
    $parametro = $_GET['parametro'];
} else {

}
include 'includes/config.php';
include 'documento.php';
?>
    <div class="container-header">
        <?php
        include 'includes/header.php';
        ?>
        <div class="container">
        <h1 class="titulos-pagina">Alterar Pessoa</h1>
        <form id="colonizadorForm">
            <div id="lados">
                <div id="input-escrever">
                    <div>
                        <label for="nome" class="form-label">Nome</label>
                        <input name="nome" id="nome" type="text" placeholder="Nome" class="input-cadastro">
                    </div>
                    <div>
                        <label for="sobrenome" class="form-label">Sobrenomes</label>
                        <input name="sobrenome" id="sobrenome" type="text" placeholder="Sobrenome" class="input-cadastro">
                    </div>
                    <div>
                        <label for="datanascimento" class="form-label">Data de Nascimento</label>
                        <input name="datanascimento" id="datanascimento" type="text" placeholder="dd/mm/aaaa"class="input-cadastro">
                    </div>
                    <div>
                        <label for="localnascimento" class="form-label">Local de Nascimento</label>
                        <input name="localnascimento" id="localnascimento" type="text" placeholder="Local de Nascimento"class="input-cadastro">
                    </div>
                    <div>
                        <label for="datafalecimento" class="form-label">Data de Falecimento</label>
                        <input name="datafalecimento" id="datafalecimento" type="text" placeholder="dd/mm/aaaa"class="input-cadastro">
                    </div>
                    <div>
                        <label for="localfalecimento" class="form-label">Local de Falecimento</label>
                        <input name="localfalecimento" id="localfalecimento" type="text" placeholder="Local de Falecimento"class="input-cadastro">
                    </div>
                    <div>
                        <label for="historiavida" class="form-label">História de vida</label>
                        <textarea name="historiavida" id="historiavida" class="area-texto" placeholder="Insira um resumo"></textarea>
                    </div>
                </div>
                <div id="lado-direito">
                    <div>
                        <label for="name" class="form-label">Sexo</label>
                        <select id="sexo" name="sexo">
                        <option value="Feminino">Feminino</option>
                        <option value="Masculino">Masculino</option>
                        </select>

                    </div>
                    <div>
                        <label for="documentos" class="form-label">Documentos comprobatórios</label>
                        <input type="button" value="Adicionar Documentos" class="open-modal-btn">
                    </div>
                </div>
            </div>
            <div id="botoes-centrelizados">
                    <div class="centraliza">
                    <input id="botaoLimpar" type="reset" class="botoes" value="Limpar">
                    <input type="submit" class="botoes" value="Salvar">
                </div>
            </div>
        </form>
        </div>
    </div>

    <?php
        include 'documento.php';
    ?>
</body>
<script>
function ObterUsuario()
{
    let storedUser = localStorage.getItem('usuarioLogado');
    if (storedUser) {
      storedUser = JSON.parse(storedUser);
      return storedUser;
    }
}

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

 async function fetchData() {
            try {
                var urlPessoa = "http://127.0.0.1:8000/api/pessoas/pessoa/<?php echo($parametro) ?>";
                const responsePessoa = await fetch(urlPessoa, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });

                if (responsePessoa.ok) {
                    const dataRequest = await responsePessoa.json();
                    const data = dataRequest.model;
                    let partesNome = data.Nome.split(' ');
                    let primeiroNome = partesNome[0];
                    let restoNome = partesNome.slice(1).join(' ');

                    document.getElementById('nome').value = primeiroNome || '';
                    document.getElementById('sobrenome').value = restoNome || '';
                    document.getElementById('datanascimento').value = data.Data_nascimento || '';
                    document.getElementById('localnascimento').value = data.Local_nascimento || '';
                    document.getElementById('datafalecimento').value = data.Data_obito || '';
                    document.getElementById('localfalecimento').value = data.Local_sepultamento || '';
                    document.getElementById('historiavida').value = data.Resumo || '';
                    document.getElementById('sexo').value = data.Sexo === "F" ? "Feminino" : "Masculino" || '';
                } else {
                    console.error('Erro ao obter dados da pessoa');
                }
            } catch (error) {
                console.error('Erro ao fazer a requisição', error);
            }
        }
        window.onload = fetchData;
        document.getElementById('botaoLimpar').addEventListener('click', function() {
                document.getElementById('colonizadorForm').reset();
            });

    document.getElementById('colonizadorForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData);
        var usuariolocal = ObterUsuario();
        var dataPessoa = {
            "nome": data.nome +" " + data.sobrenome,
            "sexo": data.sexo.charAt(0),
            "data_nascimento": data.datanascimento,
            "data_obito": data.datafalecimento,
            "local_nascimento": data.localnascimento,
            "local_sepultamento": data.localsepultamento,
            "resumo": data.historiavida,
            "usuario_id": usuariolocal.idUsuario,
        };
        
        try {
            const responsePessoa = await fetch('http://127.0.0.1:8000/api/pessoas/<?php echo($parametro) ?>', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dataPessoa),
            });
            console.log(responsePessoa);
            if (responsePessoa.ok) {
                const resultPessoa = await responsePessoa.json();
                const todosDocumentos = getDocumentos();
                if(todosDocumentos != null)
                {
                    for (const documento of todosDocumentos) {
                        const { type, description, file } = documento;
    
                        const arquivoData = {
                            pessoa_id: resultPessoa.model.pessoa_id,
                            Descricao: description,
                            Tipo_arquivo: type,
                            arquivo: file,
                            usuario_id: dataPessoa.usuario_id
                        };
    
                        try {
                            const response = await fetch('http://127.0.0.1:8000/api/documentos', {
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
                    localStorage.removeItem('documentos');
                    document.getElementById('colonizadorForm').reset();
                    alert('Sucesso ao cadastrar Colonizador');
                }
            }
            else {
                alert('Erro ao adicionar pessoa.');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao adicionar colonizador.');
        }
    });
    </script>