CREATE TABLE vagas(
id_vaga integer AUTO_INCREMENT PRIMARY KEY,
titulo varchar(20) NOT NULL,
descricao text NOT NULL,
ativo enum ('s','n'),
data TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp());

