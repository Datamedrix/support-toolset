<?php

declare(strict_types=1);

namespace DMX\Support\Database\Migrations;

use Illuminate\Database\DatabaseManager;
use DMX\Support\Database\Schema\Blueprint;
use DMX\Support\Database\ConnectionManager;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Illuminate\Database\Migrations\Migration as BaseMigration;

abstract class Migration extends BaseMigration
{
    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $dbm;

    /**
     * @var SchemaBuilder
     */
    protected SchemaBuilder $schema;

    /**
     * @var string|null
     */
    protected ?string $baseFilePath = null;

    /**
     * @var string
     */
    protected string $schemaTableConcatDelimiter = ConnectionManager::SCHEMA_TABLE_CONCAT_DELIMITER;

    /**
     * Migration constructor.
     *
     * @param DatabaseManager|null $databaseManager
     */
    public function __construct(?DatabaseManager $databaseManager = null)
    {
        if ($databaseManager === null) {
            if (function_exists('app')) {
                $databaseManager = app()->make(DatabaseManager::class, []);
            } else {
                throw new \InvalidArgumentException('This migration could not be created, because a instance of ' . DatabaseManager::class . ' is missing!');
            }
        }

        $this->dbm = $databaseManager;
        $this->schema = $this->dbm->connection($this->getConnection())->getSchemaBuilder();

        $this->schema->blueprintResolver(function (string $table, \Closure $callback = null): Blueprint {
            // @codeCoverageIgnoreStart
            return new Blueprint($table, $callback);
            // @codeCoverageIgnoreEnd
        });

        if ($this->baseFilePath === null && function_exists('base_path')) {
            // @codeCoverageIgnoreStart
            $this->baseFilePath = base_path('database/migrations');
            // @codeCoverageIgnoreEnd
        }
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
        return $this->schema->getConnection()->getDriverName();
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
    protected function createSchema(string $schemaName)
    {
        if ($this->currentDriverSupportsSchemas()) {
            $this->dbm->unprepared($this->createCreateSchemaSql($schemaName));
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
    protected function dropSchema(string $schemaName)
    {
        if ($this->currentDriverSupportsSchemas()) {
            $this->dbm->unprepared($this->createDropSchemaSql($schemaName));
        }
    }
}
