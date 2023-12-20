[![GitHub release (latest by date)](https://img.shields.io/github/v/release/tltneon/lgsl?color=green&style=for-the-badge)](https://github.com/tltneon/lgsl/releases)
![PHP](https://img.shields.io/badge/PHP-7.1+-brightgreen?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-5.5+-brightgreen?style=for-the-badge&logo=mysql)
![MariaDB](https://img.shields.io/badge/MariaDB-5.5+-brightgreen?style=for-the-badge&logo=mariadb)
![SQLite](https://img.shields.io/badge/SQLite-3-brightgreen?style=for-the-badge&logo=sql)

[![GitHub contributors](https://img.shields.io/github/contributors/tltneon/lgsl?style=for-the-badge)](https://github.com/tltneon/lgsl/graphs/contributors)
[![GitHub stars](https://img.shields.io/github/stars/tltneon/lgsl?style=for-the-badge)](https://github.com/tltneon/lgsl/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/tltneon/lgsl?style=for-the-badge)](https://github.com/tltneon/lgsl/fork)
[![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/tltneon/lgsl?style=for-the-badge)](https://github.com/tltneon/lgsl/archive/master.zip)
[![Packagist](https://img.shields.io/packagist/l/tltneon/lgsl?style=for-the-badge)](https://github.com/tltneon/lgsl/blob/master/LICENSE)
# LGSL v7.0.0 (Live Game Server List)
Modern branch of LGSL that brings new abilities. That branch is experimental, unstable and may be heavily changed in future.

## [Live DEMOs](https://github.com/tltneon/lgsl/wiki/Who-uses-LGSL) | [How to install]( https://github.com/tltneon/lgsl/wiki/How-to-install-LGSL) | [Supported games](https://github.com/tltneon/lgsl/wiki/Supported-Games,-Query-protocols,-Default-ports) | [Features list](https://github.com/tltneon/lgsl/wiki/features) | [Wiki](https://github.com/tltneon/lgsl/wiki) 

Feel free to make [pull request](https://github.com/tltneon/lgsl)! Also you can suggest any [ideas about new features](https://github.com/tltneon/lgsl/issues).

### Server List on laptop
![lgsl Server List on laptop](https://i.imgur.com/oU2x9Y5.png)
### Server List on mobile device
![lgsl Server List on mobile device](https://i.imgur.com/oui8Nya.png)

## Install standalone
1. Download
2. Unzip
3. Open main page and proceed the installation
4. Done! Now you can add server.
## Add as Composer library
Install library
```bash
composer require tltneon/lgsl
```
Use that code to query game servers
```php
use tltneon\LGSL;

$server = new LGSL\Server([
    "ip" => "127.0.0.1", // server ip or hostname
    "c_port" => "27015", // for players
    "q_port" => "27015", // for querying
    "type" => "source" // protocol name from lgsl_type_list()
]);
$server->lgsl_live_query("sep"); // s - server info, e - extra data, p - players info
```
Get server data 
```php
$server->get_name();
$server->get_ip();
$server->get_c_port();
$server->get_game();
$server->get_map();
$server->get_players_count();
$server->get_software_link();
$server->to_array(); // full data
```

## [Changelog](https://github.com/tltneon/lgsl/wiki/Changelog)
#### v7.0.0
- **Rewrited LGSL using OOP**
- **Added dynamic sorting by server name, players count, map and address**
- **Added Details sort plugin: sorting by clicking on headings of column**
- **Minor fixes**

##### [:: Older versions](https://github.com/tltneon/lgsl/wiki/Changelog)

Original author of [LGSL](https://github.com/tltneon/lgsl/releases/tag/v5.8) - Richard Perry (www.greycube.com)
