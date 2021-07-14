<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2021 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 * @author        Christian Graf <c.graf@datamedrix.com>
 */

declare(strict_types=1);

namespace DMX\Support\Database;

class ConnectionManager
{
    const DRIVER_MYSQL = 'mysql';
    const DRIVER_POSTGRESQL = 'pgsql';
    const DRIVER_MSSQL = 'sqlsrv';
    const DRIVER_SQLITE = 'sqlite';
}
