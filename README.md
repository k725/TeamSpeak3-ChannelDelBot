TeamSpeak3-ChannelDelBot
========================

TeamSpeak3 Channel Delete Bot. VeryEasy and VeryFast.


----------

Lachesis
------------

チャンネルの削除を素早く、正確に。
このスクリプトは、TeamSpeak3向けのチャンネル監視Botです。
cronに登録し、設定ファイルを少し書き換えるだけ。

**導入手順**

1. DBにテーブルを作成
2. 設定ファイルを編集
3. ファイルを転送
4. cronに登録
5. アクセス制限

----------


Step1
-----

MySQLを使用するのでデータベースを作成後下記コマンドを入力しテーブルを作成してください。
テーブル名は設定ファイルで変更可能です。

    CREATE TABLE IF NOT EXISTS `list` (`channelID` int(11) NOT NULL, `channelName` text NOT NULL, `lastTime` bigint(20) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ALTER TABLE `list` ADD UNIQUE KEY `channelID` (`channelID`);

Step2
-----

``ts3delete.settings.php`` を開き、編集後に保存してください。

Step3
-----

FileZillaやWinSCP等でサーバに転送します。

Step4
-----

cronに登録します。

    $ crontab -e

等でcronの設定を開きます。
OSにより、phpのパス等が異なるので注意してください。 ``/usr/bin/php`` や ``/usr/local/bin/php`` 等…

    */5 *   *   *   *   /usr/local/bin/php  /foo/var/ts3delete.cron.php 1> /dev/null

Step5
-----

Bot本体にhttp経由でアクセスされるとデータベースや、TeamSpeak3サーバに負荷がかかる原因になってしまいます。
なのでBot本体へのアクセスは拒否してしまいましょう。

    # Apache ~2.2
    <Files ~ "^ts3delete\.cron\.php$">
        Deny from all
    </Files>

    # Apache 2.4~
    <Files ~ "^ts3delete\.cron\.php$">
        Require all denied
    </Files>


----------

License
-------

GPL v3 License
Please see LICENSE file.