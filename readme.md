<h1 align="center">Projeto de TCC</h1>
![Logo SEFAPS](https://file+.vscode-resource.vscode-cdn.net/c%3A/Users/Lucas/OneDrive%20-%20Etec%20Centro%20Paula%20Souza/Documents/TCC/imagens/sefaps.png?version%3D1755132855608)
Curso Técnico em informática dos alunos da Turma 2 do 3° Info
SEFAPS: Sistema Eletrônico de Fichas de Atendimento para Pronto Socorros

Objetivos:
Login seguro de funcionários(Rececpcionistas, enfermeiros[talvez médicos])
Cada um com suas funções e permissões de alterações do banco de dados

    Recepcionista:
    Cadastrar pacientes por meio de formulário;
    alterar cadastros de pacientes;
    Excluir cadastros de Pacientes;
    Adicionar pacientes(por meio de consulta no BD) na lista de espera para a triagem e colocar a sua classificação de risco segundo o seu atendimento; 
        Assim criando um novo atendimento no banco de dados(Enfermeiro na triagem verá ele em sua lista)

    Enfermeiro:
    Atender pacientes que estão na lista de espera para a triagem por meio de um formulário;
    Ao atender, muda o status do "atendimento", assim saindo da lista de espera;
    Todos os atendimentos já concluidos será armazenado no banco de dados.

    Esses sistema é uma variação de um sistema CRUD, em resumo

    OBS: Se esse sistema der certo, tentarei fazer uma outra conexão com o médico que vai atender os pacientes, enviando os resultados da consulta na triagem.
