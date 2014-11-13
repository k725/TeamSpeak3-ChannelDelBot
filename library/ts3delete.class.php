<?php
	class ts3delete
	{
		private $channel;
		private $channelId;
		private $ignore;
		private $pdo;
		private $dbTable;

		public function __construct($dbHost, $dbName, $dbChar, $dbUser, $dbPass, $dbTable)
		{
			$this->pdo     = new PDOWrapper($dbHost, $dbName, $dbChar, $dbUser, $dbPass);
			$this->dbTable = $dbTable;
		}

		public function setIgnoreList($array)
		{
			$this->ignore = $array;
		}

		public function setChannelId($id)
		{
			$this->channelId = $id;
		}

		public function setChannelName($name)
		{
			$this->channel = $name;
		}

		public function isChannelSpacer()
		{
			$match = preg_match('/\[[^\]]*spacer[^\]]*\]/', $this->channel);
			return $match ? true : false;
		}

		public function isChannelIgnore()
		{
			return in_array($this->channelId, $this->ignore);
		}

		public function getDbFoundChannel()
		{
			$sql    = 'SELECT * FROM `'.$this->dbTable.'` WHERE channelID = :id';
			$result = $this->pdo->getTopData($sql, array(
				':id' => array($this->channelId, PDO::PARAM_INT)
			));

			$this->pdo->closeStmt();

			return $result === false ? false : true;
		}

		public function getDbAllData()
		{
			$sql    = 'SELECT * FROM `'.$this->dbTable.'`';
			$result = $this->pdo->getData($sql);

			$this->pdo->closeStmt();

			return $row;
		}

		public function setDbAddChannel()
		{
			$sql = 'INSERT INTO `'.$this->dbTable.'` (channelID, channelName, lastTime) VALUES (:id, :name, :time)';

			$this->pdo->runSql($sql, array(
				':id'   => array($this->channelId, PDO::PARAM_INT),
				':name' => array($this->channel,    PDO::PARAM_STR),
				':time' => array(time(),            PDO::PARAM_INT)
			));

			$this->pdo->closeStmt();
		}

		public function setDbDeleteChannel()
		{
			$sql = 'DELETE FROM `'.$this->db_table.'` WHERE channelID = :id';

			$this->pdo->runSql($sql, array(
				':id' => array($this->channelId, PDO::PARAM_INT)
			));

			$this->pdo->closeStmt();
		}
	}