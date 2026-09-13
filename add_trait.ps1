$models = @("Account", "Attendance", "DamageWastage", "Employee", "Expense", "FinancialTransaction", "Income", "Payroll", "PurchaseInvoice", "Sale", "SalesReturn", "StockAdjustment", "StockBalance", "StockLedger")

foreach ($model in $models) {
    $path = "c:\xampp\htdocs\pharmacy\app\Models\$model.php"
    if (Test-Path $path) {
        $content = Get-Content $path -Raw
        
        # Don't add if already added
        if ($content -notmatch "use App\\Traits\\BelongsToBranch;") {
            $content = $content -replace "(use Illuminate\\Database\\Eloquent\\Model;)", "`$1`nuse App\Traits\BelongsToBranch;"
            $content = $content -replace "(class $model extends Model\s*\{)", "`$1`n`tuse BelongsToBranch;`n"
            Set-Content $path $content
        }
    }
}
