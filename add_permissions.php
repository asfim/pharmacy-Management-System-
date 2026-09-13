<?php
/**
 * This script adds @can permission checks around action buttons
 * (edit, delete, create) in all admin blade view files.
 */

$viewsDir = __DIR__ . '/resources/views/admin';

// Module mapping: directory => permission module name
$moduleMap = [
    'medicines' => 'medicines',
    'categories' => 'categories',
    'sub_categories' => 'sub_categories',
    'generics' => 'generics',
    'brands' => 'brands',
    'manufacturers' => 'manufacturers',
    'batches' => 'batches',
    'sales' => 'sales',
    'sale_returns' => 'sale_returns',
    'purchases' => 'purchases',
    'suppliers' => 'suppliers',
    'customers' => 'customers',
    'doctors' => 'doctors',
    'prescriptions' => 'prescriptions',
    'employees' => 'employees',
    'attendances' => 'attendances',
    'payrolls' => 'payrolls',
    'accounts' => 'accounts',
    'expenses' => 'expenses',
    'incomes' => 'incomes',
    'branches' => 'branches',
    'users' => 'users',
    'roles' => 'roles',
    'orders' => 'orders',
    'coupons' => 'orders',
    'damages' => 'stock',
    'stock' => 'stock',
    'expense_categories' => 'expenses',
];

$changedFiles = [];

foreach ($moduleMap as $dir => $module) {
    $dirPath = $viewsDir . '/' . $dir;
    if (!is_dir($dirPath)) continue;

    // Process all blade files in this directory and subdirectories
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dirPath)
    );

    foreach ($iterator as $file) {
        if ($file->getExtension() !== 'php') continue;
        $filePath = $file->getPathname();
        $content = file_get_contents($filePath);
        $originalContent = $content;
        $basename = basename($filePath);

        // Skip if already has @can checks
        if (strpos($content, "@can('edit {$module}')") !== false) continue;

        // --- INDEX files: Wrap "Add" / "Create" buttons ---
        if ($basename === 'index.blade.php') {
            // Wrap delete form buttons with @can('delete ...')
            // Pattern: <form ... destroy ... </form>
            $content = preg_replace(
                '/([ \t]*)(<form[^>]*(?:destroy|DELETE)[^>]*>.*?<\/form>)/s',
                "$1@can('delete {$module}')\n$1$2\n$1@endcan",
                $content
            );

            // Wrap edit links with @can('edit ...')
            $content = preg_replace(
                '/([ \t]*)(<a[^>]*\.edit[^>]*>.*?<\/a>)/s',
                "$1@can('edit {$module}')\n$1$2\n$1@endcan",
                $content
            );

            // Wrap "Add" / "Create" links (teal buttons typically)
            $content = preg_replace(
                '/([ \t]*)(<a[^>]*\.create[^>]*>.*?<\/a>)/s',
                "$1@can('create {$module}')\n$1$2\n$1@endcan",
                $content
            );
        }

        // --- PARTIALS (table_rows etc): Same patterns ---
        if (strpos($basename, 'table_rows') !== false || strpos($filePath, 'partials') !== false) {
            if (strpos($content, "@can('delete") === false) {
                $content = preg_replace(
                    '/([ \t]*)(<form[^>]*(?:destroy|DELETE)[^>]*>.*?<\/form>)/s',
                    "$1@can('delete {$module}')\n$1$2\n$1@endcan",
                    $content
                );
            }
            if (strpos($content, "@can('edit") === false) {
                $content = preg_replace(
                    '/([ \t]*)(<a[^>]*\.edit[^>]*>.*?<\/a>)/s',
                    "$1@can('edit {$module}')\n$1$2\n$1@endcan",
                    $content
                );
            }
        }

        if ($content !== $originalContent) {
            file_put_contents($filePath, $content);
            $changedFiles[] = str_replace(__DIR__ . '/', '', $filePath);
        }
    }
}

echo "Permission checks added to " . count($changedFiles) . " files:\n";
foreach ($changedFiles as $f) {
    echo "  ✓ $f\n";
}
