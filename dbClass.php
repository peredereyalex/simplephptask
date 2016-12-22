<?

Class dbClass
{
    private $connection;

    public function __construct($user, $password, $db)
    {
        $this->connection = $this->connect($user, $password, $db);
    }

    private function connect($user, $password, $db)
    {

        $mysqli = new mysqli('localhost', $user, $password, $db);
        if ($mysqli->connect_errno) {
            printf("Couldn't connect to DB: %s\n", $mysqli->connect_error);
            exit();
        }
        return $mysqli;
    }

    public function getUsersTeams()
    {
        return $query = mysqli_query($this->connection,
            "select users.id, 
            CONCAT(users.first_name,' ',users.last_name) as USER,
            GROUP_CONCAT(teams.name SEPARATOR ', ') as TEAM 
            from users 
            join teams_users on users.id = teams_users.user_id 
            join teams on teams.id=teams_users.team_id 
            group by users.id, users.first_name, users.last_name "
        );
    }

    public function close()
    {
        $this->connection->close();
    }

}