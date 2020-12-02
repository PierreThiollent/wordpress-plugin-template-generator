# WordPress template plugin generator

This app is a PHP CLI for generating WordPress plugin template based on WordPress Plugin Boilerplate by Tom McFarlin [(wppb.io)](http://wppb.io).

![](./wpgp.png)

## Requirements 🔧

| Dependency | Version |
| ---------- | :-----: |
| PHP        | >= 7.4  |
| Composer   |         |

### Installation 🔄

```shell
git clone https://github.com/PierreThiollent/wordpress-plugin-template-generator.git
```

```shell
cd wordpress-plugin-template-generator
```

```shell
composer install
```

### Use 🚀

Generate a plugin

```php
php wpgp.php generate
```

It will ask you for the plugin slug, plugin name, plugin uri, author name, author email and author uri.
The generated plugin will be available in /project/source/plugin-slug
