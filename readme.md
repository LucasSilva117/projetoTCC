<h1 align="center">Projeto de TCC</h1>

Curso Técnico em informática dos alunos da Turma 2 do 3° Info
Sistema Eletrônico de Fichas de Atendimento para Pronto Socorros(SEFAPS)

Objetivos:
Login seguro de funcionários(Rececpcionistas, enfermeiros e médicos)
Cada um com suas funções e permissões de alterações do banco de dados:

<h3>Recepcionista:</h3>
Cadastrar pacientes por meio de formulário;
alterar cadastros de pacientes;
Excluir cadastros de Pacientes;
Adicionar pacientes(por meio de consulta no BD) na lista de espera para a triagem e colocar a sua classificação de risco segundo o seu atendimento; 
Assim criando um novo atendimento no banco de dados(Enfermeiro na triagem verá ele em sua lista)

<h3>Enfermeiro:</h3>
Atender pacientes que estão na lista de espera para a triagem por meio de um formulário;
Ao atender, muda o status do "atendimento", assim saindo da lista de espera e indo para a lista de espera do médico

<h3>Médico:</h3>
Atender os pacientes que passaram pela recepção e triagem.
Prencher um formulário com as seguintes informações: Horário do atendimento do médico, Exame Clínico e conduta inicial.
Com os dados, será feito uma impressão do formulário completo e assim dando continuidade ao procedimento;
Todos os atendimentos já concluidos seram armazenado no banco de dados

<h3>Administrador:</h3>
Gerencia os cadastros de funcionários;
Tem acesso à estatíticas da unidade(Sobre pacientes, atendimentos e funcionários)

<h3>Mudanças previstas:</h3>
Fazer a funcionalidade do médico e fazer dar certo a impressão
Em pacientes, colocar o CPF como chave primária e RG e SUS como campos opicionais ✅
Ao modificar os dados, colocar uma notificação com os dados modificados ✅
Criptografia hash em todas as senhas ✅
Não poder mudar a hora do atendimento no formulário ✅
No status do atendimento mostrar quem está atendendo✅