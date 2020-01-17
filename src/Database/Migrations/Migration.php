<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2019 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 * @author Christian Graf <c.graf@datamedrix.com>
 */

declare(strict_types=1);

namespace DMX\Support\Database\Migrations;

use Illuminate\Database\DatabaseManager;
use DMX\Support\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Illuminate\Database\Migrations\Migration as BaseMigration;

class Migration extends BaseMigration
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
     * Migration constructor.
     *
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager = null)
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
        return strtolower($this->getDriverName()) === strtolower($driverName);
    }

    /**
     * @return bool
     */
    protected function usingMySQL(): bool
    {
        return $this->usingDriver('mysql');
    }

    /**
     * @return bool
     */
    protected function usingPostgreSQL(): bool
    {
        return $this->usingDriver('pgsql');
    }

    /**
     * @return bool
     */
    protected function usingMSSQL(): bool
    {
        return $this->usingDriver('sqlsrv');
    }

    /**
     * @return bool
     */
    protected function usingSqlLite(): bool
    {
        return $this->usingDriver('sqlite');
    }
}
