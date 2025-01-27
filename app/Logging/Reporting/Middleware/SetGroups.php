<?php
/**
 * SetGroups.php
 *
 * -Description-
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @link       https://www.librenms.org
 *
 * @copyright  2022 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Logging\Reporting\Middleware;

use Facade\FlareClient\Report;
use LibreNMS\Util\Version;

class SetGroups
{
    /**
     * Middleware to set LibreNMS and Tools grouping data
     *
     * @param  \Facade\FlareClient\Report  $report
     * @param  callable  $next
     * @return mixed
     */
    public function handle(Report $report, $next)
    {
        try {
            $version = Version::get();

            $report->group('LibreNMS', [
                'Git version' => $version->local(),
                'App version' => Version::VERSION,
            ]);

            $report->group('Tools', [
                'Database' => $version->databaseServer(),
                'Net-SNMP' => $version->netSnmp(),
                'Python' => $version->python(),
                'RRDtool' => $version->rrdtool(),

            ]);
        } catch (\Exception $e) {
        }

        return $next($report);
    }
}
