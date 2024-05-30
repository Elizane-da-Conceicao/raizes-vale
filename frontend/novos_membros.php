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
        <div class="linha">
            <p>Você deseja inserir esta igação á qual pessoa?</p>
            <input type="text" placeholder="Insira o nome ou código" class="input-cadastro">
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
        <form id="pessoaForm">
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
                        <textarea id="historiavida" name="historiavida" placeholder="Insira um resumo"></textarea>
                    </div>
                </div>
                <div id="lado-direito">
                    <div>
                        <label for="sexo" class="form-label">Sexo</label>
                        <select id="sexo" name="sexo">
                            <option value="Feminino">Feminino</option>
                            <option value="Masculino">Masculino</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <p>Você deve inserir documentos que comprovem a existência e a relação da pessoa introduzida:</p>
            <div id="documento-relacao">
                <label for="documentos" class="form-label">Documentos comprobatórios</label>
                <input type="button" value="Adicionar Documentos">
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

    <script>
    document.getElementById('pessoaForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());
        const relacionamento = document.getElementById('relacao').value;
        data.relacao = relacionamento;
        
        console.log(data);
        var dataPessoa = {
            "nome": data.nome,
            "sexo": data.sexo.charAt(0),
            "data_nascimento": data.datanascimento,
            "data_obito": data.datafalecimento,
            "local_nascimento": data.localnascimento,
            "local_sepultamento": data.localsepultamento,
            "resumo": data.historiavida,
            "colonizador": '1',
            "usuario_id": 1
        };
        
        try {
            const responsePessoa = await fetch('http://127.0.0.1:8000/api/pessoas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dataPessoa),
            });
            console.log(responsePessoa);
            if (responsePessoa.ok) {
                const result = await responsePessoa.json();
                if(relacionamento == "Conjuge")
                {   
                    if(data.sexo.charAt(0) == "M")
                    {
                        var marido = result.model.pessoa_id;
                        var esposa = 9;
                    }else{
                        var esposa = result.model.pessoa_id;
                        var marido = 9;
                    }
                    
                    var dataPessoa = {
                        "Marido_id": marido,
                        "Esposa_id": esposa,
                        "Data_casamento": "2024-01-01",
                        "usuario_id": 1
                    };

                    const responseCasal = await fetch('http://127.0.0.1:8000/api/casais', {
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
                        "usuario_id": 1,
                        "Pessoa_id": 9
                    };

                    const responseFilho = await fetch('http://127.0.0.1:8000/api/descendencias', {
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
</script>

