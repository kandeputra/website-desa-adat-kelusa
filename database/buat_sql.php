<?php
// Membuat database/kelusa.sql (MySQL) dari migrasi + seeder tanpa server MySQL (mode pretend).
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
config(['database.default' => 'mysql', 'database.connections.mysql.host' => '0.0.0.0', 'cache.default' => 'array']);
$db = Illuminate\Support\Facades\DB::connection('mysql');
$fake = new PDO('sqlite::memory:'); $db->setPdo($fake)->setReadPdo($fake);
$files = glob(__DIR__.'/migrations/*.php'); sort($files);
$queries = $db->pretend(function () use ($files) {
    foreach ($files as $f) { $m = require $f; $m->up(); }
    (new Database\Seeders\DatabaseSeeder)->run();
});
$pdoQuote = fn ($v) => $v === null ? 'NULL' : (is_bool($v) ? ($v ? '1' : '0') : (is_int($v) || is_float($v) ? $v : "'".str_replace(["\\", "'", "\n", "\r"], ["\\\\", "\\'", "\\n", "\\r"], (string) $v)."'"));
$out = "-- Database Desa Adat Kelusa (MySQL/MariaDB)\n-- Dibuat ".date('Y-m-d H:i')." dari migrasi & seeder. Impor lewat phpMyAdmin.\nSET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\n\n";
foreach ($queries as $q) {
    if (preg_match('/^\s*select/i', $q['query'])) continue;
    $sql = $q['query'];
    foreach ($q['bindings'] as $b) {
        if ($b instanceof DateTimeInterface) $b = $b->format('Y-m-d H:i:s');
        $sql = preg_replace('/\?/', str_replace(['\\', '$'], ['\\\\', '\\$'], (string) $pdoQuote($b)), $sql, 1);
    }
    if (str_starts_with($sql, 'insert into `posts`')) $sql = preg_replace("/null, ('[0-9: -]+'), ('[0-9: -]+')\)$/", '1, $1, $2)', $sql); // penulis = Super Admin (id 1)
    $out .= $sql.";\n";
}
$out .= "\nCREATE TABLE IF NOT EXISTS `migrations` (`id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY, `migration` varchar(255) NOT NULL, `batch` int NOT NULL) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
foreach ($files as $f) $out .= "INSERT INTO `migrations` (`migration`, `batch`) VALUES ('".basename($f, '.php')."', 1);\n";
$out .= "\nSET FOREIGN_KEY_CHECKS=1;\n";
file_put_contents(__DIR__.'/kelusa.sql', $out);
echo count($queries)." kueri\n";
