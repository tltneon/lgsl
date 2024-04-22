![GitHub tag (with filter)](https://img.shields.io/github/v/tag/tltneon/lgsl?filter=v7*&style=for-the-badge&color=green)
![PHP](https://img.shields.io/badge/PHP-7.1+-brightgreen?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-5.5+-brightgreen?style=for-the-badge&logo=mysql)
![MariaDB](https://img.shields.io/badge/MariaDB-5.5+-brightgreen?style=for-the-badge&logo=mariadb)
![SQLite](https://img.shields.io/badge/SQLite-3-brightgreen?style=for-the-badge&logo=sqlite)
![Postgres](https://img.shields.io/badge/PostgreSQL-11+-brightgreen?style=for-the-badge&logo=postgresql)

[![GitHub contributors](https://img.shields.io/github/contributors/tltneon/lgsl?style=for-the-badge)](https://github.com/tltneon/lgsl/graphs/contributors)
[![GitHub stars](https://img.shields.io/github/stars/tltneon/lgsl?style=for-the-badge)](https://github.com/tltneon/lgsl/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/tltneon/lgsl?style=for-the-badge)](https://github.com/tltneon/lgsl/fork)
[![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/tltneon/lgsl?style=for-the-badge)](https://github.com/tltneon/lgsl/archive/master.zip)
[![Packagist](https://img.shields.io/packagist/l/tltneon/lgsl?style=for-the-badge)](https://github.com/tltneon/lgsl/blob/master/LICENSE)
# LGSL v7.0.0 (Live Game Server List)
LGSL is a standalone module for website that can query status and data from [210+ game servers](https://github.com/tltneon/lgsl/wiki/Supported-Games,-Query-protocols,-Default-ports). Or you can use it as a library in your projects.

***LGSL7 branch:*** Modern branch of LGSL that brings new abilities. That branch is experimental, **unstable** and may be **heavily** changed in future.

Feel free to make [pull request](https://github.com/tltneon/lgsl)! Also you can [suggest](https://github.com/tltneon/lgsl/issues) any ideas about new features such adding new game or code improvements.

## [Live DEMOs](https://github.com/tltneon/lgsl/wiki/Who-uses-LGSL) |  [Supported games](https://github.com/tltneon/lgsl/wiki/Supported-Games,-Query-protocols,-Default-ports) | [Features list](https://github.com/tltneon/lgsl/wiki/features) | [Wiki](https://github.com/tltneon/lgsl/wiki) 




## Install standalone
1. Download
2. Unzip
3. Open main page and proceed the installation
4. Done! Now you can add server.
## Use as Composer library
Install library
```bash
composer require tltneon/lgsl 7.0.0
```
Use that code to query game servers
```php
use tltneon\LGSL;

$server = new LGSL\Server([
    "ip" => "127.0.0.1", // server ip or hostname
    "c_port" => "27015", // for players
    "q_port" => "27015", // for querying
    "type" => "source" // protocol name
]);
$server->queryLive("sep"); // s - server info, e - extra data, p - players info
```
Get server data 
```php
$server->getStatus();
$server->getName();
$server->getIp();
$server->getConnectionPort();
$server->getGame();
$server->getMap();
$server->getPlayersCount();
$server->getConnectionLink();
$server->toArray(); // full data
```

## [Changelog](https://github.com/tltneon/lgsl/wiki/Changelog)
#### v7.0.0
- **PHP version bumped to 7.1+**
- **Fitting to using with Composer**
- **Rewriting LGSL with OOP**
- **Added some tests**
- **Added ability to use another DBs - PostgreSQL and SQLite**
- **Added dynamic sorting by server name, players count, map and address**
- **Added Details sort plugin: sorting by clicking on headings of column**
- **Added new query protocols**
- **Minor fixes**

##### [:: Older versions](https://github.com/tltneon/lgsl/wiki/Changelog)

Original author of [LGSL](https://github.com/tltneon/lgsl/releases/tag/v5.8) - Richard Perry (www.greycube.com)
