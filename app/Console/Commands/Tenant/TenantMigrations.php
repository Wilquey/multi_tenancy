<?php

namespace App\Console\Commands\Tenant;

use Illuminate\Support\Facades\Artisan;
use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;

class TenantMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrations {id?} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Migrations Tenants';

    private $tenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();

        $this->tenant = $tenant;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($id = $this->argument('id')) {
            $company = Company::find($id);

            if($company)
                $this->execCommand($company);

            return;
        }

        $companies = Company::all();

        foreach ($companies as $company) {
            $this->execCommand($company);
        }
    }

    public function execCommand(Company $company)
    {
        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        $id = $this->argument('id');

        $this->tenant->setConnection($company);

        $textoId = $id ? "id:$id" : '';

        $this->info("Connecting Company {$company->name} | {$command} | ($textoId)");

        $run = Artisan::call($command, [
            '--force' => true,
            '--path' => '/database/migrations/tenant',
        ]);
        if ($run === 0) {
            Artisan::call('db:seed', [
                '--class' => 'TenantsTableSeeder',
            ]);

            $this->info("Success Sucesso {$company->name}");
        }

        $this->info("End Connecting Company {$company->name} | {$command} | ($textoId)");
        $this->info('---------------------------------------');
    }
}
