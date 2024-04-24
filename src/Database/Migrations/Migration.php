<?php

declare(strict_types=1);

namespace DMX\Support\Database\Migrations;

use Closure;
use RuntimeException;
use Illuminate\Database\DatabaseManager;
use DMX\Support\Database\Schema\Blueprint;
use DMX\Support\Database\ConnectionManager;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Migrations\Migration as BaseMigration;
use Illuminate\Database\Schema\Blueprint as IlluminateBlueprint;

abstract class Migration extends BaseMigration
{
    /**
     * @var DatabaseManager
     */
    private DatabaseManager $databaseManager;

    /**
     * @var SchemaBuilder
     */
    private SchemaBuilder $schemaBuilder;

    /**
     * @var string
     */
    protected string $schemaTableConcatDelimiter = ConnectionManager::SCHEMA_TABLE_CONCAT_DELIMITER;

    /**
     * Class name of the blueprint to use.
     * The class have to be inherited from `Illuminate\Database\Schema\Blueprint`.
     *
     * @var string
     */
    protected string $blueprintClass = Blueprint::class;

    /**
     * Migration constructor.
     *
     * @param DatabaseManager|null $databaseManager
     */
    public function __construct(?DatabaseManager $databaseManager = null)
    {
        if ($databaseManager === null) {
            if (function_exists('app')) {
                // @codeCoverageIgnoreStart
                try {
                    $databaseManager = app()->make(DatabaseManager::class, []);
                } catch (BindingResolutionException) {
                    throw new RuntimeException('Unable to create migration, an instance of ' . DatabaseManager::class . ' could not be resolved!');
                }
            // @codeCoverageIgnoreEnd
            } else {
                throw new RuntimeException('Unable to create migration, there is no application dependency container available!');
            }
        }

        $this->databaseManager = $databaseManager;
        $this->schemaBuilder = $this->databaseManager->connection($this->getConnection())->getSchemaBuilder();

        if (!empty($this->blueprintClass)) {
            $blueprintClass = $this->blueprintClass;
            $this->schemaBuilder->blueprintResolver(function (string $table, ?Closure $callback = null) use ($blueprintClass): IlluminateBlueprint {
                // @codeCoverageIgnoreStart
                return new $blueprintClass($table, $callback);
                // @codeCoverageIgnoreEnd
            });
        }
    }

    /**
     * Get the configured database manager instance.
     *
     * @return DatabaseManager
     */
    protected function dbm(): DatabaseManager
    {
        return $this->databaseManager;
    }

    /**
     * Get the schema builder instances received from the database manager.
     * Helper method to prevent using the support facade `Illuminate\Support\Facades\Schema`.
     *
     * @return SchemaBuilder
     */
    protected function schema(): SchemaBuilder
    {
        return $this->schemaBuilder;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    abstract public function up(): void;

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    abstract public function down(): void;

    /**
     * @return string
     */
    protected function getDriverName(): string
    {
        return $this->schemaBuilder->getConnection()->getDriverName();
    }

    /**
     * @param string $driverName
     *
     * @return bool
     */
    protected function usingDriver(string $driverName): bool
    {
        return strtolower($this->getDriverName()) === strtolower(trim($driverName));
    }

    /**
     * @return bool
     */
    protected function usingMySQL(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_MYSQL);
    }

    /**
     * @return bool
     */
    protected function usingPostgreSQL(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_POSTGRESQL);
    }

    /**
     * @return bool
     */
    protected function usingMSSQL(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_MSSQL);
    }

    /**
     * @return bool
     */
    protected function usingSqlLite(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_SQLITE);
    }

    /**
     * @return bool
     */
    protected function currentDriverSupportsSchemas(): bool
    {
        return $this->usingPostgreSQL() || $this->usingMSSQL();
    }

    /**
     * @param string      $tableName
     * @param string|null $schemaName
     *
     * @return string
     */
    protected function mutateTableName(string $tableName, ?string $schemaName = null): string
    {
        return ConnectionManager::mutateTableName(
            trim($tableName),
            $schemaName,
            $this->getDriverName(),
            $this->schemaTableConcatDelimiter
        );
    }

    /**
     * @param string $schemaName
     *
     * @return string|null
     */
    protected function createCreateSchemaSql(string $schemaName): ?string
    {
        if ($this->currentDriverSupportsSchemas()) {
            $schemaName = trim($schemaName);
            $sql = "CREATE SCHEMA IF NOT EXISTS $schemaName;";

            if ($this->usingMSSQL()) {
                $sql = "IF NOT EXISTS (SELECT 1 FROM sys.schemas WHERE name = '$schemaName') BEGIN EXEC( 'CREATE SCHEMA $schemaName'); END";
            }

            return $sql;
        }

        return null;
    }

    /**
     * @param string $schemaName
     *
     * @codeCoverageIgnore
     */
    protected function createSchema(string $schemaName): void
    {
        if ($this->currentDriverSupportsSchemas()) {
            $this->databaseManager->unprepared($this->createCreateSchemaSql($schemaName));
        }
    }

    /**
     * @param string $schemaName
     *
     * @return string|null
     */
    protected function createDropSchemaSql(string $schemaName): ?string
    {
        if ($this->currentDriverSupportsSchemas()) {
            return 'DROP SCHEMA IF EXISTS ' . trim($schemaName) . ';';
        }

        return null;
    }

    /**
     * @param string $schemaName
     *
     * @codeCoverageIgnore
     */
    protected function dropSchema(string $schemaName): void
    {
        if ($this->currentDriverSupportsSchemas()) {
            $this->databaseManager->unprepared($this->createDropSchemaSql($schemaName));
        }
    }
}
