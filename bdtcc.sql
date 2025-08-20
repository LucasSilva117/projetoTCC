    CREATE DATABASE bdtcc;
    use bdtcc;

    create TABLE pacientes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    RGSUSP varchar(15) NOT NULL UNIQUE,
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
    
    
    create TABLE atendimentos(
    codAten int AUTO_INCREMENT PRIMARY KEY,
    CPFRf varchar(11),
    RGSUSPf varchar(15),
    dataA date,
    hora time, 
    ordem varchar(100),
    FOREIGN KEY (CPFRf) REFERENCES recepcionistas(CPFR),
    FOREIGN KEY (RGSUSPf) REFERENCES pacientes(RGSUSP)    
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
    
    create table triagens(
    codAtenT int AUTO_INCREMENT primary key,  
    CPFEf varchar(11),
    codAtenf int,
    temAlergia varchar(3),
    alergiaAque varchar(250),
    temDiarréia varchar(3),
    tempoSintomas varchar(250),
    tosseMais5sem varchar(3),
    pressaoArterial varchar(100),
    pulso varchar(100),
    frequenciaResp varchar(100),
    temperatura varchar(100),
    glicemia varchar(100),
    SPO varchar(100),
    clascRisco varchar(100), 
    peso varchar(100), 
    observacao varchar(250), 
    FOREIGN KEY (CPFEf) REFERENCES enfermeiros(CPFE),
    FOREIGN KEY ( codAtenf) REFERENCES atendimentos(codAten)    
    );    