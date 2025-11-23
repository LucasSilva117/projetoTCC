
    CREATE DATABASE BDsefaps;
    use BDsefaps;

    create TABLE pacientes(
    codP INT AUTO_INCREMENT PRIMARY KEY,
    CPFP varchar(11) NOT NULL UNIQUE,
    RGP varchar(15) NULL,
    CNSP varchar(15) NULL,
    nomeP varchar(100),
    datanascP date,
    idadeP int, 
    telefoneP BIGINT, 
    sexoP varchar(10),
    enderecoP varchar(100),
    munResP varchar(100),
    UFP varchar(2)
    );  
    
    create TABLE recepcionistas(
    CPFR varchar(11) primary key,
    nomeR varchar(100),
    datanascR date,
    idadeR int, 
    telefoneR BIGINT, 
    sexoR varchar(10),
    senha varchar(255)
    ); 
    
    create TABLE enfermeiros(
    CPFE varchar(11) primary key,
    nomeE varchar(100),
    datanascE date,
    idadeE int, 
    telefoneE BIGINT, 
    sexoE varchar(10), 
    corenE varchar(10),
    senha varchar(255)
    );
    create TABLE atendimentos(
    codAten int AUTO_INCREMENT PRIMARY KEY,
    CPFRf varchar(11) NOT NULL,
    CPFEf varchar(11) NULL,
    CPFMf varchar(11) NULL,
    CPFPf varchar(11) NOT NULL,
    dataA date,
    horaA time, 
    ordem varchar(100),
    situacao varchar(20), /* "Esperando, Na triagem, Esperando consulta, Na consulta e Finalizado" */
    FOREIGN KEY (CPFRf) REFERENCES recepcionistas(CPFR), /*CPFEf não é foreign key por enquanto*/
    FOREIGN KEY (CPFPf) REFERENCES pacientes(CPFP)    
    ); 
    

    
    create table triagens(
    codAtenT int AUTO_INCREMENT primary key,  
    CPFEf varchar(11),
    CPFMf varchar(11) NULL,
    codAtenf int,
    temDiarreia varchar(3),
    tempoSintomas date,
    temAlergia varchar(3),
    alergiaAque varchar(250),
    tosseMais3sem varchar(3),
    colheuBK varchar(3),
    pressaoArterial varchar(7),
    pulso varchar(3),
    frequenciaResp varchar(3),
    temperatura varchar(4),
    glicemia varchar(3),
    SPO varchar(3),
    clascRisco varchar(8), /* "vermelho", "amarelo", "verde", "azul" */
    peso float, 
    horaT time,
    observacao varchar(255), 
    FOREIGN KEY (CPFEf) REFERENCES enfermeiros(CPFE),
    FOREIGN KEY ( codAtenf) REFERENCES atendimentos(codAten)    
    );    

    create table medicos(
    CPFM varchar(11) primary key,
    nomeM varchar(100),
    datanascM date,
    idadeM int, 
    telefoneM BIGINT, 
    sexoM varchar(10), 
    CRM varchar(9),
    especialidade varchar(255),
    senha varchar(255)
    );

    create table consultas(
    codCons int AUTO_INCREMENT PRIMARY KEY,  
    CPFMf varchar(11),
    codAtenTf int,
    codAtenf int,
    horaC time, 
    exameClinico varchar(255),
    conduta varchar(255),
    FOREIGN KEY (CPFMf) REFERENCES medicos(CPFM),
    FOREIGN KEY ( codAtenTf) REFERENCES triagens(codAtenT),
    FOREIGN KEY ( codAtenf) REFERENCES atendimentos(codAten)
    );

    create table administradores(
    CPFA varchar(11) primary key,
    nomeA varchar(100),
    senha varchar(255)
    );