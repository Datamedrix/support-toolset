<?php

declare(strict_types=1);

namespace DMX\Support\Database;

class ConnectionManager
{
    public const DRIVER_MYSQL = 'mysql';
    public const DRIVER_POSTGRESQL = 'pgsql';
    public const DRIVER_MSSQL = 'sqlsrv';
    public const DRIVER_SQLITE = 'sqlite';

    public const SCHEMA_TABLE_CONCAT_DELIMITER = '__';

    /**
     * Checks the designated driver is supporting database schemas.
     *
     * @param string $driverName
     *
     * @return bool
     */
    public static function isDriverSupportingSchemas(string $driverName): bool
    {
        $driverName = trim($driverName);
        if (empty($driverName)) {
            return false;
        }

        return in_array(
            strtolower($driverName),
            [
                self::DRIVER_POSTGRESQL,
                self::DRIVER_MSSQL,
            ]
        );
    }

    /**
     * @param string      $tableName
     * @param string|null $schemaName
     * @param string|null $driverName
     * @param string      $schemaTableConcatDelimiter Default "__"
     *
     * @return string
     */
    public static function mutateTableName(string $tableName, ?string $schemaName = null, ?string $driverName = null, string $schemaTableConcatDelimiter = self::SCHEMA_TABLE_CONCAT_DELIMITER): string
    {
        $tableName = trim($tableName);
        if (!empty($schemaName)) {
            if (self::isDriverSupportingSchemas((string) $driverName)) {
                if (str_contains($tableName, '.')) {
                    // if a schema is already added to the table name, do not add them twice!
                    return $tableName;
                }

                return $schemaName . '.' . $tableName;
            }

            if (str_contains($tableName, $schemaName . $schemaTableConcatDelimiter)) {
                // if a schema name is already added to the table name, do not add them twice!
                return $tableName;
            }

            return $schemaName . $schemaTableConcatDelimiter . $tableName;
        }

        return $tableName;
    }
}
