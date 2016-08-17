<?php
include('password.php');
class User extends Password{
	const SECRET_KEY = '%qpj34dhg%';

		private $_db;

		function __construct($db){
			parent::__construct();
			$this->_db = $db;
		}

	private function get_user_hash($username){

		try {
			$stmt = $this->_db->prepare('SELECT password FROM users WHERE username = :username AND active="Yes"');
			$stmt->execute(array('username' => $username));

			$row = $stmt->fetch();
			return $row['password'];

		} catch(PDOException $e) {
				echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function login($username, $password, $rememberme){

		$hashed = $this->get_user_hash($username);

		if($this->password_verify($password,$hashed) == 1){
			echo 'test';
				if($rememberme){
					$this->set_remember_me($username);
				}else{
					if (isset($_COOKIE['checkIT'])) {
						// empty value and old timestamp
						unset($_COOKIE['checkIT']);
						setcookie('checkIT', '', time() - 3600);
					}
				}
				$_SESSION['loggedin'] = true;
				return true;
		}
	}

	public function get_user_json($search_param, $username){
		$query = "SELECT username as 'name' FROM users WHERE username LIKE :test AND username != :user_name;";
		$stmt = $this->_db->prepare($query);
 		$stmt->execute(array('test' => "$search_param%",
 							 'user_name' => "$username"));
//		$stmt->execute(array('test'=> "$search_param"));
		$json_data=array();//create the array
		while($row = $stmt->fetch()) {
					$json_array['name']=$row['name'];
					$json_array['id']=$row['id'];
					array_push($json_data,$json_array);
		}

		return json_encode($json_data);
//			return $rows;
	}

	private function set_remember_me($username){
			// random number to serve as our key:
			$randomNumber = rand( 99, 999999	);

			// convert number to hexadecimal form:
			$token = dechex( ( $randomNumber * $randomNumber ) );
			$cookie = $username.':'.$token;

			// encrypt our token using SHA1 and the randomNumber as salt
			//$key = encrypt( $token, $randomNumber, SHA1 );
			$key = hash_hmac('sha256', $cookie, $randomNumber);
			$cookie = $key.':'.$cookie;
			//$user_key = hash_hmac('sha256', $username, SECRET_KEY);
			// get the number of seconds since unix epoch:
			// (this will be 10 digits long until approx 2030)
			$now = new DateTime();
			$timeNow = $now->getTimestamp();

			// check to see if user is in table already:
// 			$sql = "SELECT user_id FROM rememberme WHERE user_id = '$username'";

// 			// connect to database:
// 			//$db = new DBCon();

// 			$result = $db->query( $sql );
			try{
				$result = $this->_db->prepare("SELECT user_id FROM rememberme WHERE user_id = '$username'");
				$result->execute();
				$row = $result->fetch(PDO::FETCH_ASSOC);

				if(!empty($row['user_id']))
					$exists = true;
				else
					$exists = false;
			} catch(PDOException $e) {
				echo '<p class="bg-danger">'.$e->getMessage().'</p>';
			}
// 			$row = $result->fetch();
// 			return $row['password'];


			// number of rows will always be 1 if user is in table:
// 			if ( $result->rows != 1 )
// 				$exists = true;
// 			else
// 				$exists = false;

			//$result->free_memory();

			if ( $exists == true ) {
				$sql = "UPDATE rememberme SET
												user_id		= '$username',
												user_token = '$token',
												token_salt = '$randomNumber',
												time			 = '$timeNow'";
			}else{
				$sql = "INSERT INTO rememberme VALUES( '$username', '$token', '$randomNumber', '$timeNow' )";
			}
// 			$result = $db->query( $sql );
			try{
				$result = $this->_db->prepare($sql);
				$result->execute();
				echo 'set remember me';
			} catch(PDOException $e) {
				echo '<p class="bg-danger">'.$e->getMessage().'</p>';
			}
			// the affected rows will always be 1 on success
// 			if ( $result->affected_rows != 1 )
// 			{
// 				print( "A problem occurred.\nPlease log in again." );
// 				quit();
// 			}

			//$result->free_memory();

			// create a new cookie named cookiemonster and store the key in it:
			// (we're not actually storing a score or birthday, its a false flag)
			setcookie( "SILLY", $cookie, time() + 1209600 );
			setcookie( "checkIT", true, time() + 1209600 );
	}

	public function get_remember_me(){
		$cookie = isset($_COOKIE['SILLY']) ? $_COOKIE['SILLY'] : '';
			if ($cookie) {
					list ($mac, $username, $token) = explode(':', $cookie);
					//echo $mac.' / '.$username.' / '.$token;
					try{
						$result = $this->_db->prepare("SELECT token_salt FROM rememberme WHERE user_id = '$username' AND user_token = '$token'");
						$result->execute();
						$row = $result->fetch(PDO::FETCH_ASSOC);
						//var_dump($result);
						if(!empty($row['token_salt'])){
							$salt = $row['token_salt'];
						}else{
							return false;
						}
					} catch(PDOException $e) {
						echo '<p class="bg-danger">'.$e->getMessage().'</p>';
					}
			echo 'end2';
					if ($mac !== hash_hmac('sha256', $username . ':' . $token, $salt)) {
							return false;
					}else{
						$_SESSION['username'] = $username;
						$_SESSION['loggedin'] = true;
						return true;
					}
			}
	}

	public function logout(){
		session_destroy();
		if (isset($_COOKIE['SILLY'])) {
				unset($_COOKIE['SILLY']);
				setcookie('SILLY', '', time() - 3600); // empty value and old timestamp
		}
	}

	public function is_logged_in(){
		//check if the rememberme cookie is present
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}else{
			return $this->get_remember_me();
		}
	}

	public function checkUserExistence($userid){
		try{
			$query = "SELECT EXISTS(SELECT 1 FROM users WHERE username = :userid LIMIT 1)	as userExists;";
			$stmt = $this->_db->prepare($query);
	 		$stmt->execute(array('userid' => $userid));
			$row = $stmt->fetch();
		} catch(PDOException $e) {
			echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
		return $row['userExists']==1?true:false;
	}

	public function findIdbyName($user_name){
		//echo "test";
		try{
			//echo $user_name;
			$query = "SELECT id FROM users WHERE username=:user_name";
			$stmt = $this->_db->prepare($query);
	 		$stmt->execute(array(':user_name' => $user_name));
			$row = $stmt->fetch();
			if(!empty($row['id'])){
				$exists = true;
				$userid = $row['id'];
				//echo "userfound";
				return $userid;
			}else{
				$exists = false;
				echo "NO userfound";
				return false;
			}

		} catch(PDOException $e) {
			echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
		return false;
	}

	public function findNamebyId($user_id){
		//echo "test";
		try{
			//echo $user_id;
			$query = "SELECT username FROM users WHERE id=:user_id;";
			$stmt = $this->_db->prepare($query);
			$stmt->execute(array(':user_id' => $user_id));
			$row = $stmt->fetch();
			if(!empty($row['username'])){
				$exists = true;
				$user_name = $row['username'];
				//echo "userfound";
				return $user_name;
			}else{
				$exists = false;
				echo "NO userfound";
				return false;
			}

		} catch(PDOException $e) {
			echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
		return false;
	}

	public function getMyFriends($userid){
		$query = "SELECT * FROM friends
					WHERE accepted = 1 AND (user1 = :user_id OR user2 = :user_id)";
		try {
			$db = ($this->_db);
			$stmt = $db->prepare($query);
			$stmt->execute(array(':user_id' => $userid));
			$friends = [];
			while($row = $stmt->fetch()){
				$friend_id = $row['user1'] != $userid ? $row['user1'] : $row['user2'];
				$friend_name = $this->findNamebyId($friend_id);
				$myfriend = array('id' => $row['id'], 'name' => $friend_name);
				array_push($friends, $myfriend);
			}
		} catch(PDOException $e) {
			echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
		return $friends;
	}
}

?>
