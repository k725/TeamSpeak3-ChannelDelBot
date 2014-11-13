<?php
	class settingsTS3
	{
		/*
			HostName        (string) : Target host name or IP address.
			UserName        (string) : Query login username.
			PassWord        (string) : Query login password.
			QueryPort       (int)    : Query port. (default 10011)
			VoicePort       (int)    : Voice chat port. (default 9987)
			BotName         (string) : Bot query user name.
			WarnTime        (int)    : Number of seconds for which you want to add warning list the channel.
			DeleteTime      (int)    : Number of seconds for which you want to delete the channel.
			ignoreChannelId (int)    : Channel ID that does not delete. (channel spacer is no delete :).)
		*/
		const HostName     = 'localhost';
		const UserName     = 'serveradmin';
		const PassWord     = '****************';
		const QueryPort    = 10011;
		const VoicePort    = 9987;
		const BotName      = 'Lachesis';
		const WarnTime     = 432000; // 5Day
		const DeleteTime   = 2592000; // 30Day

		static function ignoreChannelId()
		{
			return array(1, 2);
		}
	}

	class settingsSQL
	{
		/*
			HostName (string) : MySQL database host name or IP address.
			UserName (string) : MySQL database login username.
			PassWord (string) : MySQL database login password.
			DataBase (string) : MySQL database name.
			Table    (string) : MySQL database table.
			Charset  (string) : MySQL charset.
		*/
		const HostName = 'localhost';
		const UserName = 'user';
		const PassWord = '***********';
		const DataBase = 'ts3';
		const Table    = 'list';
		const CharSet  = 'utf8mb4';
	}