<?php
	require_once(dirname(__FILE__).'/library/ts3admin/src/ts3admin.class.php');
	require_once(dirname(__FILE__).'/library/PHP-PDO-Wrapper/PdoWrapper.class.php');
	require_once(dirname(__FILE__).'/library/ts3delete.class.php');
	require_once(dirname(__FILE__).'/ts3delete.settings.php');

	$ts3    = new ts3admin(settingsTS3::HostName, settingsTS3::QueryPort);
	$ts3del = new ts3delete(settingsSQL::HostName, settingsSQL::DataBase, settingsSQL::CharSet, settingsSQL::UserName, settingsSQL::PassWord, settingsSQL::Table);

	if ( $ts3->getElement('success', $ts3->connect()) )
	{
		$ts3->login(settingsTS3::UserName, settingsTS3::PassWord);
		$ts3->selectServer(settingsTS3::VoicePort);
		$ts3->setName(settingsTS3::BotName);
		$ts3del->setIgnoreList(settingsTS3::ignoreChannelId());

		// ChannelCrawl
		$channelList = $ts3->getElement('data', $ts3->channelList());

		if ( is_array($channelList) )
		{
			foreach ( $channelList as $key => $value )
			{
				$ts3del->setChannelName($value['channel_name']);
				$ts3del->setChannelId($value['cid']);

				if ( $value['total_clients'] > 0 )
				{
					if ( $ts3del->getDbFoundChannel() && !$ts3del->isChannelIgnore() )
					{
						$ts3del->setDbDeleteChannel();
					}
				}
				else
				{
					if ( !$ts3del->isChannelSpacer() && !$ts3del->getDbFoundChannel() && !$ts3del->isChannelIgnore() )
					{
						$ts3del->setDbAddChannel();
					}
				}
			}
		}

		// ChannelDelete
		$dbChannelList = $ts3del->getDbAllData();

		if ( is_array($dbChannelList) )
		{
			foreach ( $dbChannelList as $key => $value )
			{
				if ( (time() - $value['lastTime']) >= settingsTS3::DeleteTime && !$ts3del->isChannelIgnore() )
				{
					$ts3del->setChannelId($value['channnelID']);
					$ts3del->setDbDeleteChannel();
					$ts3->channelDelete($value['channelID'], 0);
				}
			}
		}
	}