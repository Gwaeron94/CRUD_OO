<?php
    // Create Read Update Delete - CRUD
    class Contato {

        // Cria a variável $pdo como privada para ser usada apenas dentro da class
        private $pdo;

        // Cria o construtor da class para automaticamente se conectar ao bando de dados,
        public function __construct() {
            $this->pdo = new PDO("mysql:dbname=crudoo;host=localhost", "root", "");
        }

        // Criando o método CREATE.
        public function adicionar($email, $nome = '') {
            // 1º Passo: Verificar se o email já existe no banco de dados;
            // 2º Passo: Se não, adicionar.

            if($this->existeEmail($email) == false) { // Usando um método auxiliar para verificar se o email já existe.
                $sql = "INSERT INTO contatos (nome, email) VALUES (:nome, :email)";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':email', $email);
                $sql->execute();

                return true;
            } else {
                return false;
            }
        }

        // Criando o método READ.
        // Criando o método para ler um usuário específico.
        public function getInfo($id) {
            $sql = "SELECT * FROM contatos WHERE id = :id";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();

            if($sql->rowCount() > 0) {
                return $sql->fetch();
            } else {
                return array();
            }
        }

        // Criando o método para ler todos os usuários.
        public function getAll() {
            $sql = "SELECT * FROM contatos";
            $sql = $this->pdo->query($sql);

            if($sql->rowCount() > 0) {
                return $sql->fetchAll();
            } else {
                return array();
            }
        }

        // Criando o método UPDATE.
        public function editar($nome, $email, $id) {
            if($this->existeEmailComIdDiferente($email, $id) == false) {
                $sql = "UPDATE contatos SET nome = :nome, email = :email WHERE id = :id";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':id', $id);
                $sql->bindValue(':email', $email);
                $sql->execute();

                return true;
            } else {
                return false;
            }
        }

        //Criando o método DELETE.
        public function excluirPeloId($id) {
            $sql = "DELETE FROM contatos WHERE id = :id";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
        }

        public function excluirPeloEmail($email) {
            $sql = "DELETE FROM contatos WHERE email = :email";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':email', $email);
            $sql->execute();
        }

        // Criando o método auxiliar que verifica a existência do usuário no banco de dados.
        private function existeEmail($email) {
            $sql = "SELECT * FROM contatos WHERE email = :email";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':email', $email);
            $sql->execute();

            if($sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        private function existeEmailComIdDiferente($email, $id) {
            $sql = "SELECT * FROM contatos WHERE email = :email";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':email', $email);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $info = $sql->fetch();
                if($info['id'] != $id) {
                    return true;
                } else {
                    return false;
                }
            }
        }

    }
?>