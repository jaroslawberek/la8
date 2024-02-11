<?php

namespace Illuminate\Database\Console\Migrations;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MigrateMakeCommand extends BaseCommand
{

    private $fieldResource = [
        'varchar' => [
            'faker' => '$faker->word()',
            'migration' => 'string',
        ],
        'char' => [
            'faker' => '$faker->word()',
            'migration' => 'string',
        ],
        'text' => [
            'faker' => '$faker->sentens()',
            'migration' => 'text',
        ],
        'int' => [
            'faker' => '$faker->random_int(1, 10)',
            'migration' => 'integer',
        ],
        'bigint' => [
            'faker' => '$faker->randomNumber(9, false)',
            'migration' => 'bigInteger',
        ],
        'timestamp' => [
            'faker' => "\$faker->dateTimeBetween()->format('Y-m-d')",
            'migration' => 'timestamp',
        ],
        'enum' => [
            'faker' => '$faker->',
            'migration' => 'enum',
        ],
        'decimal' => [
            'faker' => '$faker->random_int(1, 10)',
            'migration' => 'decimal',
        ],

    ];

    private function getTableFields($table)
    {
        return (DB::select("SELECT TABLE_SCHEMA,`TABLE_NAME`, COLUMN_NAME, IS_NULLABLE,DATA_TYPE,
                                CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE, 
                                COLUMN_COMMENT, if(isc.DATA_TYPE = 'enum', REPLACE(trim(leading 'enum(' from isc.column_type),')',''),isc.column_type ) as specyfic_kolumn,
                                (SELECT 
                                        REFERENCED_TABLE_NAME
                                        FROM
                                        INFORMATION_SCHEMA.KEY_COLUMN_USAGE isk
                                        WHERE
                                        CONSTRAINT_NAME <>'PRIMARY' AND  isk.`COLUMN_NAME` = isc.`COLUMN_NAME` AND
                                        TABLE_SCHEMA = 'db_test' AND
                                        TABLE_NAME = '{$table}') as foriegen_table,
                                (SELECT 
                                        REFERENCED_COLUMN_NAME
                                        FROM
                                        INFORMATION_SCHEMA.KEY_COLUMN_USAGE isk
                                        WHERE
                                        CONSTRAINT_NAME <>'PRIMARY' AND  isk.`COLUMN_NAME` = isc.`COLUMN_NAME` AND
                                        TABLE_SCHEMA = 'db_test' AND
                                        TABLE_NAME = '{$table}') as foriegen_field
                                FROM information_schema.COLUMNS  isc                 
                            WHERE   TABLE_SCHEMA ='db_test' and `TABLE_NAME` like '%{$table}%' and `COLUMN_NAME` not in ('id', 'updated_at','created_at', 'del')"));
    }

    public function createMigration($table)
    {
        $fields = $this->getTableFields($table);
        $migratonFields = "\n";

        foreach ($fields as $field) {

            $migratonFields .= "\$table->" . ($field->foriegen_table != "" ? "unsignedBigInteger" : $this->fieldResource[$field->DATA_TYPE]['migration']);
            if (($field->DATA_TYPE === "int") || ($field->DATA_TYPE === "bigint")) {
                if ($field->foriegen_table != "") {
                    $migratonFields .= "('" . $field->COLUMN_NAME . "')" . ($field->IS_NULLABLE == "YES" ? "->nullable(true)->defoult(0);" : "->defoult(0);\n");
                    $migratonFields .= "\$table->" . 'foreign' . "('" . $field->COLUMN_NAME . "')->references('" . "id" . "')->on('" . $field->foriegen_table . "')";
                } else  $migratonFields .= "('" . $field->COLUMN_NAME . "')" . ($field->IS_NULLABLE == "YES" ? "->nullable(true)" : "");
            } else if (($field->DATA_TYPE === "char") || ($field->DATA_TYPE === "varchar")) {
                $migratonFields .= "('" . $field->COLUMN_NAME . "'," . $field->CHARACTER_MAXIMUM_LENGTH . ")" . ($field->IS_NULLABLE == "YES" ? "->nullable(true)" : "");
            } else if ($field->DATA_TYPE === "text") {
                $migratonFields .= "('" . $field->COLUMN_NAME . "')" . ($field->IS_NULLABLE == "YES" ? "->nullable(true)" : "");
            } else if ($field->DATA_TYPE === "timestamp") {
                $migratonFields .= "('" . $field->COLUMN_NAME . "')" . ($field->IS_NULLABLE == "YES" ? "->nullable(true)" : "");
            } else if ($field->DATA_TYPE === "enum") {
                $migratonFields .= "('" . $field->COLUMN_NAME . "',[" . $field->specyfic_kolumn . "])" . ($field->IS_NULLABLE == "YES" ? "->nullable(true)" : "");
            }
            $migratonFields .= ";\n";
        }
        dump($migratonFields);
        return $migratonFields;
    }
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:migration {name : The name of the migration}
        {--create= : The table to be created}
        {--table= : The table to migrate}
        {--path= : The location where the migration file should be created}
        {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
        {--fullpath : Output the full path of the migration}
        {--createfields : Tworzy pola migracji dla pol tabeli}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration file';

    /**
     * The migration creator instance.
     *
     * @var \Illuminate\Database\Migrations\MigrationCreator
     */
    protected $creator;

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new migration install command instance.
     *
     * @param  \Illuminate\Database\Migrations\MigrationCreator  $creator
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(MigrationCreator $creator, Composer $composer)
    {
        parent::__construct();

        $this->creator = $creator;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // It's possible for the developer to specify the tables to modify in this
        // schema operation. The developer may also specify if this table needs
        // to be freshly created so we can create the appropriate migrations.
        $name = Str::snake(trim($this->input->getArgument('name')));
        dump($this->getOptions());
        $table = $this->input->getOption('table');

        $create = $this->input->getOption('create') ?: false;

        // If no table was given as an option but a create option is given then we
        // will use the "create" option as the table name. This allows the devs
        // to pass a table name into this option as a short-cut for creating.
        if (!$table && is_string($create)) {
            $table = $create;

            $create = true;
        }

        // Next, we will attempt to guess the table name if this the migration has
        // "create" in the name. This will allow us to provide a convenient way
        // of creating migrations that create new tables for the application.
        if (!$table) {
            [$table, $create] = TableGuesser::guess($name);
        }

        // Now we are ready to write the migration out to disk. Once we've written
        // the migration out, we will dump-autoload for the entire framework to
        // make sure that the migrations are registered by the class loaders.
        $f = $this->writeMigration($name, $table, $create);
        if ($this->input->getOption('createfields')) {
            //todo do zronienia pola migracji
            $fields = $this->createMigration($table);
            $migrateFile = File::get($f);
            $migrateFile = Str::replace('jb-migration-fields',$fields,$migrateFile );
            File::put($f, $migrateFile);
            dump("Utworzono migracje z polami w tabeli dla : " . $f);
        }
        $this->composer->dumpAutoloads() ;
    }

    /**
     * Write the migration file to disk.
     *
     * @param  string  $name
     * @param  string  $table
     * @param  bool  $create
     * @return string
     */
    protected function writeMigration($name, $table, $create)
    {
        $file = $this->creator->create(
            $name,
            $this->getMigrationPath(),
            $table,
            $create
        );
        $f = $file;
        if (!$this->option('fullpath')) {
            $file = pathinfo($file, PATHINFO_FILENAME);
        }

        $this->line("<info>Created Migration:</info> {$file}");
        return $f;
    }

    /**
     * Get migration path (either specified by '--path' option or default location).
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        if (!is_null($targetPath = $this->input->getOption('path'))) {
            return !$this->usingRealPath()
                ? $this->laravel->basePath() . '/' . $targetPath
                : $targetPath;
        }

        return parent::getMigrationPath();
    }
}
