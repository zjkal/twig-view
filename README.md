# Twig模板预览器

一个简单的Twig模板预览工具，无需配置.htaccess，支持直接访问模板文件。

## 功能特点

- 直接访问Twig模板文件
- 支持模板数据文件
- 无需配置.htaccess
- 支持模板缓存
- 调试模式支持

## 系统要求

- PHP >= 7.4
- Composer
- Web服务器（Apache/Nginx）

## 安装步骤

1. 克隆项目
```bash
git clone [项目地址]
cd twig-view
```

2. 安装依赖
```bash
composer install
```

3. 配置Web服务器
- 将网站根目录指向项目目录
- 确保 `templates`、`data` 和 `cache` 目录有写入权限

## 目录结构

```
twig-view/
├── templates/     # Twig模板文件目录
├── data/         # 模板数据文件目录
├── cache/        # 模板缓存目录
├── config.php    # 配置文件
├── index.php     # 入口文件
└── composer.json # 项目依赖配置
```

## 使用方法

1. 创建模板
- 在 `templates` 目录下创建 `.html.twig` 文件
- 例如：`templates/about.html.twig`

2. 添加数据（可选）
- 在 `data` 目录下创建同名的PHP文件
- 例如：`data/about.php`
```php
<?php
return [
    'title' => '页面标题',
    'content' => '页面内容'
];
```

3. 访问页面
- 访问 `http://your-domain/about` 将显示 `templates/about.html.twig`
- 如果存在 `data/about.php`，其中的数据将被传递给模板

## 配置说明

在 `config.php` 中可以修改以下配置：

- `templates_dir`: 模板目录
- `data_dir`: 数据文件目录
- `debug`: 是否开启调试模式
- `cache_dir`: 缓存目录

## 注意事项

- 确保PHP版本 >= 7.4
- 确保相关目录有正确的写入权限
- 建议在生产环境中关闭调试模式

## 许可证

MIT License 