<?php
    class Conexao {
        private static $instancia;

        public static function getConexao() {
            if (!isset(self::$instancia)) {
                try {
                    self::$instancia = new PDO(
                        'mysql:host=localhost; dbname=Automatiza; charset=utf8',
                        'root',
                        '',
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erro
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Define o modo de busca padrão como array associativo
                        ]
                    );
                } catch (PDOException $e) {
                    die("Erro na conexão com o banco de dados: " . $e->getMessage());
                }
            }
            return self::$instancia;
        }
    }
