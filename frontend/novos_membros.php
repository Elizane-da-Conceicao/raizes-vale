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
                <option value="Feminino">Cônjuge</option>
                <option value="Masculino">Filho</option>
            </select>
        </div>
        <hr>
        <form>
            <div id="lados">
                <div id="input-escrever">
                    <div>
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" placeholder="Nome" class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">Sobrenomes</label>
                        <input type="text" placeholder="Sobrenomes" class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">Data de Nascimento</label>
                        <input type="text" placeholder="dd/mm/aaaa"class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">Local de Nascimento</label>
                        <input type="text" placeholder="Local de Nascimento"class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">Data de Falecimento</label>
                        <input type="text" placeholder="dd/mm/aaaa"class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">Local de Falecimento</label>
                        <input type="text" placeholder="Local de Falecimento"class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">História de vida</label>
                        <textarea id="area-texto" placeholder="Insira um resumo"></textarea>
                    </div>
                </div>
                <div id="lado-direito">
                    <div>
                        <label for="name" class="form-label">Sexo</label>
                        <select>
                        <option value="Feminino">Feminino</option>
                        <option value="Masculino">Masculino</option>
                        </select>
                    </div>
                    
                </div>
            </div>
            <hr>
            <p>Você deve inserir documentos que comprovem a existencia e a relação da pessoa introduzida:</p>
            <div id="documento-relacao">
                <label for="name" class="form-label">Documentos comprobatórios</label>
                <input type="button" value="Adicionar Documentos">
            </div>
            <div id="botoes-direita">
                    <div class="centraliza">
                    <input type="button" class="botoes" value="Limpar">
                    <input type="submit" class="botoes" value="Salvar">
                </div>
            </div>
        </form>
        </div>
    </div>