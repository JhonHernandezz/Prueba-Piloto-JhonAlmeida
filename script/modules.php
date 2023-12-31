<?php
namespace App;
    class modules extends connect{
        use getInstance;
        private $message;
        private $queryPostModules = 'INSERT INTO modules (name_module, start_date, end_date, description, duration_days, id_theme) VALUES (:name_module, :start_date, :end_date, :description, :duration_days, :id_theme)';
        private $queryGetAllModules = 'SELECT modules.id, themes.id AS Code, modules.name_module, modules.start_date, modules.end_date, modules.description, modules.duration_days, themes.name_theme FROM modules INNER JOIN themes ON modules.id_theme = themes.id';
        private $queryGetModules = 'SELECT modules.id, themes.id AS Code, modules.name_module, modules.start_date, modules.end_date, modules.description, modules.duration_days, themes.name_theme FROM modules INNER JOIN themes ON modules.id_theme = themes.id WHERE modules.id = :id_modules';
        private $queryUpdateModules = 'UPDATE modules SET name_module = :name_module, start_date = :start_date, end_date = :end_date, description = :description, duration_days = :duration_days, id_theme = :id_theme WHERE id = :id_modules';
        private $queryDeleteModules = 'DELETE FROM modules WHERE id = :id_modules';

        public function __construct(){parent::__construct();}

        public function postModules($name_module, $start_date, $end_date, $description, $duration_days, $id_theme){
            try {
                $res = $this->connec->prepare($this->queryPostModules);
                $res->bindValue("name_module", $name_module);
                $res->bindValue("start_date", $start_date);
                $res->bindValue("end_date", $end_date);
                $res->bindValue("description", $description);
                $res->bindValue("duration_days", $duration_days);
                $res->bindValue("id_theme", $id_theme);
                $res->execute();
                $this->message = [ "STATUS" => 200, "MESSAGE" => "Agregado Exitosamente"];

            } catch (\PDOException $error) {
            $this->message = $error->getMessage();

            } finally {
                echo json_encode($this->message, JSON_PRETTY_PRINT);
            }
        }

        public function getAllModules(){
            try {
                $res = $this->connec->prepare($this->queryGetAllModules);
                $res->execute();
                $this->message = ["STATUS" => 200, "MESSAGE" =>$res->fetchAll(\PDO::FETCH_ASSOC)];

            } catch (\PDOException $error) {
                $this->message = $error->getMessage();

            } finally {
                echo json_encode($this->message, JSON_PRETTY_PRINT);
            }
        }

        public function getModules($id_modules){
            try {
                $res = $this->connec->prepare($this->queryGetModules);
                $res->bindValue("id_modules", $id_modules);
                $res->execute();
                $this->message = ["STATUS" => 200, "MESSAGE" =>$res->fetchAll(\PDO::FETCH_ASSOC)];

            } catch (\PDOException $error) {
                $this->message = $error->getMessage();

            } finally {
                echo json_encode($this->message, JSON_PRETTY_PRINT);
            }
        }

        public function updateModules($data, $id_modules){
            $name_module = $data["name_module"];
            $start_date = $data["start_date"];
            $end_date = $data["end_date"];
            $description = $data["description"];
            $duration_days = $data["duration_days"];
            $id_theme = $data["id_theme"];
            try {
                $res = $this->connec->prepare($this->queryUpdateModules);
                $res->bindValue("name_module", $name_module);
                $res->bindValue("start_date", $start_date);
                $res->bindValue("end_date", $end_date);
                $res->bindValue("description", $description);
                $res->bindValue("duration_days", $duration_days);
                $res->bindValue("id_theme", $id_theme);
                $res->bindValue("id_modules", $id_modules);
                $res->execute();
                $this->message = ["STATUS" => 200, "MESSAGE" => "Actualizado Exitosamente"];

            } catch (\PDOException $error) {
                $this->message = $error->getMessage();

            } finally{
                echo json_encode($this->message, JSON_PRETTY_PRINT);
            }
        }

        public function deleteModules($id_modules){
            try {
                $res = $this->connec->prepare($this->queryDeleteModules);
                $res->bindValue("id_modules", $id_modules);
                $res->execute();
                $this->message = ["STATUS" => 200, "MESSAGE" => "Eliminado Exitosamente"];

            } catch (\PDOException $error) {
                $this->message = $error->getMessage();

            } finally{
                echo json_encode($this->message, JSON_PRETTY_PRINT);
            }
        }
    }
?>