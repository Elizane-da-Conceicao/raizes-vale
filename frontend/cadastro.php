<?php
include 'includes/config.php';
include 'documento.php';
?>
    <div class="container-header">
        <?php
        include 'includes/header.php';
        ?>
        <div class="container">
        <h1 class="titulos-pagina">Adicionar Colonizador</h1>
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

  
  function saveDocumento(documento) {
      const documentos = getDocumentos();
      documentos.push(documento);
      localStorage.setItem('documentos', JSON.stringify(documentos));
  }

  function salvarDocumento() {
      const tipoArquivo = document.getElementById('tipo-arquivo').value;
    //   const titulo = document.getElementById('titulo').value;
      const descricao = document.getElementById('descricao').value;
      const arquivoInput = document.getElementById('documento');

      if (tipoArquivo && descricao && arquivoInput.files.length > 0) {
          const file = arquivoInput.files[0];
          const reader = new FileReader();

          reader.onload = function(e) {
              const documento = {
                  type: tipoArquivo,
                  title: titulo,
                  description: descricao,
                  file: e.target.result // Armazenar o conteúdo do arquivo como uma URL Base64
              };

              saveDocumento(documento);
              alert('Documento salvo com sucesso!');
          };

          reader.readAsDataURL(file); // Ler o arquivo como uma URL Base64
      } else {
          alert('Por favor, preencha todos os campos e selecione um arquivo.');
      }
  }

    document.getElementById('botaoLimpar').addEventListener('click', function() {
                document.getElementById('colonizadorForm').reset();
            });

    document.getElementById('colonizadorForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData);

        var dataFamilia = {
            "Nome": data.sobrenome,
            "Data_criacao": new Date(),
            "Resumo": "Resumo da família",
            "Colonizador": "2",
            "usuario_id": 1
        };

        var dataPessoa = {
            "nome": data.nome,
            "sexo": data.sexo.charAt(0),
            "data_nascimento": data.datanascimento,
            "data_obito": data.datafalecimento,
            "local_nascimento": data.localnascimento,
            "local_sepultamento": data.localsepultamento,
            "resumo": data.historiavida,
            "colonizador": '2',
            "usuario_id": 1
        };

        console.log(data);

        try {
            const responseFamilia = await fetch('http://127.0.0.1:8000/api/familias', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dataFamilia),
            });
            console.log(responseFamilia);
            if (responseFamilia.ok) {
                const resultFamilia = await responseFamilia.json();
                console.log(resultFamilia);

                const responsePessoa = await fetch('http://127.0.0.1:8000/api/pessoas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataPessoa),
                });
                if (responsePessoa.ok) {
                    const resultPessoa = await responsePessoa.json();
                    console.log(resultPessoa);
                    console.log(resultFamilia);
                    var dataFamiliaColonizadora = {
                        "Colonizador_id": resultPessoa.model.pessoa_id,
                        "Familia_id": resultFamilia.model.familia_id,
                        "Data_chegada": "1998-03-02",
                        "Comentarios": data.historiavida,
                        "usuario_id": 1
                    };
                    console.log(dataFamiliaColonizadora);
                    const responseFamiliaColonizadora = await fetch('http://127.0.0.1:8000/api/familias-colonizadoras', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(dataFamiliaColonizadora),
                    });
                    if (responseFamiliaColonizadora.ok) {
                        // const nomesArquivos = Object.keys(localStorage);
                        // const todosDocumentos = localStorage.getItem('documentos');
                        // console.log(todosDocumentos);

                        // todosDocumentos.forEach(arquivo => {
                            // console.log(arquivo);
                            const todosDocumentos = getDocumentos();
                    console.log(todosDocumentos);

                    for (const documento of todosDocumentos) {
                        const { type, description, file } = documento;

                        const arquivoData = {
                            pessoa_id: resultPessoa.model.pessoa_id,
                            Descricao: description,
                            Tipo_arquivo: type,
                            arquivo: file,
                            usuario_id: 1
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
                                console.log(`Arquivo ${title} enviado com sucesso.`);
                            } else {
                                console.error(`Erro ao enviar o arquivo ${title}.`);
                            }
                        } catch (error) {
                            console.error(`Erro ao enviar o arquivo ${title}:`, error);
                        }
                    }

                    // Limpar localStorage após o envio bem-sucedido
                    localStorage.removeItem('documentos');
                            


                        document.getElementById('colonizadorForm').reset();
                        alert('Sucesso ao cadastrar Colonizador');
                    }
                } else {
                    alert('Erro ao adicionar pessoa.');
                }
            } else {
                alert('Erro ao adicionar família.');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao adicionar colonizador.');
        }
    })


</script>