<?php

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// 加载配置
$config = require __DIR__ . '/config.php';

// 获取请求的URI
$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);

// 移除开头的斜杠
$path = ltrim($path, '/');

// 处理静态资源
if (preg_match('/\.(css|js|jpg|jpeg|png|gif|ico|svg)$/i', $path)) {
    $filePath = __DIR__ . '/assets/' . $path;
    if (file_exists($filePath)) {
        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'ico' => 'image/x-icon',
            'svg' => 'image/svg+xml'
        ];
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (isset($mimeTypes[$extension])) {
            header('Content-Type: ' . $mimeTypes[$extension]);
        }
        readfile($filePath);
        exit;
    }
}

// 如果路径为空，默认显示index.twig
if (empty($path)) {
    $path = 'index.twig';
}

// 如果路径不以.twig结尾，添加后缀
if (!preg_match('/\.twig$/', $path)) {
    $path .= '.twig';
}

// 设置模板加载器
$loader = new FilesystemLoader($config['templates_dir']);

// 创建Twig环境
$twig = new Environment($loader, [
    'cache' => $config['debug'] ? false : $config['cache_dir'],
    'debug' => $config['debug'],
    'auto_reload' => true,
]);

try {
    // 尝试加载对应的数据文件
    $dataFile = $config['data_dir'] . '/' . str_replace('.twig', '.php', $path);
    $data = [];
    if (file_exists($dataFile)) {
        $data = require $dataFile;
    }
    
    // 渲染模板
    echo $twig->render($path, $data);
} catch (\Twig\Error\LoaderError $e) {
    // 模板不存在
    header("HTTP/1.0 404 Not Found");
    echo "模板文件不存在: " . $path;
} catch (\Exception $e) {
    // 其他错误
    header("HTTP/1.0 500 Internal Server Error");
    if ($config['debug']) {
        echo "错误: " . $e->getMessage();
    } else {
        echo "服务器内部错误";
    }
} 