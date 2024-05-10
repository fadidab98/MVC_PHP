<?php

namespace app\core;




class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn']??'';
        $user = $config['user']??'';
        $password = $config['password']??'';
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $newApplyMigrations = [];
        $this->createMigrationsTable();
       $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR.'/migrations');
        $toApplyMigrations =array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration)
        {
            if($migration === '.' || $migration === '..')
            {
                continue;
            }
            require_once Application::$ROOT_DIR.'/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            echo  "Applying migration ".$migration.PHP_EOL;
             $instance->up();
            echo  "Applied migration ".$migration.PHP_EOL;
            $newApplyMigrations[] = $migration;
        }

        if(!empty($newApplyMigrations))
        {

            $this->saveMigrations($newApplyMigrations);
        }else{
            echo  "All migrations applied";
    }
    }
    public function createMigrationsTable()
    {
        $this ->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE = InnoDB;");

    }
    public function getAppliedMigrations()
    {
       $statment =  $this->pdo->prepare("SELECT * FROM migrations;");
       $statment->execute();

       return $statment->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function saveMigrations(array $newApplyMigrations)
    {
        echo  "line 68";
        var_dump($newApplyMigrations);
        $str =implode(",",array_map(fn($m) => "('$m')", $newApplyMigrations));

        $statment= $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
            $str
            ");
        $statment->execute();
    }

}