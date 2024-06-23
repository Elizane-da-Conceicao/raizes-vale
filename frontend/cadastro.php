<?php
include 'includes/config.php';
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

                        <label id="labelReligiao" for="religiao" class="form-label">Religião</label>
                        <select id="religiao" name="religiao">
                            <option value="Catolico">Católico</option>
                            <option value="Luterano">Luterano</option>
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

document.addEventListener('DOMContentLoaded', function() {
    function aplicarMascaraData(event) {
        var input = event.target;
        var value = input.value.replace(/\D/g, '');
        var formattedValue = '';

        if (value.length > 0) {
            formattedValue = value.substring(0, 4);
        }
        if (value.length > 4) {
            formattedValue += '/' + value.substring(4, 6);
        }
        if (value.length > 6) {
            formattedValue += '/' + value.substring(6, 8);
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
      const privado = document.getElementById('privado').value;

      if (tipoArquivo && descricao && arquivoInput.files.length > 0) {
          const file = arquivoInput.files[0];
          const reader = new FileReader();

          reader.onload = function(e) {
              const documento = {
                  type: tipoArquivo,
                  description: descricao,
                  file: e.target.result,
                  privado: privado,
              };

              saveDocumento(documento);
              alert('Documento salvo com sucesso!');
          };

          reader.readAsDataURL(file); 
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
        const usuarioLocal = ObterUsuario();

        var dataFamilia = {
            "Nome": data.sobrenome,
            "Data_criacao": new Date(),
            "Resumo": "Resumo da família",
            "Colonizador": "2",
            "usuario_id": usuarioLocal.idUsuario
        };

        var dataPessoa = {
            "nome": data.nome,
            "sexo": data.sexo.charAt(0),
            "data_nascimento": transformarData(data.datanascimento),
            "data_obito": transformarData(data.datafalecimento),
            "local_nascimento": data.localnascimento,
            "local_sepultamento": data.localsepultamento,
            "resumo": data.historiavida,
            "colonizador": '2',
            "religiao": data.religiao,
            "usuario_id": usuarioLocal.idUsuario
        };


        try {
            const responseFamilia = await fetch('<?php echo $baseAPI; ?>familias', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dataFamilia),
            });

            if (responseFamilia.ok) {
                const resultFamilia = await responseFamilia.json();


                const responsePessoa = await fetch('<?php echo $baseAPI; ?>pessoas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataPessoa),
                });
                if (responsePessoa.ok) {
                    const resultPessoa = await responsePessoa.json();

                    var dataFamiliaColonizadora = {
                        "Colonizador_id": resultPessoa.model.pessoa_id,
                        "Familia_id": resultFamilia.model.familia_id,
                        "Data_chegada": "1998-03-02",
                        "Comentarios": data.historiavida,
                        "usuario_id": usuarioLocal.idUsuario
                    };
                    const responseFamiliaColonizadora = await fetch('<?php echo $baseAPI; ?>familias-colonizadoras', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(dataFamiliaColonizadora),
                    });
                    if (responseFamiliaColonizadora.ok) {
                        const todosDocumentos = getDocumentos();
    
                        for (const documento of todosDocumentos) {
                            const { type, description, file, privado } = documento;
    
                            const arquivoData = {
                                pessoa_id: resultPessoa.model.pessoa_id,
                                Descricao: description,
                                Tipo_arquivo: type,
                                arquivo: file,
                                privado: privado == "true" ? 1 : 0,
                                usuario_id: usuarioLocal.idUsuario
                            };
                            console.log(arquivoData);
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