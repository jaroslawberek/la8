<?php

namespace Illuminate\Foundation\Console;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends GeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:jmodel {name} {--relations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';
    public $modalFile = "";
    public $modalPath = "";


    public function createHasMany()
    {
        $name = Str::plural($this->argument('name'));
        $schema = env('DB_DATABASE');
        $belowTo = DB::select("SELECT 
                                TABLE_NAME, COLUMN_NAME
                              FROM
                                INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                              WHERE
                                CONSTRAINT_NAME <> 'PRIMARY'
                                    AND TABLE_SCHEMA = '{$schema}'
                                    AND REFERENCED_TABLE_NAME = '{$name}'");
        $temp = "";
        foreach ($belowTo as $row) {
            $row->TABLE_NAME = Str::singular($row->TABLE_NAME);
            $temp .= "public function {$row->TABLE_NAME}()
                        {
                            return \$this->hasMany({$row->TABLE_NAME}::class, '{$row->COLUMN_NAME}', 'id');
                        }
                    ";
        }
        $pos = strrpos($this->modalFile, '}', -1);
        //$f = str_replace('//relations',  $temp, $this->modalFile,);
        $f = substr_replace($this->modalFile, $temp . "\n}", $pos);
        File::put($this->modalPath, $f);
        dump($f);
    }
    public function createBelongs()
    {
        $name = Str::plural($this->argument('name'));
        $schema = env('DB_DATABASE');
        $belowTo = DB::select("SELECT 
                            COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
                            FROM
                            INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                              WHERE
                            CONSTRAINT_NAME <> 'PRIMARY'
                                AND TABLE_SCHEMA = '{$schema}'
                                AND TABLE_NAME = '{$name}'");
        $temp = "";
        foreach ($belowTo as $row) {
            $row->REFERENCED_TABLE_NAME = Str::singular($row->REFERENCED_TABLE_NAME);
            $temp .= "public function {$row->REFERENCED_TABLE_NAME}()
                        {
                            return \$this->belongsTo({$row->REFERENCED_TABLE_NAME}::class, '{$row->COLUMN_NAME}', '{$row->REFERENCED_COLUMN_NAME}');
                        }
                    ";
        }
        
        $pos = strrpos($this->modalFile, '}', -1);
        //$f = str_replace('//relations',  $temp, $this->modalFile,);
        $f = substr_replace($this->modalFile, $temp . "\n}", $pos);
        dump($f);
        File::put($this->modalPath, $f);
        $this->modalFile = $f;
    }
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && !$this->option('force')) {
            return false;
        }

        // $this->getPath($name);
        $this->modalPath = app_path("Models\\" . $this->getNameInput() . ".php");
        $this->modalFile = File::get($this->modalPath);

        if ($this->option('relations') == true) {
            $this->createBelongs();
            $this->createHasMany();
        }


        if ($this->option('all')) {
            $this->input->setOption('factory', true);
            $this->input->setOption('seed', true);
            $this->input->setOption('migration', true);
            $this->input->setOption('controller', true);
            $this->input->setOption('policy', true);
            $this->input->setOption('resource', true);
        }

        if ($this->option('factory')) {
            $this->createFactory();
        }

        if ($this->option('migration')) {
            $this->createMigration();
        }

        if ($this->option('seed')) {
            $this->createSeeder();
        }

        if ($this->option('controller') || $this->option('resource') || $this->option('api')) {
            $this->createController();
        }

        if ($this->option('policy')) {
            $this->createPolicy();
        }
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createFactory()
    {
        $factory = Str::studly($this->argument('name'));

        $this->call('make:factory', [
            'name' => "{$factory}Factory",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $migrat = null;
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $migrat =  $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
            '--createfields' => $table,

        ]);
        return $migrat;
    }

    /**
     * Create a seeder file for the model.
     *
     * @return void
     */
    protected function createSeeder()
    {
        $seeder = Str::studly(class_basename($this->argument('name')));

        $this->call('make:jseeder', [
            'name' => "{$seeder}Seeder",
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:jcontroller', array_filter([
            'name' => "{$controller}",
            '--model' => $this->option('resource') || $this->option('api') ? $modelName : null,
            '--api' => $this->option('api'),
            '--requests' => $this->option('requests') || $this->option('all'),
        ]));
    }

    /**
     * Create a policy file for the model.
     *
     * @return void
     */
    protected function createPolicy()
    {
        $policy = Str::studly(class_basename($this->argument('name')));

        $this->call('make:policy', [
            'name' => "{$policy}Policy",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->option('pivot')
            ? $this->resolveStubPath('/stubs/model.pivot.stub')
            : $this->resolveStubPath('/stubs/model.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return is_dir(app_path('Models')) ? $rootNamespace . '\\Models' : $rootNamespace;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, seeder, factory, policy, and resource controller for the model'],
            ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the model'],
            ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the model'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model'],
            ['policy', null, InputOption::VALUE_NONE, 'Create a new policy for the model'],
            ['seed', 's', InputOption::VALUE_NONE, 'Create a new seeder for the model'],
            ['pivot', 'p', InputOption::VALUE_NONE, 'Indicates if the generated model should be a custom intermediate table model'],
            ['resource', 'r', InputOption::VALUE_NONE, 'Indicates if the generated controller should be a resource controller'],
            ['api', null, InputOption::VALUE_NONE, 'Indicates if the generated controller should be an API controller'],
            ['requests', 'R', InputOption::VALUE_NONE, 'Create new form request classes and use them in the resource controller'],
            ['relations', 'Re', InputOption::VALUE_NONE, ''],
            ['withtable', 'wt', InputOption::VALUE_NONE, ''],
            ['createfields', 'cf', InputOption::VALUE_NONE, ''],
        ];
    }
}

// namespace App\Console\Commands;

// use Illuminate\Support\Facades\File;
// use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str;

// class jarek2 extends Command
// {
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'make:jmodel{name}';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Command description';

//     /**
//      * Create a new command instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         parent::__construct();
//     }

//     /**
//      * Execute the console command.
//      *
//      * @return int
//      */
//     public function handle()
//     {
//         $factory = Str::studly($this->argument('name'));
//         $this->info($factory);
//         $i = $this->call('make:model', [
//             'name' => $this->argument("name"),

//         ]);

//         $this->info($i);
//         return 0;
//     }
// }



    // $this->info('app_path - ' . app_path());
        // $this->info('base_path - ' . base_path());
        // $this->info('config_path - ' . config_path());
        // $this->info('database_path - ' . database_path());
        // $this->info('resource_path - ' . resource_path());
        // $this->info('storage_path - ' . storage_path());
        // if (File::append(app_path('Models\Persons.php'), "kutass")) {
        //     $this->info('Istnieje Persons');
        // } else $this->info('nie iestnieje');
      //  $r = File::files(app_path('http\controllers'));
        //$r = $r[0];
        //dump($r[0]);
       // dump($r[0]->getFilename());

       // $r = File::directories(app_path('http'));
       // File::put(app_path('http/t.txt'), "cos tam");
       // File::append(app_path('http/t.txt'), "cos tam2");
       // $this->info(File::get(app_path("http/t.txt")));
        //dump($r);
        // $this->info($r[0]['fileName']);
        // dump($this->option("queue"));
        // dump($this->option("dupa"));
        // dump($this->signature);
        // dump($this->name);
       // dump($this->argument("user"));
        // $this->call('make:jarekcontroller', array_filter(['name' => "kutafon2", "--resource" => true]));
        // dump($this->arguments());
