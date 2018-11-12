<?php

class IndexController{

	private $db = false;

	public function __construct(){

		$this->db = Db::getInstance();

	}

	public function index(){
		$sql = 'select * from users where usersid = 0';
		$data = $this->db->query($sql);
		include CUR_VIEW.'index.html';
	}

	public function insert(){

		$name = isset($_GET['name']) ? $_GET['name'] : '';
		$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

		
		if($name){

			$result = $this->db->excu('insert into users(name,usersid,createtime)values(?,?,?)',[$name,$uid,time()]);
			$newId = $this->db->newId();
			echo $newId;
		}	

	}

	public function disList(){

		$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;
		if($uid){
			$result = $this->db->query('select * from users where usersid = ?',[$uid]);
			$data = json_encode($result);
			echo $data;
		}	
	}

	public function insertContent(){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$content = isset($_GET['content']) ? $_GET['content'] : 0;
		if($id){
			$result = $this->db->excu('update users set content = ? where id = ? ',[$content,$id]);
			echo $result;
		}

	}

	public function disContent(){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$result = $this->db->query('select content from users where id = ?',[$id]);
		if($result){
			echo $content = $result[0]['content'];	
		}
	}

	public function delete($id = ''){

		$id = !empty($id) ? $id : $_GET['id'];
		
		$status = $this->db->excu('delete from users where id = ?',[$id]);
		if($status){

			$result = $this->db->query('select id from users where usersid = ?',[$id]);
			foreach ($result as $key => $value) {
				$this->delete($value['id']);
			}
		}

		echo $status;

	}


	public function update(){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$name = isset($_GET['name']) ? $_GET['name'] : 0;

		if($id && $name){
			$result = $this->db->excu('update users set name = ? where id = ? ',[$name,$id]);
			echo $result;
		}

	}

	public function getTools($name = 'qq'){

		exec(ROOT."tools/{$name}.exe");

	}


}