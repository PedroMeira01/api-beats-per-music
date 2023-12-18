<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateTablesCommand extends Command
{
    protected $signature = 'clean:truncate_table {table}';

    protected $description = 'Limpa todos os registros de uma tabela';

    public function handle()
    {
        $table = $this->argument('table');
        
        try {
            DB::table('orders')->truncate();
            $this->info('Registros removidos com sucesso da tabela ' . $table);
        } catch (\Exception $e) {
            $this->error('Erro ao limpar registros da tabela ' . $table . ': ' . $e->getMessage());
        }
    }
}
