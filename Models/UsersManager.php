<?php
    namespace Models;
    use App\AbstractManager;

    class UsersManager extends AbstractManager
    {
        private static $classname = "Models\User";

        public function __construct(){
            self::connect(self::$classname);
        }

        public function getOneByMail($mail){//We ftech the user from the given mail

            $sql = "SELECT *".
            " FROM users".
            " WHERE LOWER(mail) = :mail";
            $arg= ["mail" => $mail];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }

        public function getOneById($id){//We ftech the user from the given id

            $sql = "SELECT *".
            " FROM users".
            " WHERE id = :id";
            $arg= ["id" => $id];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }

        public function findAll(){ //We fetch all the users in the DB (admin panel)
            $sql = "SELECT * FROM users ORDER BY username";

            return self::getResults(
                self::select($sql, null, true),
                self::$classname
            );
        }

        public function getBoards($id){ //We fetch the user created boards

            $sql = "SELECT b.id,b.label FROM boards b".
                    " INNER JOIN users_boards ub ON ub.board_id = b.id".
                    " INNER JOIN users u ON u.id = ub.user_id".
                    " WHERE u.id = :id".
                    " AND b.user_id = u.id;";
            $arg= ["id" => $id];   
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\Board"
            );
        }

        public function getInvitedBoards($id){//We fetch the boards where the user have been invited

            $sql = "SELECT b.id,b.label FROM boards b".
                    " INNER JOIN users_boards ub ON ub.board_id = b.id".
                    " INNER JOIN users u ON u.id = ub.user_id".
                    " WHERE u.id = :id".
                    " AND b.user_id != u.id;";
            $arg= ["id" => $id];   
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\Board"
            );
        }

        public function newUser($username,$password,$mail) //We add a new user to the DB and we affect him the User role
        {
            $sql = "INSERT INTO users(username,password,mail,role,dateCreation)".
                    "VALUES (:pseudo,:pass,:mail,:role,:date)";
            
            $role = json_encode(['user']);
            $arg= ["pseudo" => $username,
                    "pass" => $password,
                    "mail" => $mail,
                    "date" => date("Y-m-d"),
                    "role" => $role];

            return self::insert($sql,$arg);
        }

        public function deleteUser($id){ //We delete the user, and severe the link between him and the boards
            $sqls = [];
            array_push($sqls,   "UPDATE boards SET user_id = NULL WHERE user_id = :id;",
                                "DELETE FROM users_boards WHERE user_id = :id;",
                                "DELETE FROM users WHERE id = :id;");

            $arg=  ["id" => $id];
            return self::transaction($sqls,$arg);
        }

        public function updateUsername($id,$text){ //We update the user username
            
            $sql = "UPDATE users".
            " SET username = :text".
            " WHERE id = :id";
            
            $arg= ["text" => $text,
                    "id" => $id,
                ];
                
            return self::update($sql,$arg);
        }

        public function updatePassword($id,$nPass){ // we update the user passowrd
            
            $sql = "UPDATE users".
            " SET password = :password".
            " WHERE id = :id";
            
            $arg= ["password" =>$nPass,
                    "id" => $id,
                ];
            return self::update($sql,$arg);
        }

        public function updateColor($id,$color){// we update the user color
            
            $sql = "UPDATE users".
            " SET color = :color".
            " WHERE id = :id";
            
            $arg= ["color" =>$color,
                    "id" => $id,
                ];
            return self::update($sql,$arg);
        }

        public function updateRole($id,$role){ // we update the user role list
            
            $sql = "UPDATE users".
            " SET role = :role".
            " WHERE id = :id";
            
            $arg= ["role" =>$role,
                    "id" => $id,
                ];
            return self::update($sql,$arg);
        }

        public function updateEmail($id,$mail){// we update the user email
            
            $sql = "UPDATE users".
            " SET mail = :mail".
            " WHERE id = :id";
            
            $arg= ["mail" => $mail,
                    "id" => $id,
                ];
                
            return self::update($sql,$arg);
        }
    }

?>